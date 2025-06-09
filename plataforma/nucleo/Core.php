<?php

/**
 * Clase del núcleo de la plataforma correplayas
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene la funciones esenciales para el funcionamiento de la palatforma web: Conexión con base
 * de datos, envío de correos electrónico, registro de usuarios, inicio y cierre de sesión. Testeo
 * del estado de las cuentas de usuario registradas en la plataforma.
 *
 * @category "Núcleo"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

// 0º) Defino el espacio de nombres de la clase
namespace correplayas\nucleo;

// 1º) Defino los espacios de nombres que voy a utilizar en esta clase
use PDO;
use PDOException;
use correplayas\modelo\Usuario;
use correplayas\modelo\Persona;
use correplayas\modelo\Rol;
use correplayas\excepciones\AppException;
use correplayas\controladores\ErrorController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
use Smarty\Smarty;

// 2º) Defino la clase del nucleo de la plataforma correplayas
class Core {
    
    // Definición de atributos y método por defecto de la clase.
    private static $connDB=null;

    /**
     * Método por DEFECTO para mostrar la página de inicio del backoffice de la plataforma
     *
     * @param Smarty $smarty Objeto del motor de plantillas Samrty
     * @return void No devuelve valor alguno
     */
    public static function default(Smarty $smarty) {
        // Compruebo si hay usuario logueado en la plataforma
        if (isset($_SESSION['usuario'])) {
            // Hay un usuario logueado en la plataforma. Entonces: 
            // Asigno las variables de la plantilla para la página de inicio del backoffice
            $smarty->assign('usuario', Core::nombreUsuario());
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla de la página de inicio del backoffice
            $smarty->display('comunes/backoffice.tpl');
        } else {
            // De lo contario, simplemente muestro la plantilla del portál público de la plataforma corereplayas
            $smarty->display('comunes/portal.tpl');
        }
    }

    /**
     * Método estático privado para establecer el nombre del usuario en la plataforma
     *  >> Su nombre de usuario real si está logueado.
     *  >> Se muestra "Desconocido" si el usuario aún no a iniciado sesión.
     *
     * @return void No devuelve valor alguno
     */
    private static function nombreUsuario() {
        // Si la sesión está NO está establecida devuelvo el nombre de usuario por defecto
        if (!isset($_SESSION['usuario']))
            return  'Desconocido';
        // De lo contario establezco devuelvo el nombre de usuario logueado
        else
            return $_SESSION['usuario']->getUsuario();
    }

    // Bloque-A: Base de datos.

    /**
     * Método estático para abrir una conexión con la base de datos
     *
     * @return mixed Devuelve la conexión con la base de datos o nulo si hay errores
     * @throws AppException Lanza el código de excepción correspondiente por fallo al abrir conexión con base de datos.
     */
    public static function abrirConexionDB ()
    {
        if (!(static::$connDB instanceof \PDO))
        {            
            try {
                static::$connDB = new \PDO(\DB_DSN, \DB_USER, \DB_PASSWORD, 
                    array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
                        /* Establezco la zona horaria en el servidor de base de datos, pero he descartado
                        el comando de configuración porque NO detecta esta zona horaria ni XAMPP y tampoco 
                        en mi hosting SWHOSTING:
                        
                        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = 'Europe/Madrid'")); 
 
                        Además, en mi hosting no me permite listar las tablas de las zonas horarias mediante:
                        
                        SELECT * FROM mysql.time_zone_name LIMIT 1;                        

                        Todo esto viene a que en mi entorno local el sistema registra corectamente la hora, pero 
                        cuando hago registro de censos (es cuando me he dado cuenta del fallo) la hora registrada va 
                        con dos horas de atrasdo. Por tanto, he descartado configurar zona horaria a nivel SGBDR*/                 
            } 
            catch (\PDOException $e)
            {
                echo $e->getMessage();
                static::$connDB=false;
                throw new AppException
                    ('Error DB. No se puede continuar. Revisa el valor de las constantes DB_USER y DB_PASSWORD en el archivo config-inc.php.',
                      AppException::DB_UNABLE_TO_CONNECT);                                
            }

        }
        return static::$connDB;
    }     

    /**
     * Método estático para cerrar la conexión con la base de datos
     */

    public static function cerrarConexionDB()
    {
        static::$connDB=null;
    }

    /**
     * Método estático para ejecutar una sentencia SQL (Conforme sentencias preparadas PDO)
     *
     * @param $sql sentencia SQL (Conforme a PDO Prepared Statement)
     * @param array $data array asociativo opcional con los datos a reemplazar en la consulta (conforme a PDO Prepared Statement)
     * @return mixed Si la consulta es tipo SELECT se obtendrá un array asociativo con todos los registros
     *               Si la consulta es tipo INSERT/UPDATE/DELETE se obtendrá el número de registros afectados.
     * @throws AppException Si algo en la consulta va mal eleva una excepción tipo AppException con
     * uno de los códigos disponibles en función del problema producido.
     */
    public static function ejecutarSql($sql, $datos = [])
    {        
        $ret = false;
        $pdo = self::abrirConexionDB();
        if (!$pdo) throw new AppException('Error DB: no se puede conectar con la base de datos',
                                          AppException::DB_NOT_CONNECTED);
        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($datos)) {
                if (preg_match('/^\s*SELECT\s/i', $sql))
                    $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                else
                    $ret = $stmt->rowCount();
            }
            else
                throw new AppException('Error DB: Fallo al ejecutar la consulta SQL.',
                    AppException::DB_QUERY_EXECUTION_FAILURE
                );
        } catch (\PDOException $ex) {   
            if ($ex->getCode()==='23000')
            {
                throw new AppException('Error DB: la consulta realizada incumple las restricciones de la base de datos.',
                    AppException::DB_CONSTRAINT_VIOLATION_IN_QUERY);
            }
            throw new AppException('Error DB: error en la consulta.',
                    AppException::DB_ERROR_IN_QUERY);
      
        }
        return $ret;
    }

    // Bloque-C: Correo electrónico.

    /**
     * Método estático para mostrarle al usuario el formulario de contacto del backoffice
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarFormularioContacto($smarty) {
        // Asigno las variables de la plantilla del formulario de contacto
        $smarty->assign('usuario', Core::nombreUsuario());
        $smarty->assign('anyo', date('Y'));
        // Muestro la plantilla de inicio de sesión
        $smarty->display('comunes/contacto.tpl');        
    }

    /**
     * Método estático para enviar por email el formulario de contacto
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantilla Smarty
     * @param PHPMailer $mail Objeto que contiene a la librería de correo electrónico PHPMailer
     * @return void No devuekve valor alguno
     */
    public static function enviarEmail($smarty, $mail) {

        // Intento enviar el formulario de contacto a los administrador de la plataforma web
        try {

            // Recupero los datos del formulario de contacto
            $email = filter_input(INPUT_POST,'frm-email', FILTER_SANITIZE_EMAIL);
            $nombre = filter_input(INPUT_POST,'frm-nombre');
            $telefono = filter_input(INPUT_POST,'frm-telefono');
            $asunto = filter_input(INPUT_POST,'frm-asunto');
            $mensaje = filter_input(INPUT_POST,'frm-mensaje');
            $origen = filter_input(INPUT_POST,'frm-origen');            

            // Establezco el mensaje por defecto si no se relleno en el formulario
            if ($mensaje === null || $mensaje==="") {
                $mensaje="Necesito resolver algunas dudas. Por favor, contactenme. Gracias!";
            }

            /* Estblezco la URL a la que se dirige al usuario al aceptar el mensaje informativo
                >> Si el origen es el portal web se le redirige a su página de inicio
                >> Si el origen es el backoffice se le redirige a su página de inicio */
            $urlAceptar = ($origen === "portal" ? "/index.php" : "/plataforma/backoffice.php");

            // Establezo quién recibirá el mensaje directamente.
            $mail->addAddress(SMTP_FROM, 'Administradores Plataforma Correplayas');
            // Establezco a quién se le envía la respuesta.
            $mail->addReplyTo($email, $nombre);
            // Establezco quién recibirá copia visible del mensaje
            $mail->addCC($email, $nombre);
            // Establezco quién recibirá una copia oculta del mensaje
            $mail->addBCC(SMTP_BCC, SMTP_NOMBRE_BCC);

            // Establezco el contenido del mensaje a enviar a los administradores de la plataforma: HTML
            $contenido = "<p>Hola,<br/><p>Has recibido un nuevo mensaje desde el formulario de contacto de la 
            Plataforma Corerplayas. Aquí te dejo los detalles:</p></p><br/><br/>
            <ul><li><b>Nombre: </b>" . $nombre . "</li><li><b>Correo electrónico: </b>" . $email . "</li>
            <li><b>Teléfono: </b>" . $telefono  ."</li><li><b>Asunto: </b>" . $asunto . "</li>
            <li><b>Mensaje:</b><br/><br/>" . $mensaje . "<br/>En breve antenderemos tu consulta.<br/><br/>Gracias,
            <br/><br/> El equipo de Plataforma Correplayas";

            // Establezco el contenido del mensaje a enviar a los administradores de la plataforma: Texto plano
            $altContenido = "Hola, has recibido un nuevo mensaje desde el formualrio de contacto de la Plataforma
            Correplayas. Aquí te dejo los detalles:\n\n>> Nombre: " . $nombre . "\n>>Correo electrónico:" .
            $email . "\n>> Teléfono: " . $telefono . "\n>> Asunto: " . $asunto . "\n>> Mensaje: " . $mensaje . 
            "\n\n En breve atenderemos tu consulta, \n Gracias, \n El equipo de Plataforma Corerplayas." ;

            // Configuro el mensaje a enviar a los administradores de la plataforma
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $contenido;
            $mail->AltBody = $altContenido;

            // Envio el mensaje a los administradores de la plataforma
            $mail->send();           

            // Notifico al usuario que el envío se realizó correctamente            
            ErrorController::mostrarMensajeInformativo($smarty, "Mensaje enviado correctamente!!", $urlAceptar);

        } 
        // Manejo las posibles excepciones que pueda surgir durante el envio del formulario de contacto
        catch (AppException $ae) {
            ErrorController::handleException($ae, $smarty, "/plataforma/backoffice.php");            
        } catch (Exception $me) {         
            ErrorController::mostrarMensajeError($smarty, $me->getMessage(), $urlAceptar);
        }

    }

    // Bloque-D: Control de acceso a la plataforma.
    
    /**
     * Método estático que muestra la vista de inicio de sesión al usuario.
     *
     * @param Smarty $smarty Contiene el objeto del motor del plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarInicioSesion($smarty) {
        // Asigno las variables de la plantilla de inicio de seesión
        $smarty->assign('usuario', Core::nombreUsuario());
        $smarty->assign('anyo', date('Y'));
        // Muestro la plantilla de inicio de sesión
        $smarty->display('comunes/login.tpl');
    }

    /**
     * Método estático que procesa el inicio de sesion d eun usuario en la plataforma
     *
     * @param Smarty $smarty Contiene el objeto del motor del plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function iniciarSesion($smarty) {
        // Recupero los datos proporcionados en el formulario de inicio de sesión
        $usuario=filter_input(INPUT_POST,'frm-usuario');
        $password=filter_input(INPUT_POST,'frm-password');
        // Compruebo que los campos usuario y contraseña no estén vacios
        if (!empty($usuario) && !empty($password))
        {   
            // Recupero el usuario de las credenciales aportadas
            $u=Usuario::autenticarUsuario($usuario,$password);
            // Compruebo que $u sea una instancia de la clase Usuario
            if($u instanceof Usuario) {
                // Compruebo que el estado de usuario es activo
                if ($u->getEstado() === 'ACTIVO') {
                    // Recupero los permisos del usuario a partir de su rol
                    $p=Rol::asignarPermisos($u->getRol());
                    // Compruebo que $p sea una instancia de la clase Rol
                    if ($p instanceof Rol) {
                        // Guardo en la sesión al usuario peropietario
                        $_SESSION['usuario']=$u;
                        // Guardp en la sesión los permisos del usuario propietario
                        $_SESSION['permisos']=$p;
                    } else {
                        // Lanzo excepción para notificar que el rol del usuario es desconocido
                        throw new AppException('El rol del usuario es desconocido en la plataforma');
                    }
                } else {
                    // Lanzo excepción para notificar que el usuario no se encuentra activo en la plataforma.
                    throw new AppException('Su usuario presenta una incidencia!! Por favor, contacté con los administradores del sitio');
                }
            }
            else
            {
                // Lanzo excepción para notificar que usuario o contraseña no son válidos
                throw new AppException('El usuario o password indicado no es válido');
            }
        }
        else
        {
            // Lanzo excepción para notificar que no se han indicado el usuario o contraseña
            throw new AppException('No se han indicado el usuario o el password');
        }
        Core::default($smarty);
    }

    /**
     * Método estático que muestra la vista de cierre de sesión al usuario.
     *
     * @param Smarty $smarty Contiene el objeto del motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarCierreSesion($smarty) {
        // Asigno las variables de la plantilla de cierre de sesión
        $smarty->assign('usuario', Core::nombreUsuario());
        $smarty->assign('anyo', date('Y'));
        // Muestro la plantilla del cierre de sesión
        $smarty->display('comunes/logout.tpl');
    }

    /** 
     * Método estático que procesa el cierre de sesión de un usuario
     */
    public static function cerrarSesion() {

        // Recupero la sesión del usuario actual
        session_start();

        // Elimino todas las variables de la sesión actual
        session_unset();

        // Elimino la cookie de sesion del navegador
        setcookie(session_name(), '', time() - 3600, "/");

        // Redirigo al usuario a la vista de inicio de sesión
        header("Location: http://" . $_SERVER['SERVER_NAME']);

        // Salgo de la ejecución del presente script PHP
        exit;

    }

    /**
     * Método estático que muestra la vista del registro de un nuevo voluntario
     * 
     *
     * @param Smarty $smarty Contiene el objeto del motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * 
     * RECUERDA: Los DNI para pruebas que pasan oficialmente el validador son:
     * 
     * 12345678Z (usado)
     * 00000000T (usado)
     * 36574869Q (usado)
     * 48273645N
     * 71829304P
     * 25364758Y
     * 59483726M
     * 62738495L
     * 87654321K 
     * 99999999X
     * 34691785X
     * 78965432W
     * 11223344K
     * 55667788Q
     * 
     */
    public static function mostrarRegistroVoluntario($smarty) {
        // Asigno las variables de la plantilla de registro de voluntario
        $smarty->assign('usuario', Core::nombreUsuario());
        $smarty->assign('anyo', date('Y'));
        // Muestro la plantilla para el registro de un nuevo voluntario
        $smarty->display('comunes/signup.tpl');        
    }


    /**
     * Método estático que procesa el registro de un nuevo usuario en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * 
     * RECUERDA: Los DNI para pruebas que pasan oficialmente el validador son:
     * 
     * 12345678Z (usado)
     * 00000000T (usado)
     * 36574869Q (usado)
     * 48273645N
     * 71829304P
     * 25364758Y
     * 59483726M
     * 62738495L
     * 87654321K 
     * 99999999X
     * 34691785X
     * 78965432W
     * 11223344K
     * 55667788Q
     * 
     */
    public static function registrarVoluntario($smarty) {
        // Recupero los datos del formulario de registro de un nuevo usuario: Datos de usuario
        $datosUsuario = [':codigo' => '',
        ':nombre' => filter_input(INPUT_POST,'frm-usuario'),
        ':contrasenya' => filter_input(INPUT_POST,'frm-password'),
        ':estado' => 'ACTIVO',
        ':rol' => 'voluntario'];

        // Recupero los datos del formulario de registro de un nuevo usuario: Datos de persona usuaria
        $datosPersona = [':documento' => filter_input(INPUT_POST,'frm-dni'),
        ':tipo' => 'DNI',
        ':nombre' => filter_input(INPUT_POST,'frm-nombre'),
        ':apellido1' => filter_input(INPUT_POST,'frm-apellido1'),
        ':apellido2' => filter_input(INPUT_POST,'frm-apellido2'),
        ':email' => filter_input(INPUT_POST,'frm-email'),
        ':telefono' => '-',
        ':direccion' => '-',
        ':localidad' => filter_input(INPUT_POST,'frm-localidad'),
        ':codigoPostal' => '-',
        ':usuario' => ''];

        // Genero el hash de la contraseña de usuario
        $datosUsuario[':contrasenya'] = hash('sha256', $datosUsuario[':nombre'] . $datosUsuario[':contrasenya']);

        // Genero el hash de usuario que identica a la persona usuaria
        $hashUsuario = $datosUsuario[':nombre'] . $datosPersona[':documento'] . $datosPersona[':nombre'] . $datosPersona[':apellido1'] . $datosPersona[':apellido2'];
        $hashUsuario = hash('sha256', $hashUsuario);

        // Asigno el hash de usuario generado a los datos de usuario y de la persona usuaria
        $datosUsuario[':codigo'] = $hashUsuario;
        $datosPersona[':usuario'] = $hashUsuario;

        // Intento registrar al usuario y su persona usuaria asociada
        try {
            // Registro al nuevo usuario en la base de datos
            $u = Usuario::crearUsuario($datosUsuario);

            // Registro a la nueva persona usuaria en la base de datos
            $p = Persona::crearPersona($datosPersona);

            // Compruebo que el usuario y su persona asociada se crearon correctamente
            if ($u && $p) {
                // Notifico al usuario el resultado de registrarse en la plataforma
                $smarty->assign('titulo', 'Notificaciones backoffice');
                $smarty->assign('anyo', date('Y'));
                $smarty->assign('tipo', 'info');
                $smarty->assign('mensaje', 'Bienvenido/a ' . $datosUsuario[':nombre'] . ' Te has registrado con éxito en la plataforma!');
                $smarty->assign('aceptar', '/plataforma/backoffice.php?comando=core:login:vista');
                $smarty->display('comunes/notificaciones.tpl');              
            } else {
                // Lanzo excepción para notificar al usuario que hubo algún problema con su proceso de registro
                throw new AppException(message: "Uppps!! Hubo un problema con su registro. Por favor, contacte con los administradores",
                    urlAceptar: "/plataforma/backoffice.php?comando=core:email:vista");
            }                

        // Manejo la excepción que se haya producido para notificarla al usuario
        } catch (AppException $ae) {
            // Si se produce una violación de restricción al registrarlos
            if ($ae->getCode() === AppException::DB_CONSTRAINT_VIOLATION_IN_QUERY)
            {
                ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php?comando=core:login:vista', "Este usuario ya esta registrado!!");
            }
            else
                ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php?comando=core:signup:vista');
        }

    }

    /**
     * Método para configurar el modo de depuración de la Plataforma Correplayas
     *
     * @return void No devulve valor alguno
     */
    public static function configurarDepuradorPlataforma() {

        // Compruebo el estado de configuración del modo de depuración PHP para la plataforma
        if (defined('DEBUG_MODE') && DEBUG_MODE === true) {
            // La constante de configuración de modo de depuración de la plataforma está definida y activa
            // Entonces: Aplico la configuración para el modo de desarrollo: Debug PHP Mode habilitado.
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        } else {
            // De lo contrario, aplico la configuración para el modo de producción: Debug PHP Mode deshabilitado.
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }

    }

}

 ?>
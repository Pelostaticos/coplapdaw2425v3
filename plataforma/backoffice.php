<?php

/**
 * Enrutador del backoffice de la plataforma web Correplayas
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene el código PHP del enrutador de la plataforma web del proyecto, encargado de recbir del
 * usuario los comandos y datos de las acciones que desea realizar para decidir que controlador es
 * el encargado en la aplicación web de ejecutarlas.
 *
 * @category "Enrutador"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

// 0º) Defino el espacio de nombre del fichero
namespace correplayas;

// 1º) Cargo el fichero de configuración y clases de la plataforma web
require_once(__DIR__ . '/config/config-inc.php');
require_once(__DIR__ . '/excepciones/AppException.php');
require_once(__DIR__ . '/modelo/Ave.php');
require_once(__DIR__ . '/modelo/Familia.php');
require_once(__DIR__ . '/modelo/Jornada.php');
require_once(__DIR__ . '/modelo/Localidad.php');
require_once(__DIR__ . '/modelo/Participante.php');
require_once(__DIR__ . '/modelo/Persona.php');
require_once(__DIR__ . '/modelo/Observatorio.php');
require_once(__DIR__ . '/modelo/Orden.php');
require_once(__DIR__ . '/modelo/Rol.php');
require_once(__DIR__ . '/modelo/Usuario.php');
require_once(__DIR__ . '/controladores/Usuarios.php');
require_once(__DIR__ . '/controladores/Jornadas.php');
require_once(__DIR__ . '/controladores/Participantes.php');
require_once(__DIR__ . '/controladores/Censos.php');
require_once(__DIR__ . '/controladores/Aves.php');
require_once(__DIR__ . '/controladores/Observatorios.php');
require_once(__DIR__ . '/controladores/ErrorController.php');
require_once(__DIR__ . '/nucleo/AjaxQuery.php');
require_once(__DIR__ . '/nucleo/Core.php');


// 2.1º) Cargo las librerias requeridas por la plataforma web
require_once(__DIR__ . SMARTY_LIB);
require_once(__DIR__ . PHPMAILER_LIB);
require_once(__DIR__ . PHPMAILER_SMTP);
require_once(__DIR__ . PHPMAILER_EXCEPTION);

// 2.2º) Establezco los espacio de nombre que voy a utilizar
use Smarty\Smarty;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
use correplayas\controladores\ErrorController;
use correplayas\controladores\Usuarios;
use correplayas\controladores\Jornadas;
use correplayas\controladores\Participantes;
use correplayas\controladores\Censos;
use correplayas\controladores\Aves;
use correplayas\controladores\Observatorios;
use correplayas\excepciones\AppException;
use correplayas\nucleo\AjaxQuery;
use correplayas\nucleo\Core;

// 3º) Inicio la sesion web en la plataforma web
session_start();

// 4.1º) Configuro el motor de plantillas Smarty
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . TEMPLATE_DIR);
$smarty->setCompileDir(__DIR__ . COMPILE_DIR);
$smarty->setCacheDir(__DIR__ . CACHE_DIR);
$smarty->setConfigDir(__DIR__ . CONFIGS_DIR);

// 4.2) Configuro el servidor SMTP para envío de correo electrónico
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = SMTP_HOST;
$mail->SMTPAuth = true;
$mail->Username = SMTP_USER;
$mail->Password = SMTP_PASS;
$mail->CharSet = PHPMailer::CHARSET_UTF8;
$mail->Port = SMTP_PORT;
$mail->setFrom(SMTP_FROM, 'Plataforma Correplayas');

// 5º) Obtengo el comando de acción requerida por el usuario.
$comando = filter_input(INPUT_GET, 'comando', FILTER_SANITIZE_SPECIAL_CHARS);

// Mensaje temporal para depuración del enrutador:
// echo "Bienvenido al futuro enrutador de la Playaforma Correplayas...";
// echo "<br/>";
// echo "El comando que quieres ejecutar es: " . $comando;
// echo "<br/>";

// 6º) Compruebo si el usuario tiene iniciada una sesion para restringir las acciones disponibles
try {
    // Intento ejecutar el comando solicitado por el usuario
    if (isset($_SESSION['usuario'])) {
        // 6.1º) Gestiono la petición como un comando del backoffice para un usuario logueado
        // echo "Hola! Esta funciones no están disponible por el momento... Gracias!<br>";
        // echo "<a href='/plataforma/backoffice.php'>Volver al inicio</a>";
        switch ($comando) {
            // Solicita al núcleo el procesamiento de una petición de intercambio de datos asíncrono.
            case "ajax:query:core":
                AjaxQuery::default();
                break;
            // Solicita el cierre de sesión en la plataforma
            case "core:logout:vista":
                // Solicito al núcleo de la plataforma que muestre el mensaje de confirmación del cierre de seasión al usuario
                Core::mostrarCierreSesion($smarty);
                break;
            // Cierro la sesión del usuario en la plataforma
            case "core:logout:procesa":
                // Solicito al núcleo de la plataforma que cierre la sesión del usuario logueado.
                Core::cerrarSesion();
                break;
            // Muestro el formulario de contacto
            case "core:email:vista":
                // Solicito al núcleo de la plataforma que me muestre el formulario de contacto del backoffice
                Core::mostrarFormularioContacto($smarty);
                break;
            // Proceso el formulario de contacto
            case "core:email:procesa":
                // Solicito al nucleo de la plataforma que procese el formulario de contacto
                Core::enviarEmail($smarty, $mail);                
                break;
            // Muestro el gestor de usuarios
            case "usuarios:default":
                // Solicita al controlador de usuarios que muestre las vista por defectos del gestor de usuarios
                Usuarios::default($smarty);
                break;
            // Muestro el perfil de usuario
            case "usuarios:consultar":
                // Aquí no necesito volver al listado si está activa la variable de sesion volver.
                if (isset($_SESSION['volver'])) {unset($_SESSION['volver']);}
                // Solicito al controlador de usuarios que muestre el perfil de usuario.
                Usuarios::consultarPerfil($smarty);
                break;
            // Muestro vista de edicion del perfil de usuario
            case "usuarios:actualizar:vista":
                // Solicito al controlador de usuarios que muestre la vista de edición del perfil
                Usuarios::mostrarVistaEdicionUsuarioPlataforma($smarty);
                break;
            // Actualizo el perfil de usuario
            case "usuarios:actualizar:procesa":
                // Solicito al controlador de usuarios que actualice el perfil de usuario
                Usuarios::actualizarUsuarioPlataforma($smarty);
                break;
            // Muestro vista para cambio de contraseña.
            case "usuarios:contraseña:vista":
                // Solicito al controlador de usuarios que muestre la vista para cambiar el password de usuario
                Usuarios::mostrarVistaCambioContraseñaUsuarioPlataforma($smarty);
                break;
            // Cambio de contraseña del usuario.
            case "usuarios:contraseña:procesa":
                // Solicito al controlador de usuarios que cambie la contraseña del perfil de usuario
                Usuarios::modificarPasswordUsuarioPlataforma($smarty);
                break;
            // Muestro confirmación para eliminar el perfil de un  usuario
            case "usuarios:eliminar:vista":
                // Solicito al controlador de usuarios que muestre la vista de confirmación para eliminar un perfil de usuario
                Usuarios::mostrarConfirmacionBajaUsuarioPlataforma($smarty);
                break;
            // Elimino el perfil de usuario
            case "usuarios:eliminar:procesa":
                // Solicito al controlador de usuarios que elimine el perfil de usuario
                Usuarios::eliminarUsuarioPlataforma($smarty);
                break;
            // Listo a los usuarios disponibles en la plataforma (Sólo adinistradores)
            case "usuarios:listar":
                // Solicito al controlador de usuarios que me genere un listado con los usuarios de la plataforma
                Usuarios::listarUsuariosPlataforma($smarty);
                break;
            // Filtro a los usuarios disponibles en la plataforma (Sólo administradores)                    
            case "usuarios:filtrar":
                // Solicito al controlador de usuarios que me filtre el listado de usuarios.
                Usuarios::filtrarUsuariosPlataforma($smarty);
                break;
            // Activo el perfil de un usuario cuyo estado es desactivo (Sólo administradores)
            case "usuarios:activar:vista":
                // Solicito al controlador de usuarios que muestre la confirmación para la activación del perfil de un usuario
                Usuarios::mostrarConfirmacionActivarUsuarioPlataforma($smarty);
                break;
            // DESCARTO IMPLEMENTACIÓN POR FALTA DE TIEMPO: 25/03/2025.
            // case "usuarios:activar:procesa":
            //     // Solicito al controlador de usuarios que me active el perfil de usuario
            //     Usuarios::activarUsuarioPlataforma($smarty);
            //     break;
            // Desactivo el perfil de un usuario cuyo estado es activo
            case "usuarios:desactivar:vista":
                // Solicito al controlador de usuarios que muestre la confirmación para la desactivación del perfil de un usuario
                Usuarios::mostrarConfirmacionDesactivarUsuarioPlataforma($smarty);
                break;
            // DESCARTO IMPLEMENTACIÓN POR FALTA DE TIEMPO: 25/03/2025.
            // case "usuarios:desactivar:procesa":
            //     // Solicito al controlador de usuarios que me desactive el perfil de usuario
            //     Usuarios::desactivarUsuarioPlataforma($smarty);
            //     break;
            case "jornadas:default":
                // Solicito al controlador de jornadas que muestre la vista por defecto del gestor jornadas
                Jornadas::default($smarty);
                break;
            case "jornadas:registrar:vista":
                // Solicito al controlador de jornadas que me muestre la vista para el registro de nuevas jornadas
                Jornadas::mostrarRegistroJornadaPlataforma($smarty);
                break;
            case "jornadas:registrar:procesa":
                // Solicito al controlador de jornadas que me muestre la vista para el registro de nuevas jornadas
                Jornadas::registrarJornadaPlataforma($smarty);
                break;
            case "jornadas:actualizar:procesa":
                // Solicito al controlador de jornadas que procese la actualización de una jornada
                Jornadas::actualizarJornadaPlataforma($smarty);
                break;
            case "jornadas:eliminar:procesa":
                // Solicito al controlador de jornadas que procese la baja de una jornada
                Jornadas::eliminarJornadaPlataforma($smarty);
                break;
            case "jornadas:filtrar":
                // Solicito al controlador de jornadas que filtre el listado por los criterios de búsqueda dados
                Jornadas::filtrarJornadasPlataforma($smarty);
                break;
            case "participantes:default":
                // Compruebo si hay acción establecida en la sesión del usuario
                if (isset($_SESSION['accion'])) {
                    // Hay una acción establecida en la variable de sesión del usuario. Entonces:
                    // Simulo un POST de una acción espécifica del gestor de participantes que es
                    // solicitada desde el propio código de procesamiento de una acción previa.
                    // EJEMPLOS: Acciones específicas de actualizar y eliminar inscripciones de la plataforma.
                    //           donde ambos al finalizar su procesamiento piden volver al histórico de participación
                    // MOTIVO: Mi inexperiencia en el desarrollo de aplicaciones web tan complejas, me ha hecho que a priori
                    // no contemplase todos los casos posibles de redirecciones que necesitaria el usuario, y por ello esta 
                    // solución parcial para dar funcionalidad al gestor y poder continuar con el desarrollo.
                    $_POST['accion']=$_SESSION['accion'];
                    // Desestablezco la variable acción de la sesión de usuario porque aquí ya cumplió su función
                    unset($_SESSION['accion']);
                }
                // Solicito al controlador de participantes que muestre la vista por defecto según el rol del usuario
                Participantes::default($smarty);
                break;
            case "participantes:inscribirse:procesa":
                // Solicito al controlador de participantes que procese la nueva inscripción a jornadas de la plataforma
                Participantes::inscribirParticipanteJornadaPlataforma($smarty);
                break;
            case "participantes:actualizar:procesa":
                // Solicito al controlador de participantes que procese la actualización de una inscripción en la plataforma
                Participantes::actualizarInscripciónParticipantePlataforma($smarty);
                break;
            case "participantes:eliminar:procesa":
                // Solicito al controlador de participantes que procese la baja de una inscripción de la plataforma
                Participantes::eliminarInscripcionParticipantePlataforma($smarty);
                break;
            case "participantes:filtrar":
                // Solicito al controlador de participantes que filter el histórico de participación de un usuario de la plataforma
                Participantes::filtrarInscripcionesParticipantesPlataforma($smarty);
                break;
            case "censos:default":
                // Solicito al controlador de censos que muestre las vista por defecto según rol del usuario
                Censos::default($smarty);
                // OBSERVACIONES: El gestor de censos no se encuentra implementado por falta de tiempo
                break;                
            case "aves:default":
                // Solicito al controlador de aves que muestre las vista por defecto según rol del usuario
                Aves::default($smarty);
                // OBSERVACIONES: El gestor de censos no se encuentra implementado por falta de tiempo
                break;
            case "aves:filtrar":
                // Solicirto al controlador de aves que filtre el listado de aves disponibles en la plataforma
                Aves::filtrarAvesPlataforma($smarty);
                break;      
            case "observatorios:default":
                // Solicito al controlador de observatorios que muestre las vista por defecto según rol del usuario
                Observatorios::default($smarty);
                break;
            case "observatorios:filtrar":
                // Solicito al controlador de observatorios  que filtre el listado de observatorios disponibles en la plataforma
                Observatorios::filtrarObservatoriosPlataforma($smarty);
                break;
            case "observatorios:registrar:vista":
                // Solicito al controlador de observatorios que muestre la vista para registrar un nuevo observatorio
                Observatorios::mostrarRegistroObservatorioPlataforma($smarty);
                break;
            case "observatorios:registrar:procesa":
                // Solicito al controlador de observatorios que procese el registro de un nuevo observatorio
                Observatorios::registrarObservatorioPlataforma($smarty);
                break;
            case "observatorios:actualizar:procesa":
                // Solicito al controlador de observatorios que procese la edición de un observatorio
                Observatorios::actualizarObservatorioPlataforma($smarty);
                break;
            case "observatorios:eliminar:procesa":
                // Solicito al controlador de observatorios que procese la baja de un observatorio
                Observatorios::eliminarObservatorioPlataforma($smarty);
                break;
            default:
                // Solicito al núcleo que muestre la página de inicio del backoffice de la plataforma.
                Core::default($smarty);
                break;
        }
    } else {
        // 6.2) Gestiono la petición como un comando esencial de la plataforma para un visitante web.
        switch ($comando) {
            // Solicita al núcleo el procesamiento de una petición de intercambio de datos asíncrono.
            case "ajax:query:core":             
                AjaxQuery::default();
                break;            
            // Solicita el inicio de sesión en la plataforma
            case "core:login:vista":
                Core::mostrarInicioSesion($smarty);
                break;
            // Inicio el proceso de autenticación del usuario en la plataforma            
            case "core:login:procesa":
                Core::iniciarSesion($smarty);
                break;          
            // Un usuario visitante quiere registrarse en la plataforma
            case "core:signup:vista":
                Core::mostrarRegistroVoluntario($smarty);
                break;
            // Completo el proceso de registro de un nuevo usuario en la plataforma
            case "core:signup:procesa":
                Core::registrarVoluntario($smarty);
                break;
            // Un usuario visitante quiere contactar con los administradores por email
            case "core:email:procesa":
                Core::enviarEmail($smarty, $mail);
                break;    
            // Por defecto para un usuario no logueado y comando desconocido se le lleva al inicio de sesión
            default:
                Core::mostrarInicioSesion($smarty);
                break;
        }
    }    
} catch (AppException $ae) {
    ErrorController::handleException($ae, $smarty);
}

?>
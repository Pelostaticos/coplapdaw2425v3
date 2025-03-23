<?php
/**
 * Clase del controlador para gestionar todas las acciones con usuarios de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los usuarios de la plataforma correplayas.
 *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

 // Defino el espacio de nombre para esta clase del controlador para usuarios
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\excepciones\AppException;
use correplayas\modelo\Usuario;
use correplayas\modelo\Persona;
use correplayas\modelo\Rol;
use Smarty\Smarty;

/**
 * Clase del controlador Usuarios para gestión de todas sus acciones disponibles en plataforma
 */
class Usuarios {

    /**
     * Método por defecto para mostrar la vista del gestor de usuarios de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function default($smarty) {
        // Recupero el rol del usuario logueado
        $usuarioLogueado = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo la procedencia de la solicitud de acción del gestor de usuario
        // Si está establecida la accion en el supergobal POST y el usuario logueado tiene permiso 
        // para listar usuarios en la plataforma. Entonces:
        if (isset($_POST['accion']) && $permisosUsuario->getPermisoListarUsuarios()) {            
            // Recupero la acción solicitada desde el listado de usaurios
            $accion = $_POST['accion'];
            // Establezco la variable sesion con el identificador del usuario seleccionado en el listado
            $_SESSION['listado'] = $_POST['hashusuario'];
            // Recupero URL de la acción volver si está establecido en la variable de sesion
            if (isset($_SESSION['volver'])) {$volver=$_SESSION['volver'];}
            // Proceso la acción procedente de un listado de usuarios.
            switch($accion) {
                case "reactivar":
                    // Elimino la variable de sesion listado por aquí ya cumplio su funcion
                    if (isset($_SESSION['listado'])) {unset($_SESSION['listado']);}
                    // Muestro el mensaje informativo indicandole al usuario que la funcionalidad no está disponible.
                    ErrorController::mostrarMensajeInformativo($smarty, "Esta autorizado para ejecutar esta funcionalidad. No obstante, por cuestones técnicas
                     el reactivar a un usuario de baja no se encuentra disponible en la plataforma. Gracias!", $volver);
                    break;
                default:
                    Usuarios::consultarPerfil($smarty);
                    break;
            }
        } else {
            // De lo contario, muestro las vista por defecto del gestor de usuario. Por tanto:
            // Si el usuario logueado tiene rol de administrador entonces:
            if ($permisosUsuario->hasPermisoAdministradorGestor()) {
                // Muestro la vista del gestor de usuario para administradores
                Usuarios::listarUsuariosPlataforma($smarty);
                // Añado a la sesión la variable volver para recodar que en cada acción del listado
                // al pinchar en volver de cada vista de acción debe regrasar al listado.
                $_SESSION['volver'] = $_SERVER['REQUEST_URI'];
            } else {
                // De lo contrario muestro la vista del gestor de usuario para el resto de roles
                Usuarios::consultarPerfil($smarty);
                // Aquí no necesito volver al listado si está activa la variable de sesion volver.
                if (isset($_SESSION['volver'])) {unset($_SESSION['volver']);}
            }

        }

    }

    /**
     * Método estático para mostrar el perfil de usuario
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function consultarPerfil($smarty) {

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo la procedencía de la ejecución de la presente acción
        // Si la variable de sesion listado está establecida junto 
        // El usuario logueado tiene permiso para listar usuarios. Entonces:
        if (isset($_SESSION['listado']) && $permisosUsuario->getPermisoListarUsuarios()) {
            // El usuario autorizado está solicitando consultar datos de un usuario no logueado
            // Recupero el hash identificador de usuario desde la variable de sesion
            $hashUsuario = $_SESSION['listado'];
            // Consulto a la base de datos por el usuario contenido en la variable de sessión listado
            $usuario = Usuario::consultarUsuario($hashUsuario);
            // Elimino la variable de sesión listado porque ya ha cumplido su función en esta acción
            unset($_SESSION['listado']);
        } else {
            // De lo contrario, el usuario está pidiendo consultar su propio perfil de usuario
            // Obtengo al usuario de la sesión del navegacion
            $usuario = $_SESSION['usuario'];
            // Obtengo el hash identificador de usuario
            $hashUsuario = $usuario->getCodigo();            
        }

        // Compruebo si el usuario tiene permisos para mostrar su perfil
        if ($permisosUsuario->getPermisoConsultarUsuario()) {

            // Identifico a la persona usuaria
            $personaUsuaria = Persona::identificarPersona($hashUsuario);

            // Proceso la informacion del perfil si este existe
            if ($usuario instanceof Usuario && $personaUsuaria instanceof Persona) {
                // Genero el nombtre completo de la persona usuaria
                $nombrePersonaUsuaria = $personaUsuaria->getNombrePersona() . " " . $personaUsuaria->getPrimerApellido() . " " . $personaUsuaria->getSegundoApellido();
                // Recopilo información del perfil de usuario para la plantilla
                $perfil = ['usuario' => $usuario->getUsuario(),
                'nombre' => $nombrePersonaUsuaria,
                'tipo' => $personaUsuaria->getTipoDocumento(),
                'documento' => $personaUsuaria->getDocumento(),
                'direccion' => $personaUsuaria->getDireccionPersona(),
                'localidad' => $personaUsuaria->getLocalidadPersona(),
                'codigoPostal' => $personaUsuaria->getCodigoPostalPersona(),
                'email' => $personaUsuaria->getEnailPersona(),
                'telefono' => $personaUsuaria->getTelefonoPersona(),
                'estado' => ucfirst(strtolower($usuario->getEstado())),
                'rol' => ucfirst($usuario->getRol())];
                // Asigno las variables requeridas por la plantila del perfil de usuario
                $smarty->assign('usuario', $usuario->getUsuario());
                $smarty->assign('permisos', $permisosUsuario);
                $smarty->assign('perfil', $perfil);
                if (isset($_SESSION['volver'])) {
                    // Si existe variable de sesion volver se le debe redirigir al usuario
                    // al listado cuando pulse en volvar en la vista de consulta del perfil
                    $smarty->assign('volver', $_SESSION['volver']);
                    // Elimino la variable de sesión volver porque ya cumplio su funcion
                    unset($_SESSION['volver']);
                } else {
                    // De lo contario se le redirige a la página principal del backoffice
                    $smarty->assign('volver', '/plataforma/backoffice.php');
                }
                $smarty->assign('anyo', date('Y'));
                // Muestro la plantilla del perfil de usaurio con sus datos
                $smarty->display('usuarios/perfil.tpl');                   
            } else {
                // Lanzo una excepción para indicar que no existe perfil de usuario
                throw new AppException("No existe el perfil de usuario");
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para mostrar su perfil
            throw new AppException("Su rol en la plataforma no le permite mostrar su perfil de usuario");
        }

    }

    // FUNCION TEMPORAL PARA IR PROBANDO LA VISTA
    public static function listarUsuariosPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Simulo una entrada de contenidos de base de datos
        $datos = Usuario::listarUsuarios();
        // var_dump($datos);
        // exit;

        // Asigno las variables requeridas por la plantila del listado de usuarios
        $smarty->assign('usuario', $usuario->getUsuario());
        $smarty->assign('filas', $datos);
        $smarty->assign('anyo', date('Y'));
        // Muestro la plantilla del listado de usuarios
        $smarty->display('usuarios/listado.tpl');      

    }

    public static function filtrarUsuariosPlataforma($smarty) {

    }

    // public static function modificarPassword($passwordActual, $passwordNueva)
    // {
    //     // $sql="UPDATE usuarios SET password=SHA2(CONCAT(:username,:newpassword),256) WHERE username=:username and password=SHA2(CONCAT(:username,:currentpassword),256)";
    //     // return DB::doSql($sql,[':usuario'=>$this->usuario,':currentpassword'=>$currentpassword,':newpassword'=>$newpassword]);        
    // }
    

}

 ?>
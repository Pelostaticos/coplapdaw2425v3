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

        // Si el usuario logueado tiene rol de administrador entonces:
        if ($usuarioLogueado->getRol() === "administrador") {
            // Muestro la vista del gestor de usuario para administradores
            Usuarios::listarUsuariosPlataforma($smarty);
        } else {
            // De lo contrario muestro la vista del gestor de usuario para el resto de roles
            Usuarios::consultarPerfil($smarty);
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

        // Compruebo si el usuario tiene permisos para mostrar su perfil
        if ($permisosUsuario->getPermisoConsultarUsuario()) {
            // Obtengo al usuario de la sesión del navegacion
            $usuario = $_SESSION['usuario'];

            // Obtengo el hash identificador de usuario
            $hashUsuario = $usuario->getCodigo();

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
                $smarty->assign('perfil', $perfil);
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
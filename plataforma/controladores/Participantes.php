<?php

/**
 * Clase del controlador para gestionar todas las acciones con participantes de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los participantes de la plataforma correplayas.
 *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

 // Defino el espacio de nombre para esta clase del controlador para jornadas
 namespace correplayas\controladores;

 // Defino los espacios de mombres que voy a utilizar en esta clase
 use correplayas\controladores\ErrorController;
 use correplayas\controladores\Jornadas;
 use correplayas\excepciones\AppException;
 use correplayas\modelo\Participante;
 use Smarty\Smarty;

 /**
 * Clase del controlador Participantes para gestión de todas sus acciones disponibles en plataforma
 */
class Participantes {

    /**
     * Método por defecto que muestra la vista del gestor de participantes de la plataforma y además gestiona
     * las vistas auxiliares de acciones solicitadas por desde los listados del presente gestor.
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */    
    public static function default($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];
        // Compruebo si el usuario logueado es administrador y no ha pedido participar en jornadas
        if ($permisosUsuario->hasPermisoAdministradorGestor() && !isset($_SESSION['adminparticipa'])) {
            // Activo el modo participación para usuarios administradores en la presente sesion del usaurio
            $_SESSION['adminparticipa']=true;
            // Muestro informativo para indicarle que las funcionalidades de gestión de administrador
            // no se encuentran implementadas en la plataforma. Además, se le notifica de que tiene 
            // activo el modo participación para inscribirse a jornadas de la plataforma.
            ErrorController::mostrarMensajeInformativo($smarty, "Como administrador tienes permisos para ejecutar todas
                las funcionalidades de gestión de participantes de la plataforma. No obstante, por motivos técnicos no están 
                implementadas. Por tanto, sólo le activamos por esta sesión el modo participación mediante el que podrás
                inscribirte a las distintas jornadas y participar en ellas. Dusculpe las molestias!!", 
                "/plataforma/backoffice.php?comando=participantes:default");
        } else {
            // De lo contrario, el usuario logueado no es administrador.
            // Compruebo si está establecida la accion en el supergobal POST.
            // RECUERDA: Aquí un administrador se comporta como un usuario no administrador por restricciones en la 
            // implementación completa del gestor de participantes por cuestión de falta de tiempo por cumplir con 
            // el plazo de entre del proyecto DAW.
            if (isset($_POST['accion'])) {
                // Está establecida la acción en el superglobal POST. Entonces:                
                // Recupero la acción solicitada desde un listado del gestor de participantes
                $accion = $_POST['accion'];
                // Establezco la variable sesion con el identificador de la jornada seleccionado en el listado
                $_SESSION['listado'] = $_POST['idJornada'];                
                // Proceso la acción solicitadas por usuarios no administradores desde el gestor
                switch ($accion) {
                    case "inscribirse":
                        break;
                    default:
                        // Establezco la variable de sesión para volver al gestor de participantes 
                        // tras consultar detalles de una jornada disponible a inscripción.
                        $_SESSION['volver'] = $_SERVER['REQUEST_URI'];                    
                        // Solicito al controlador de jornadas que muestre los detalles de la jornada
                        // abierta a inscripción que el usuario desea consultar.
                        Jornadas::consultarDetallesJornadaPlataforma($smarty);
                        break;
                }
            } else {
                // De lo contrario, le muestro la vista por defecto para su inscripción a jornadas.
                Participantes::listarJornadasInscripcionPlataforma($smarty);
            }            
        }
    }

    // A) Método estáticos privados para gestioanr las vistas específicas solicitada desde el listado

    /**
     * Método estático auxiliar para mostrar la vista con el listado de jornadas disponibles a inscripción en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function listarJornadasInscripcionPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero el hash de usuario del usuario participante
        $participante=$usuario->getCodigo();

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo que el usuario logueado no es administrador o es un administrdor como el modo participación activo
        if (!$permisosUsuario->hasPermisoAdministradorGestor() || isset($_SESSION['adminparticipa'])) {

            // Genero el listado de jornadas  disponibles en la plataforma
            $datos = Participante::listarJornadasInscripcion($participante);

            // Asigno las variables requeridas por la plantila del listado de jornadas
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de jornadas
            $smarty->display('participantes/listado.tpl');  

        } else {
            // lazo una excepción para notificar al usuario que no tiene permisos para incribirse a jornadas en la plataforma
            throw new AppException("Su usuario NO tiene permisos para inscribirse a jornadas en la plataforma!!!");
        }

        // OBSERVACIÓN: Aquí trabajamos directamente con el hash del usuario logueado ya que los administradores no
        // tienen implementada las funcionalidades de gestión de inscripciones de otros usuarios participantes.


    }    

    // B) Métodos estáticos públicos para procesar los datos de las vistas específicas
    
    
    // C) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados
    
    


}

 ?>
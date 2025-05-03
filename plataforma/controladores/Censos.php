<?php

/**
 * Clase del controlador para gestionar todas las acciones con censos de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los censos de la plataforma correplayas.
 * 
  *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 * OBSERVACIONES: Desarrollo descartado por falta de tiempo para cumplir con plazos de entrega * 
 */

 // Defino el espacio de nombre para esta clase del controlador para censos
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\controladores\ErrorController;
use correplayas\excepciones\AppException;
use correplayas\controladores\Jornadas;
use correplayas\modelo\Censo;
use correplayas\modelo\Jornada;
use correplayas\modelo\Observatorio;
use Smarty\Smarty;
use DateTime;

/**
 * Clase del controlador Censos para gestión de todas sus acciones disponibles en plataforma
 */
class Censos {

    /**
     * Método estático por defecto para mostrar vistas del gestor de censos de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function default($smarty) {

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Inicializo por defecto el modo restringido del gestor de censos para usuarios autorizados a deshabilitado
        if (!isset($_SESSION['admincensos'])) {$_SESSION['admincensos']=false;}

        // Compruebo si es usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && $_SESSION['admincensos']===true) {
            // El usuario logueado no tiene permisos de acceso al modo restringuido del gestor de censos. Entonces:
            // Compruebo si está establecida la accion en el supergobal POST.
            if (isset($_POST['accion'])) {
                // Está establecida la acción en el superglobal POST. Entonces:                
                // Recupero la acción solicitada desde un listado del gestor de participantes
                $accion = $_POST['accion'];
                // Si desde un listado del gestor de participantes se envía el identificador de jornadas. Entonces:
                // Establezco la variable sesion con el identificador de la jornada seleccionado en el listado
                if (isset($_POST['idJornada'])) {$_SESSION['listado'] = $_POST['idJornada'];}
                // Proceso la acción solicitadas por usuarios no administradores desde el gestor
                switch ($accion) {
                    case "listado:detalles":
                        // Establezco la variable de sesión para volver al gestor de participantes 
                        // tras consultar detalles de una jornada disponible a inscripción.
                        $_SESSION['volver'] = $_SERVER['REQUEST_URI'];                    
                        // Solicito al controlador de jornadas que muestre los detalles de la jornada
                        // abierta a inscripción que el usuario desea consultar.
                        Jornadas::consultarDetallesJornadaPlataforma($smarty);                        
                        break;
                    case "listado:iniciar:censo":
                        // Inicio el censo de aves de la jornada censal
                        break;
                    case "listado:cancelar:censo":
                        // Cancelo el censo de aves  de la jornada censal
                        break;
                    default:
                        // La acción por defecto es salir del modo restringido del gestor de censos
                        $_SESSION['admincensos']=false;
                        // Muestro la vista del histórico de censos al usuario
                        Censos::mostrarHistoricosCensos($smarty);
                        break;
                }
            } else {
                // De lo contrario, le muestro su vista por defecto del listatdo de jornadas censales.
                Censos::listarJornadasCensalesPlataforma($smarty);
            }                       
        } else {
            // De lo contrario, el usuario logueado no tiene permisos de acceso al modo restringuido del gestor de censos o
            // el modo restringido no está activo para usuarios autorizados
            // Compruebo si está establecida la accion en el supergobal POST.
            if (isset($_POST['accion'])) {
                // Está establecida la acción en el superglobal POST. Entonces:                
                // Recupero la acción solicitada desde un listado del gestor de participantes
                $accion = $_POST['accion'];
                // Si desde un listado del gestor de participantes se envía el identificador de jornadas. Entonces:
                // Establezco la variable sesion con el identificador de la jornada seleccionado en el listado
                if (isset($_POST['idJornada'])) {$_SESSION['listado'] = $_POST['idJornada'];}
                // Proceso la acción solicitadas por usuarios no administradores desde el gestor
                switch ($accion) {
                    case "historico:detalles":
                        // Muestro la vista con los detalles censales de la jornada
                        Censos::mostrarVistaCensoAves($smarty);
                        break;
                    case "historico:edicion":
                        // Muestro la vista con los detalles centales de la jornada en modo edición
                        break;
                    case "historico:borrado":
                        // Muestro la confirmación de baja de una jornada censal
                        break;
                    case "historico:cierre":
                        // Muestro la confirmación para cerrar una jornada al censo de aves
                        break;
                    case "censo:registrar":
                        // Muestro la vista para añadir un registro censal a la plataforma
                        break;
                    case "censo:asistencia":
                        // Muestro vista para la confirmación de asistencia de los participantes
                        break;
                    case "censo:detalles":
                        // Muestro los detalles de un registro censal determinado
                        break;
                    case "censo:edicion":
                        // Muestro la vista de edición de un registro censal determinado
                        break;
                    case "censo:borrado":
                        // Muestra la confirmación de baja de un registro censal determinado
                        break;                                                
                    case "censo:finalizar":
                        // Muestro la confirmación para cerrar una jornada al censo de aves 
                        break;
                    case "censo:salir":
                        // Muestro la vista del histórico de censos
                        Censos::mostrarHistoricosCensos($smarty);
                        break;
                    default:
                        // La acción por defecto es activarle el modo restringido del gestor de censos a los usuarios autorizados
                        $_SESSION['admincensos']=true;
                        // Muestro la vista del histórico de censos al usuario
                        Censos::listarJornadasCensalesPlataforma($smarty);                        
                        break;
                }
            } else {
                // De lo contario, le muestro su vista por defecto de histórico de censos
                Censos::mostrarHistoricosCensos($smarty);
            }
        }

    }

    // A) Método estáticos privados para gestioanr las vistas específicas solicitada desde el listado

    /**
     * Método estático auxiliar para mostrar la vista con el listado de jornadas censales disponibles en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema de permisos del usuario
     */    
    private static function listarJornadasCensalesPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si es usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // Genero el listado de jornadas  disponibles en la plataforma
            $datos = Censo::listarJornadasCensales();

            // Asigno las variables requeridas por la plantila del listado de jornadas
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisos', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('hoy', date('d-m-Y'));
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de jornadas
            $smarty->display('censos/listado.tpl');              
        } else {
            // lazo una excepción para notificar al usuario que no tiene permisos para incribirse a jornadas en la plataforma
            throw new AppException("Su usuario NO tiene permisos para censar aves en la plataforma!!!");            
        }

    }

    /**
     * Método estático auxiliar para mostrar la vista con el histórico de censos en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema de permisos del usuario
     */    
    private static function mostrarHistoricosCensos($smarty) {

        // Obtengo al usuario de la sesión de navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tenga un rol conocido por la plataforma
        if ($permisosUsuario->hasRolDesconocidoPlataforma()) {

            // Genero el listado de jornadas  disponibles en la plataforma
            $datos = Censo::listarHistoricoCensos();

            // Asigno las variables requeridas por la plantila del listado de jornadas
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisos', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de jornadas
            $smarty->display('censos/historico.tpl');  

        } else {
            // lazo una excepción para notificar al usuario que no tiene permisos para incribirse a jornadas en la plataforma
            throw new AppException("No está autorizado a ejecutar esta acción porque su rol en la plataforma es desconocido!!!");
        }

    }

    /**
     * Método estático auxiliar para mostrar la vista con el histórico de censos en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema de permisos del usuario
     */     
    private static function mostrarVistaCensoAves($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo que el usuario logueado tenga un rol conocido por la plataforma
        if ($permisosUsuario->hasRolDesconocidoPlataforma()) {
            // El usuario tiene un rol reconocido por la plataforma. Entonces:
            // Compruebo que el usuario loqueado eligió una jornada del listado
            if (isset($_SESSION['listado'])) {   
                // Recupero el identificador de la jornada elegida por el usuario desde su sesion
                $idJornada = $_SESSION['listado'];
                // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);
                // Recupero la jornada censal elegida por el usuario que desea consultar detalles del censo
                $jornada = Jornada::consultarJornada($idJornada);
                // Compruebo si la jornada elegida existe en la base de datos
                if ($jornada instanceof Jornada) {
                    // Se ha podido recuperar la jornada de la base de datos. Entonces:
                    // Recupero los datos del observatorio asociado a la jornada elegida
                    $observatorio=Observatorio::consultarObservatorio($jornada->getIdObservatorioJornada());
                    // Compruebo si el observatorio asociado a la jornada existe en la base de datos
                    if ($observatorio instanceof Observatorio) {
                        // Se ha posido recuperar al observatorio asociadp a la jornada. Entonces:
                        // Recupero el listado de participantes de la jornada censal deseada
                        $participantes=Censo::listarParticipantesJornadaCensal($idJornada);
                        foreach($participantes as $participante) {
                            $listaParticipantes[]=$participante['usuario'];
                        }
                        $participantes=implode("|", $listaParticipantes);
                        // Genero el lugar donde se desarrolla la jornada donde se inscribe
                        $lugar=$observatorio->getNombreObservatorio() . " - " . $observatorio->getDireccionObservatorio() . 
                            " - " . $observatorio->getLocalidadObservatorio();
                        // Recupero la fecha de la jornada en formato DD-MM-YYYY
                        $fechaJornada = new DateTime($jornada->getFechaJornada());
                        // Genero el horario de la jornada a la que se inscribe
                        $horario=$fechaJornada->format('d-m-Y') . " (" . $jornada->getHoraInicioJornada() . " - " 
                            . $jornada->getHoraFinJornada() . ")";
                        // Recopilo la información de la plantilla para mostrar inscripción a una jornada
                        $perfil = ['participantes' => $participantes, 'titulo' => $jornada->getTituloJornada(),
                            'lugar' => $lugar, 'fecha' => $fechaJornada->format('d-m-Y'),'horario' => $horario, 
                            'observaciones' => $jornada->getInformacionJornada()];
                        // Recupero los registros censales de la jornada censal deseada
                        $registrosCensales=Censo::listarRegistrosCensales($idJornada);
                        // Asigno las variables requeridas por la plantila de detalles de una jornada
                        $smarty->assign('usuario', $usuario->getUsuario());
                        $smarty->assign('permisos', $permisosUsuario);
                        $smarty->assign('censable', false);
                        $smarty->assign('perfil', $perfil);
                        $smarty->assign('filas', $registrosCensales);
                        $smarty->assign('anyo', date('Y'));
                        // Muestro la plantilla de detalles del censo de una jornada censal con sus datos
                        $smarty->display('censos/censo.tpl');  
                    } else {
                        // De lo contario, lanzo una excepción para notificar al usuario que el
                        // observatorio asociado a la jornada censal deseada no existe en la base de datos
                        throw new AppException(message: "El observatorio de la jornada censal elegida no existe en la base de datos!!!",
                        urlAceptar: "/plataforma/backoffice.php?comando=censos:default");
                    }
                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // jornada censal deseada no existe en la base de datos
                    throw new AppException(message: "La jornada censal elegida no existe en la base de datos!!!",
                    urlAceptar: "/plataforma/backoffice.php?comando=censos:default");  
                }         
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió un censo del listado
                throw new AppException("No ha elegido una jornada censal del listado. Por favor, eliga una. Gracias!");            
            }
        } else {
            // lazo una excepción para notificar al usuario que no tiene permisos para incribirse a jornadas en la plataforma
            throw new AppException("No está autorizado a ejecutar esta acción porque su rol en la plataforma es desconocido!!!");
        }

    }

    // B) Métodos estáticos públicos para procesar los datos de las vistas específicas
    
    
    // C) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados    

}

?>
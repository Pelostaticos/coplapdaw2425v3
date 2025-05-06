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
use correplayas\modelo\Ave;
use correplayas\modelo\Censo;
use correplayas\modelo\Jornada;
use correplayas\modelo\Observatorio;
use correplayas\modelo\Participante;
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
                        Censos::mostrarConfirmacionInicioCensoPlataforma($smarty);
                        break;
                    case "listado:continuar:censo":
                        // Salgo del modo restringido del gestor de censos
                        $_SESSION['admincensos']=false;                        
                        // Continuo el censo de aves de la jornada censal
                        Censos::mostrarVistaCensoAves($smarty, modoEdicion: true);
                        break;                        
                    case "listado:cancelar:censo":
                        // Cancelo el censo de aves  de la jornada censal
                        Censos::mostrarConfirmacionCancelacionCensoPlataforma($smarty);
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
                        Censos::mostrarVistaCensoAves($smarty, modoEdicion: true);
                        break;
                    case "historico:cancelar":
                        // Muestro la confirmación de cancelación de una jornada censal
                        Censos::mostrarConfirmacionCancelacionCensoPlataforma($smarty);
                        break;
                    case "historico:cierre":
                        // Muestro la confirmación para cerrar una jornada al censo de aves
                        Censos::mostrarConfirmacionFinalizacionCensoPlataforma($smarty);
                        break;
                    case "censo:registrar":
                        // Muestro la vista para añadir un registro censal a la plataforma
                        Censos::mostrarVistaAñadirRegistroCensal($smarty);
                        break;
                    case "censo:asistencia":
                        // Muestro vista para la confirmación de asistencia de los participantes
                        Censos::mostrarVistaConfirmaciónAsistencia($smarty);
                        break;
                    case "censo:detalles":
                        // Muestro los detalles de un registro censal determinado
                        Censos::mostrarVistaDetallesRegistroCensal($smarty);
                        break;
                    case "censo:edicion":
                        // Muestro la vista de edición de un registro censal determinado
                        Censos::mostrarVistaEdicionRegistroCensal($smarty);
                        break;
                    case "censo:borrado":
                        // Muestra la confirmación de baja de un registro censal determinado
                        Censos::mostrarVistaConfirmaciónBajaRegistroCensal($smarty);
                        break;                                                
                    case "censo:finalizar":
                        // Muestro la confirmación para cerrar una jornada al censo de aves
                        Censos::mostrarConfirmacionFinalizacionCensoPlataforma($smarty);
                        break;
                    case "censo:validar":
                        // Muestro la confirmación para validar el censo de aves de una jornada
                        Censos::mostrarConfirmacionValidacionCensoPlataforma($smarty);
                        break;
                    case "censo:sinasistencia":
                        // Muestro la vista del censo de aves tras un intento de finalización fallido
                        Censos::mostrarVistaCensoAves($smarty, modoEdicion: true);
                        break;                      
                    case "censo:salir":
                        // Muestro la vista del histórico de censos
                        Censos::mostrarHistoricosCensos($smarty);
                        break;
                    case "censo:volver":
                        // Muestro la vista del censo de aves tras acción del registro censal
                        Censos::mostrarVistaCensoAves($smarty, modoEdicion: true);
                        break;
                    case "cancelacion:confirmo":
                        // Proceso la cancelación de la jornadaa censal deseada
                        Censos::cancelarCensosAvesPlatforma($smarty);
                        break;
                    case "asistencia:cancelar":
                        // Muestro la vista del censo de aves tras cancelar la confirmación de asistencia al censo
                        Censos::mostrarVistaCensoAves($smarty, modoEdicion: true);
                        break;                        
                    case "asistencia:aceptar":
                        // Proceso la confirmación de asistencia de participantes al censo de aves
                        Censos::confirmarAsistenciaParticipantes($smarty);
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

    /**
     * Método estático auxiliar para mostrar la vista por defecto con el histórico de censos en la plataforma
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
        if (!$permisosUsuario->hasRolDesconocidoPlataforma()) {

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

    // A) Método estáticos privados para gestioanr las vistas específicas solicitada desde el historico

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
            // Genero el listado de jornadas disponibles en la plataforma
            $listadoJornadaCensalessDisponibles = Censo::listarJornadasCensalesDisponibles();

            // Genero el listado de jornadas iniciadas en la plataforma
            $listadoJornadaCensalesIniciadas=Censo::listarJornadasCensalesIniciadas();

            // Genero el listado definitivo con las jornadas censales disponibles al censo de aves
            $datos=array_merge($listadoJornadaCensalessDisponibles, $listadoJornadaCensalesIniciadas);

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
     * Método estático auxiliar para mostrar la vista con detalles de un censo de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @param boolean $modoEdicion Bandera de controlar el modo de la vista censo de aves
     *                      >> true: Se muestra el modo edición al usuario autorizado.
     *                      >> false: Se muestra el modo detalles a cualquier usuario. (Por defecto)
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema de permisos del usuario
     */     
    private static function mostrarVistaCensoAves($smarty, $modoEdicion=false) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo que el usuario logueado tenga un rol conocido por la plataforma
        if (!$permisosUsuario->hasRolDesconocidoPlataforma()) {
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
                        $participantes=Participante::listarParticipantesJornadaCensal($idJornada);
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
                        // Compruebo la configuración establecida para em modo de la vista censo de aves
                        if ($modoEdicion) {
                            // El modo edición está habilitado para la vista censo de aves. Entonecs:
                            // Determino si la jornada es censable por el usuario logueado.
                            $censable=$jornada->esJornadaCensable($permisosUsuario);
                            // Determino si la jornada es validable por el usuario logueado
                            $validable=$jornada->esJornadaValidable($permisosUsuario);
                            // Emulo aquí que el usuario hace clic en el listado de jornadas
                            $_SESSION['listado']=$idJornada;
                            /* OBSERVACIONES: Se trata solución poco elegante pero funcional dado que mi inexpereciencia
                            en el desarrollo de aplicaciones web, ha hecho que no tenga en cuenta adecuamdamente la lógica
                            de navegación por las distintas interfaces del usuario tanto redirección como variables para el
                            funcionamiento de las acciones que se llaman desde cada una de las vista */                            
                        } else {
                            // De lo contrario, el modo edición está deshabilitadp y por tanto se considera que
                            // la jornada censal elegida no es censable por defecto.
                            $censable=false;
                            $validable=false;
                        }

                        // Asigno las variables requeridas por la plantila de detalles de una jornada
                        $smarty->assign('usuario', $usuario->getUsuario());
                        $smarty->assign('permisos', $permisosUsuario);
                        $smarty->assign('censable', $censable);
                        $smarty->assign('validable', $validable);
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

    // B) Método estáticos privados para gestioanr las vistas específicas solicitada desde el listado

    /**
     * Método auxiliar para mostrar la confirmación del inicio de un censo de aves en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function mostrarConfirmacionInicioCensoPlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea iniciar el censo
            if (isset($_POST['idJornada'])) {
                // Establezco la configuración del mensaje de confirmación para el usuario autorizado
                $mensaje = "Has solicitado iniciar el censo de una jornada de la plataforma";
                $pregunta = "¿Estás seguro que quieres iniciar a dicho censo?";
                $urlCancelar = "/plataforma/backoffice.php?comando=censos:default";
                $urlAceptar = "/plataforma/backoffice.php?comando=censos:iniciar:procesa";
                // Muestro el mensaje de confirmación de inicio del censo de aves al usuario
                ErrorController::mostarMensajeAdvertencia($smarty,$mensaje,$pregunta,$urlCancelar,$urlAceptar);
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para censar aves
            throw new AppException("Su rol en la plataforma no le permite iniciar el censo de aves");            
        }
    }

    /**
     * Método auxiliar para mostrar la confirmación de la cancelacion de un censo de aves en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function mostrarConfirmacionCancelacionCensoPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea cancelar el censo
            if (isset($_POST['idJornada'])) {

                // Recupero el identificador de la jornada elegida por el usuario desde su sesion
                $idJornada = $_SESSION['listado'];
                // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);
                // Recupero la jornada censal elegida por el usuario que desea cancelar el censo de aves
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
                        $participantes=Participante::listarParticipantesJornadaCensal($idJornada);
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
                        // Asigno las variables requeridas por la plantila de detalles de una jornada
                        $smarty->assign('usuario', $usuario->getUsuario());
                        $smarty->assign('permisos', $permisosUsuario);
                        $smarty->assign('perfil', $perfil);
                        $smarty->assign('anyo', date('Y'));
                        // Muestro la plantilla de detalles del censo de una jornada censal con sus datos
                        $smarty->display('censos/cancelacion.tpl');  
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
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada censal del listado. Por favor, eliga una. Gracias!");                
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para cancelar joirnadas censales
            throw new AppException("Su rol en la plataforma no le permite cancelar jornadas censales");            
        }
    }
       
    /**
     * Método auxiliar para mostrar la confirmación de la finalizacion de un censo de aves en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function mostrarConfirmacionFinalizacionCensoPlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea iniciar el censo
            if (isset($_SESSION['listado'])) {
                // Establezco la configuración del mensaje de confirmación para el usuario autorizado
                $mensaje = "Has solicitado finalizar el censo de una jornada de la plataforma";
                $pregunta = "¿Estás seguro que quieres dar por finalizado a dicho censo?";
                $urlCancelar = "/plataforma/backoffice.php?comando=censos:default";
                $urlAceptar = "/plataforma/backoffice.php?comando=censos:finalizar:procesa";
                // Muestro el mensaje de confirmación de finalización del censo de aves al usuario
                ErrorController::mostarMensajeAdvertencia($smarty,$mensaje,$pregunta,$urlCancelar,$urlAceptar);
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para finalizar el censo de aves
            throw new AppException("Su rol en la plataforma no le permite finalizar el censo de aves");            
        }
    }

    /**
     * Método auxiliar para mostrar la confirmación de la validación de un censo de aves en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function mostrarConfirmacionValidacionCensoPlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea iniciar el censo
            if (isset($_POST['idJornada'])) {
                // Establezco la configuración del mensaje de confirmación para el usuario autorizado
                $mensaje = "Has solicitado validar el censo de una jornada de la plataforma";
                $pregunta = "¿Estás seguro que quieres validar dicho censo?";
                $urlCancelar = "/plataforma/backoffice.php?comando=censos:default";
                $urlAceptar = "/plataforma/backoffice.php?comando=censos:validar:procesa";
                // Muestro el mensaje de confirmación de validación del censo de aves al usuario
                ErrorController::mostarMensajeAdvertencia($smarty,$mensaje,$pregunta,$urlCancelar,$urlAceptar);
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para validar el censo de aves
            throw new AppException("Su rol en la plataforma no le permite validar el censo de aves");            
        }
    }    

    // C) Método estáticos privados para gestioanr las vistas específicas solicitada desde el censo

    /**
     * Método auxiliar para mostrar la vista de confirmación de asistencia de participantes al censo de aves
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function mostrarVistaConfirmaciónAsistencia($smarty) {
        
        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];        
        
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si existe una jornada censal previamente elegida por el usuario logueado
        if (isset($_SESSION['listado'])) {
            // Recupero el identificador de la jornada elegida por el usuario desde su sesion
            $idJornada = $_SESSION['listado'];
            // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
            // ya ha cumpplido su función aquí
            unset($_SESSION['listado']);
            // Recupero la jornada censal elegida por el usuario que desea consultar detalles del censo
            $jornada = Jornada::consultarJornada($idJornada);
            // Evaluo si la jornada censal deseada es editable por el usuario logueado
            $jornadaEditable=$jornada->esJornadaCensable($permisosUsuario) xor $jornada->esJornadaValidable($permisosUsuario);
            // Compruebo si la jornada elegida existe en la base de datos y el usuario loguerado tiene permisos de edición de censos
            if ($jornada instanceof Jornada && $jornadaEditable) {
                // Emulo que el usuario logueado hizo clic en una jornada censal previamente
                $_SESSION['listado']=$idJornada;
                // Recupero el listado de participantes de la jornada censal deseada
                $participantes=Participante::listarParticipantesJornadaCensal($idJornada);
                // Asigno las variables requeridas por la plantila de detalles de una jornada
                $smarty->assign('usuario', $usuario->getUsuario());
                $smarty->assign('permisos', $permisosUsuario);
                $smarty->assign('jornada', $jornada);
                $smarty->assign('filas', $participantes);
                $smarty->assign('anyo', date('Y'));
                // Muestro la plantilla de detalles del censo de una jornada censal con sus datos
                $smarty->display('censos/asistencia.tpl');  
            } else {
                // lazo una excepción para notificar al usuario que no está autorizado a confirmar asistencia a jornadas censales
                throw new AppException("No está autorizado a confirma la asistencia a jornadas censales!!!");
            }
        } else {
            // Lanzo una excepción para notificar que el usuario no eligió un censo del listado
            throw new AppException("No ha elegido una jornada censal del listado. Por favor, eliga una. Gracias!");
        }

    }

    /**
     * Método auxiliar para mostrar la vista para añadir nuevos registros censales de aves
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */    
    private static function mostrarVistaAñadirRegistroCensal($smarty) {

        // Recupero al usuario logueado de la sesión
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si existe una jornada censal previamente elegida por el usuario logueado
        if (isset($_SESSION['listado'])) {
            // Recupero el identificador de la jornada elegida por el usuario desde su sesion
            $idJornada = $_SESSION['listado'];
            // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
            // ya ha cumpplido su función aquí
            unset($_SESSION['listado']);
            // Recupero la jornada censal elegida por el usuario a la que desea añadir registros censales
            $jornada = Jornada::consultarJornada($idJornada);
            // Evaluo si la jornada censal deseada es editable por el usuario logueado
            $jornadaEditable=$jornada->esJornadaCensable($permisosUsuario) xor $jornada->esJornadaValidable($permisosUsuario);
            // Compruebo si la jornada elegida existe en la base de datos y el usuario loguerado tiene permisos de edición de censos
            if ($jornada instanceof Jornada && $jornadaEditable) {
                // Emulo que el usuario logueado hizo clic en una jornada censal previamente
                $_SESSION['listado']=$idJornada;
                // Recopilo la información de la plantilla para añadir registros censales a una jornada
                $perfil = ['idJornada' => $idJornada, 'hora' => date('H:i:s')];
                // Asigno las variables requeridas por la plantila de añadir registros censales a una jornada
                $smarty->assign('usuario', $usuario->getUsuario());
                $smarty->assign('permisos', $permisosUsuario);
                $smarty->assign('perfil', $perfil);
                $smarty->assign('anyo', date('Y'));
                // Muestro la plantilla de añadir registris censales a una jornada con sus datos
                $smarty->display('censos/registro.tpl');                 
            } else {
                // lazo una excepción para notificar al usuario que no está autorizado a añadir registros censales
                throw new AppException("No está autorizado a añadir registros censales!!!");                
            }
        } else {
            // Lanzo una excepción para notificar que el usuario no eligió un censo del listado
            throw new AppException("No ha elegido una jornada censal del listado. Por favor, eliga una. Gracias!");
        }

    }

    /**
     * Método auxiliar para mostrar la vista para editar registros censales de aves
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */       
    private static function mostrarVistaEdicionRegistroCensal($smarty) {
        // Recupero al usuario logueado de la sesión
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si existe una jornada censal previamente elegida por el usuario logueado
        if (isset($_SESSION['listado'])) {
            // Recupero el identificador de la jornada elegida por el usuario desde su sesion
            $idJornada = $_SESSION['listado'];
            // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
            // ya ha cumpplido su función aquí
            unset($_SESSION['listado']);
            // Recupero la jornada censal elegida por el usuario que desea editar su registro censal
            $jornada = Jornada::consultarJornada($idJornada);
            // Evaluo si la jornada censal deseada es editable por el usuario logueado
            $jornadaEditable=$jornada->esJornadaCensable($permisosUsuario) xor $jornada->esJornadaValidable($permisosUsuario);
            // Compruebo si la jornada elegida existe en la base de datos y el usuario loguerado tiene permisos de edición de censos
            if ($jornada instanceof Jornada && $jornadaEditable) {
                // Recupero de los datos adicionales de la clave primaria de un registro censal
                $especie=filter_input(INPUT_POST, 'especie');
                $hora=filter_input(INPUT_POST, 'hora');
                // Genero la clave primaria del registro censal que se desea editar
                $registroCensal=['idJornada' => $idJornada,
                    'especie' => $especie, 'hora' => $hora];
                // Recupero al registro censal desde la base de datos por su clave primaria
                $censo=Censo::consultarRegistroCensal($registroCensal);
                // Recupero información del ave del registro censal recuperadp
                $ave=Ave::consultarAve($especie);
                // Compruebo si el registro censal deseado con su ave censada existen en la base de dato
                if ($censo instanceof Censo && $ave instanceof Ave) {
                    // Emulo que el usuario logueado hizo clic en una jornada censal previamente
                    $_SESSION['listado']=$idJornada;
                    // Recopilo la información de la plantilla para añadir registros censales a una jornada
                    $perfil = ['idJornada' => $idJornada, 'especie' => $especie, 'hora' => $hora,
                        'familia' => $ave->getFamiliaAve()->getFamilia(), 'orden' => $ave->getFamiliaAve()->getOrden()->getOrden(),
                        'cantidad' => $censo->getCantidad(), 'nubosidad' => $censo->getNubosidad(),
                        'visibilidad' => $censo->getVisibilidad(), 'dirviento' => $censo->getDireccionViento(),
                        'velviento' => $censo->getVelocidadViento(), 'procedencia' => $censo->getProcedenciaAve(),
                        'destino' => $censo->getDestinoAve(), 'altvuelo' => $censo->getAltturaVueloAve(),
                        'formavuelo' => $censo->getFormsaVueloAve(), 'distcosta' => $censo->getDistanciaCostaAve(),
                        'comentario' => $censo->getComentario()];
                    // Asigno las variables requeridas por la plantila de añadir registros censales a una jornada
                    $smarty->assign('usuario', $usuario->getUsuario());
                    $smarty->assign('permisos', $permisosUsuario);
                    $smarty->assign('perfil', $perfil);
                    $smarty->assign('anyo', date('Y'));
                    // Muestro la plantilla de añadir registris censales a una jornada con sus datos
                    $smarty->display('censos/edicion.tpl');                       
                } else {
                    // lazo una excepción para notificar al usuario que no existe el registro censal deseado
                    throw new AppException("No existe el registro censal indicado!!!");  
                }
            } else {
                // lazo una excepción para notificar al usuario que no está autorizado a editar registros censales
                throw new AppException("No está autorizado a editar registros censales!!!");   
            } 
        } else {
            // Lanzo una excepción para notificar que el usuario no eligió un censo del listado
            throw new AppException("No ha elegido una jornada censal del listado. Por favor, eliga una. Gracias!");
        }     
    }


    /**
     * Método auxiliar para mostrar la vista para mostrar detalles de un registro censal de aves
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */       
    private static function mostrarVistaDetallesRegistroCensal($smarty) {
        // Recupero al usuario logueado de la sesión
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si existe una jornada censal previamente elegida por el usuario logueado
        if (isset($_SESSION['listado'])) {
            // Recupero el identificador de la jornada elegida por el usuario desde su sesion
            $idJornada = $_SESSION['listado'];
            // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
            // ya ha cumpplido su función aquí
            unset($_SESSION['listado']);
            // Recupero la jornada censal elegida por el usuario que desea editar su registro censal
            $jornada = Jornada::consultarJornada($idJornada);
            // Evaluo si la jornada censal deseada es editable por el usuario logueado
            $jornadaEditable=$jornada->esJornadaCensable($permisosUsuario) xor $jornada->esJornadaValidable($permisosUsuario);
            // Compruebo si la jornada elegida existe en la base de datos y el usuario loguerado tiene permisos de edición de censos
            if ($jornada instanceof Jornada && $jornadaEditable) {
                // Recupero de los datos adicionales de la clave primaria de un registro censal
                $especie=filter_input(INPUT_POST, 'especie');
                $hora=filter_input(INPUT_POST, 'hora');
                // Genero la clave primaria del registro censal que se desea consultar detalles
                $registroCensal=['idJornada' => $idJornada,
                    'especie' => $especie, 'hora' => $hora];
                // Recupero al registro censal desde la base de datos por su clave primaria
                $censo=Censo::consultarRegistroCensal($registroCensal);
                // Recupero información del ave del registro censal recuperado
                $ave=Ave::consultarAve($especie);
                // Compruebo si el registro censal deseado con su ave censada existen en la base de dato
                if ($censo instanceof Censo && $ave instanceof Ave) {
                    // Emulo que el usuario logueado hizo clic en una jornada censal previamente
                    $_SESSION['listado']=$idJornada;
                    // Recopilo la información de la plantilla para añadir registros censales a una jornada
                    $perfil = ['idJornada' => $idJornada, 'especie' => $especie, 'hora' => $hora,
                        'familia' => $ave->getFamiliaAve()->getFamilia(), 'orden' => $ave->getFamiliaAve()->getOrden()->getOrden(),
                        'cantidad' => $censo->getCantidad(), 'nubosidad' => $censo->getNubosidad(),
                        'visibilidad' => $censo->getVisibilidad(), 'dirviento' => $censo->getDireccionViento(),
                        'velviento' => $censo->getVelocidadViento(), 'procedencia' => $censo->getProcedenciaAve(),
                        'destino' => $censo->getDestinoAve(), 'altvuelo' => $censo->getAltturaVueloAve(),
                        'formavuelo' => $censo->getFormsaVueloAve(), 'distcosta' => $censo->getDistanciaCostaAve(),
                        'comentario' => $censo->getComentario()];
                    // Asigno las variables requeridas por la plantila de añadir registros censales a una jornada
                    $smarty->assign('usuario', $usuario->getUsuario());
                    $smarty->assign('permisos', $permisosUsuario);
                    $smarty->assign('perfil', $perfil);
                    $smarty->assign('anyo', date('Y'));
                    // Muestro la plantilla de añadir registris censales a una jornada con sus datos
                    $smarty->display('censos/detalles.tpl');                     
                } else {
                    // lazo una excepción para notificar al usuario que no existe el registro censal deseado
                    throw new AppException("No existe el registro censal indicado!!!");  
                }
            } else {
                // lazo una excepción para notificar al usuario que no está autorizado a editar registros censales
                throw new AppException("No está autorizado a consultar registros censales!!!");   
            }
        } else {
            // Lanzo una excepción para notificar que el usuario no eligió un censo del listado
            throw new AppException("No ha elegido una jornada censal del listado. Por favor, eliga una. Gracias!");
        }
    }

    /**
     * Método auxiliar para mostrar la confirmación de la baja de un registro censal en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function mostrarVistaConfirmaciónBajaRegistroCensal($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea iniciar el censo
            if (isset($_POST['idJornada'])) {
                // Establezco la configuración del mensaje de confirmación para el usuario autorizado
                $mensaje = "Has solicitado eliminar un registro censal de una jornada de la plataforma";
                $pregunta = "¿Estás seguro que quieres eliminar dicho registro censal?";
                $urlCancelar = "/plataforma/backoffice.php?comando=censos:default";
                $urlAceptar = "/plataforma/backoffice.php?comando=censos:eliminar:procesa";
                // Muestro el mensaje de confirmación de validación del censo de aves al usuario
                ErrorController::mostarMensajeAdvertencia($smarty,$mensaje,$pregunta,$urlCancelar,$urlAceptar);
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para validar el censo de aves
            throw new AppException("Su rol en la plataforma no le permite eliminar un registro censal");            
        }
    }

    // D) Métodos estáticos públicos para procesar los datos de las vistas específicas
    
    /**
     * Método estático para inicial el censo de aves en una jornada censal de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function iniciarCensosAvesPlatforma($smarty) {
        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];        
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea iniciar el censo
            if (isset($_POST['idJornada'])) {
                // Recupero el identificador de la jornada elegida por el usuario desde su sesion
                $idJornada = $_SESSION['listado'];
                // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);
                // Recupero la jornada censal elegida por el usuario que desea iniciar el censo de aves
                $jornada = Jornada::consultarJornada($idJornada);
                // Compruebo si la jornada elegida existe en la base de datos
                if ($jornada instanceof Jornada) {
                    // Establezco el estado de la jornada a iniciar el censo de aves como: CERRADA
                    $jornada->setEstadoJornada('CERRADA');
                    // Añado marca de trazabilidad de la jornada censal
                    $observaciones=$jornada->getInformacionJornada();
                    $observaciones .= "<br><<--- El usuario responsable " . $usuario->getUsuario();
                    $observaciones .= " ha iniciado la jornada a las: " . date('d-m-Y H:i:s');
                    $jornada->setInformacionJornada($observaciones);                    
                    // Actualizo la jornada en la base de datos de la plataforma
                    if ($jornada->actualizarJornada()) {
                        // Emulo aquí que el usuario hace clic en el listado de jornadas
                        $_SESSION['listado']=$idJornada;
                        /* OBSERVACIONES: Se trata solución poco elegante pero funcional dado que mi inexpereciencia
                        en el desarrollo de aplicaciones web, ha hecho que no tenga en cuenta adecuamdamente la lógica
                        de navegación por las distintas interfaces del usuario tanto redirección como variables para el
                        funcionamiento de las acciones que se llaman desde cada una de las vista */

                        // Muestro la vista del censo de aves en modo edición
                        Censos::mostrarVistaCensoAves($smarty, modoEdicion: true);
                    } else {
                        // De lo contario, lanzo una excepción para notificar al usuario que NO es 
                        // posible iniciar el censo de aves de la jornada deseada
                        throw new AppException(message: "No es posible iniciar el censo de aves en la jornada deseada!!!
                        Conctacte con los administradores para mayor información. ¡Gracias por participar!",
                        urlAceptar: "/plataforma/backoffice.php?comando=core:email:vista");  
                    }
                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // jornada censal deseada no existe en la base de datos
                    throw new AppException(message: "La jornada censal elegida no existe en la base de datos!!!",
                    urlAceptar: "/plataforma/backoffice.php?comando=censos:default");                      
                }
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                 
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para censar aves
            throw new AppException("Su rol en la plataforma no le permite iniciar el censo de aves");            
        }
    }

    /**
     * Método estático para cancelar el censo de aves en una jornada censal de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function cancelarCensosAvesPlatforma($smarty) {
        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea cancelar el censo
            if (isset($_POST['idJornada'])) {
                // Recupero el identificador de la jornada elegida por el usuario desde su sesion
                $idJornada = $_SESSION['listado'];
                // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);
                // Recupero la jornada censal elegida por el usuario que desea cancelar el censo de aves
                $jornada = Jornada::consultarJornada($idJornada);
                // Compruebo si la jornada elegida existe en la base de datos
                if ($jornada instanceof Jornada) {
                    // Establezco el estado de la jornada a cancelar el censo de aves como: CANCELADA
                    $jornada->setEstadoJornada('CANCELADA');
                    // Añado los motivos de cancelación a las observaciones de la jornada
                    $observaciones=$jornada->getInformacionJornada();
                    $motivos=filter_input(INPUT_POST,'frm-motivos');
                    $observaciones .= "<br><<--- El usuario responsable " . $usuario->getUsuario() . " cancelar esta jornada por los motivos: ";
                    $observaciones .= $motivos;
                    $jornada->setInformacionJornada($observaciones);
                    // Actualizo la jornada en la base de datos de la plataforma
                    if ($jornada->actualizarJornada()) {
                        // Notifico al usuario que la cancelación de la jornada censal fue existosa
                        ErrorController::mostrarMensajeInformativo($smarty, "Jornada censal cancelada con éxito!!", 
                            "/plataforma/backoffice.php?comando=censos:default");
                    } else {
                        // De lo contario, lanzo una excepción para notificar al usuario que NO es 
                        // posible cancelar el censo de aves de la jornada deseada
                        throw new AppException(message: "No es posible cancelar el censo de aves en la jornada deseada!!!
                        Conctacte con los administradores para mayor información. ¡Gracias por participar!",
                        urlAceptar: "/plataforma/backoffice.php?comando=core:email:vista");  
                    }
                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // jornada censal deseada no existe en la base de datos
                    throw new AppException(message: "La jornada censal elegida no existe en la base de datos!!!",
                    urlAceptar: "/plataforma/backoffice.php?comando=censos:default");                      
                }
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                 
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para cancelar un censo de aves
            throw new AppException("Su rol en la plataforma no le permite cancelar el censo de aves");            
        }
    }
    
    /**
     * Método estático para finalizar el censo de aves en una jornada censal de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function finalizarCensosAvesPlatforma($smarty) {
        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea finalizar el censo
            if (isset($_SESSION['listado'])) {
                // Recupero el identificador de la jornada elegida por el usuario desde su sesion
                $idJornada = $_SESSION['listado'];
                // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);
                // Recupero la jornada censal elegida por el usuario que desea finalizar el censo de aves
                $jornada = Jornada::consultarJornada($idJornada);
                // Compruebo si el usuario responsable de la jornada censal confirmado asistencia                
                $confirmaAsistencia=Participante::verificarAsistenciaParticipantesConfirmada($idJornada);
                // Compruebo si la jornada elegida existe en la base de datos y confirma asistencia participantes
                if ($jornada instanceof Jornada && $confirmaAsistencia) {
                    // Establezco la confirmación de asistebcia a la jornada censal
                    $jornada->setControlAsistenciaJornada(1);
                    // Añado marca de trazabilidad de la jornada censal
                    $observaciones=$jornada->getInformacionJornada();
                    $observaciones .= "<br><<--- El usuario responsable " . $usuario->getUsuario();
                    $observaciones .= " ha finalizado la jornada a las: " . date('d-m-Y H:i:s');
                    $jornada->setInformacionJornada($observaciones);                      
                    // Actualizo la jornada en la base de datos de la plataforma
                    if ($jornada->actualizarJornada()) {
                        // Notifico al usuario que la finalización de la jornada censal fue existosa
                        ErrorController::mostrarMensajeInformativo($smarty, "Jornada censal finalizada con éxito!!", 
                            "/plataforma/backoffice.php?comando=censos:default");
                    } else {
                        // De lo contario, lanzo una excepción para notificar al usuario que NO es 
                        // posible cancelar el censo de aves de la jornada deseada
                        throw new AppException(message: "No es posible cancelar el censo de aves en la jornada deseada!!!
                        Conctacte con los administradores para mayor información. ¡Gracias por participar!",
                        urlAceptar: "/plataforma/backoffice.php?comando=core:email:vista");  
                    }
                } else {
                    // De lo contario, establezco la accion de volver a la vista de censos de aves
                    // en la sesión dado que ña acción solicitada desde ahí no se puede ejecutar
                    $_SESSION['accion']="censo:sinasistencia";
                    // Emulo que el usuario logueado vuelve a hacer clic en el historico para abrir la vista
                    // de censos de aves en la jornada cuya finalización ha sido fallida
                    $_SESSION['listado']=$idJornada;
                    // lanzo una excepción para notificar al usuario que la
                    // jornada censal deseada no existe en la base de datos
                    throw new AppException(message: "Jornada censal no disponible o asistencia sin confirmar!!!",
                    urlAceptar: "/plataforma/backoffice.php?comando=censos:default");                      
                }
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                 
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para cancelar un censo de aves
            throw new AppException("Su rol en la plataforma no le permite cancelar el censo de aves");            
        }
    }

    /**
     * Método estático para validar el censo de aves en una jornada censal de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function validarCensosAvesPlatforma($smarty) {
        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo que el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos
        if ($permisosUsuario->hasPermisoGestorCensos() && isset($_SESSION['admincensos'])) {
            // El usuario logueado tiene permiso de acceso al modo restringido del gestor de censos. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado de la que desea validar el censo
            if (isset($_POST['idJornada'])) {
                // Recupero el identificador de la jornada elegida por el usuario desde su sesion
                $idJornada = $_SESSION['listado'];
                // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);
                // Recupero la jornada censal elegida por el usuario que desea validar el censo de aves
                $jornada = Jornada::consultarJornada($idJornada);
                // Compruebo si la jornada elegida existe en la base de datos
                if ($jornada instanceof Jornada) {
                    // Establezco el estado de la jornada a validar el censo de aves como: VALIDADA
                    $jornada->setEstadoJornada('VALIDADA');
                    // Añado marca de trazabilidad de la jornada censal
                    $observaciones=$jornada->getInformacionJornada();
                    $observaciones .= "<br><<--- El usuario administrador " . $usuario->getUsuario();
                    $observaciones .= " ha validado la jornada a las: " . date('d-m-Y H:i:s');
                    $jornada->setInformacionJornada($observaciones);                       
                    // Actualizo la jornada en la base de datos de la plataforma
                    if ($jornada->actualizarJornada()) {
                        // Notifico al usuario que la validación de la jornada censal fue existosa
                        ErrorController::mostrarMensajeInformativo($smarty, "Jornada censal validada con éxito!!", 
                            "/plataforma/backoffice.php?comando=censos:default");
                    } else {
                        // De lo contario, lanzo una excepción para notificar al usuario que NO es 
                        // posible validar el censo de aves de la jornada deseada
                        throw new AppException(message: "No es posible validar el censo de aves en la jornada deseada!!!
                        Conctacte con los administradores para mayor información. ¡Gracias por participar!",
                        urlAceptar: "/plataforma/backoffice.php?comando=core:email:vista");  
                    }
                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // jornada censal deseada no existe en la base de datos
                    throw new AppException(message: "La jornada censal elegida no existe en la base de datos!!!",
                    urlAceptar: "/plataforma/backoffice.php?comando=censos:default");                      
                }
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                 
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para validar un censo de aves
            throw new AppException("Su rol en la plataforma no le permite validar el censo de aves");            
        }
    }

    /**
     * Método estático para confirmar las asistencia a un censo de aves de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */    
    public static function confirmarAsistenciaParticipantes($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];        
        
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si existe una jornada censal previamente elegida por el usuario logueado
        if (isset($_SESSION['listado'])) {
            // Recupero el identificador de la jornada elegida por el usuario desde su sesion
            $idJornada = $_SESSION['listado'];
            // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
            // ya ha cumpplido su función aquí
            unset($_SESSION['listado']);
            // Recupero la jornada censal elegida por el usuario que desea consultar detalles del censo
            $jornada = Jornada::consultarJornada($idJornada);
            // Evaluo si la jornada censal deseada es editable por el usuario logueado
            $jornadaEditable=$jornada->esJornadaCensable($permisosUsuario) xor $jornada->esJornadaValidable($permisosUsuario);
            // Compruebo si la jornada elegida existe en la base de datos y el usuario loguerado tiene permisos de edición de censos
            if ($jornada instanceof Jornada && $jornadaEditable) {
                // Compruebo que se ha enviado el formulario de asistencia de participantes
                if (isset($_POST['asistencia']) && is_array($_POST['asistencia'])) {
                    // inicializo el contador de actualizaciones de asistencia fallidas
                    $fallidas=0;
                    // Recupero la asistencia de los participantes al censo desde el formulario
                    $asistenciaParticipantes=$_POST['asistencia'];
                    // Proceso la asistencia de los participantes para registrarla en la base de datos
                    foreach ($asistenciaParticipantes as $participante) {
                        // Genero el identificador de inscripción del participante al censo de aves
                        $idInscripcion=['idJornada' => $idJornada, 'usuario' => $participante];
                        // Recupero la inscripcion del participante desde la base de datos de la plataforma
                        $inscripcion=Participante::consultarInscripcion($idInscripcion);
                        // Marco en la inscripción de participante su asistencia a la jornada censal
                        $inscripcion->setAsiste(true);
                        // Actualizo la inscripción del participante a la jornada censal
                        if (!$inscripcion->actualizarInscripción()) {$fallidas += 1;}
                    }
                    // Notifico al usuario del resultado de la confirmación de asistencia a la jornada censal
                    // para ello compruebo si hay o no actualizaciones de asistencia fallidas.
                    if ($fallidas>0) {
                        // Lanzo una excepción para notificar que el usuario que hubo actualizaciones de asistencia fallidas
                        throw new AppException(message: "Hay actualizaciones de asistencia fallidas!!! Por favor, contacte con los administradores", 
                        urlAceptar: "/plataforma/backoffice.php?comando=core:email:vista");
                    } else {
                        // Emulo que el usuario logueazo solitico como acción mostrar la vista de censo de aves
                        $_SESSION['accion']="historicos:edicion";                        
                        // Emulo que el usuario logueado hizo clic en una jornada censal previamente
                        $_SESSION['listado']=$idJornada;
                        // Notifico al usuario que la actualización de la inscripción fue existosa
                        ErrorController::mostrarMensajeInformativo($smarty, "Confirmación asistencia actualizada con éxito!!", 
                            "/plataforma/backoffice.php?comando=censos:default");
                    }
                } else {
                    // Lanzo una excepción para notificar que el usuario que confirme la asistencia al censo de aves
                    throw new AppException("Por favor, confirme la asistencia de participantes. Gracias!");
                }
            } else {
                // lazo una excepción para notificar al usuario que no está autorizado a confirmar asistencia a jornadas censales
                throw new AppException("No está autorizado a confirma la asistencia a jornadas censales!!!");                
            }
        } else {
            // Lanzo una excepción para notificar que el usuario no eligió un censo del listado
            throw new AppException("No ha elegido una jornada censal del listado. Por favor, eliga una. Gracias!");
        }

    }
    
    // E) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados    

}

?>
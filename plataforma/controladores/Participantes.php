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
 use correplayas\modelo\Persona;
 use correplayas\modelo\Jornada;
 use correplayas\modelo\Observatorio;
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
                // Si desde un listado del gestor de participantes se envía el identificador de jornadas. Entonces:
                // Establezco la variable sesion con el identificador de la jornada seleccionado en el listado
                if (isset($_POST['idJornada'])) {$_SESSION['listado'] = $_POST['idJornada'];}
                // Proceso la acción solicitadas por usuarios no administradores desde el gestor
                switch ($accion) {
                    case "historico":
                        echo "Aquí debería mostrar el histórico de participación del usuario logueado...";
                        break;
                    case "inscribirse":
                        // Muestro la vista para inscribir a un usuario participante a una jornada
                        Participantes::mostrarInscripcionParticipanteJornadaPlataforma($smarty);
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

    /**
     * Método estático auxiliar para mostrar la vista de inscripción de un usuario participante a una jornada de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function mostrarInscripcionParticipanteJornadaPlataforma($smarty) {

        // Recupero al usuario logueado de la sesión
        $usuario = $_SESSION['usuario'];

        // Recupero el hash de usuario del usuario participante
        $hashParticipante=$usuario->getCodigo();

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];
        
        // Compruebo si el usuario logueado tiene permiso para inscribirse a jornadas de la plataforma
        if ($permisosUsuario->getPermisoInscribirseJornadas()) {
            // El usuario logueado tiene permisos para inscribirse a jornadas: Entonces:
            // Compruebo que el usuario loqueado eligió una jornada del listado
            if (isset($_SESSION['listado'])) {
                // Recupero el identificador de la jornada elegida por el usuario desde su sesion
                $idJornada = $_SESSION['listado'];
                // Desestablezco el identificador de jornada elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);
                // Recupero la jornada elegida por el usuario que desea eleiminar
                $jornada = Jornada::consultarJornada($idJornada);
                // Compruebo si la jornada elegida existe en la base de datos
                if ($jornada instanceof Jornada) {
                    // Se ha podido recuperar la jornada de la base de datos. Entonces:
                    // Recupero los datos del observatorio asociado a la jornada elegida
                    $observatorio=Observatorio::consultarObservatorio($jornada->getIdObservatorioJornada());
                    // Compruebo si el observatorio asociado a la jornada existe en la base de datos
                    if ($observatorio instanceof Observatorio) {
                        // Se ha posido recuperar al observatorio asociadp a la jornada. Entonces:
                        // Recupero los datos de la persona usuaria participante
                        $personaUsuariaParticipante = Persona::identificarPersona($hashParticipante);
                        // Compruebo si la persona usuario participante existe en la base de datos
                        if ($personaUsuariaParticipante instanceof Persona) {
                            // Se ha posido recuperar a la persona usuaria participante de la jornada. Entonces:
                            // Genero el nombre completo de la persona participante usuaria d ela plataforma
                            $participante = $personaUsuariaParticipante->getNombreCompletoPersona();
                            // Genero el lugar donde se desarrolla la jornada donde se inscribe
                            $lugar=$observatorio->getNombreObservatorio() . " - " . $observatorio->getDireccionObservatorio() . 
                                " - " . $observatorio->getLocalidadObservatorio();
                            // Genero el horario de la jornada a la que se inscribe
                            $horario=$jornada->getFechaJornada() . " (" . $jornada->getHoraInicioJornada() . " - " 
                                . $jornada->getHoraFinJornada() . ")";
                            // Recopilo la información de la plantilla para mostrar inscripción a una jornada
                            $perfil = ['idJornada' => $idJornada, 'usuario' => $hashParticipante, 'asiste' => 0,
                                'participante' => $participante, 'titulo' => $jornada->getTituloJornada(),
                                'lugar' => $lugar, 'horario' => $horario, 'inscripcion' => date('Y-m-d H:i:s')];
                            // Asigno las variables requeridas por la plantila de detalles de una jornada
                            $smarty->assign('usuario', $usuario->getUsuario());
                            $smarty->assign('permisos', $permisosUsuario);
                            $smarty->assign('perfil', $perfil);
                            $smarty->assign('anyo', date('Y'));
                            // Muestro la plantilla de detalles de una jornada con sus datos
                            $smarty->display('participantes/inscribirse.tpl');                            
                        } else {
                            // De lo contario, lanzo una excepción para notificar al usuario que el
                            // persona usuaria participante no existe en la base de datos
                            throw new AppException($message = "El participante a la jornada elegida no existe en la base de datos!!!",
                            $urlAceptar="/plataforma/backoffice.php?comando=participantes:default");
                        }
                    } else {
                        // De lo contario, lanzo una excepción para notificar al usuario que el
                        // observatorio asociado a la jornada deseada no existe en la base de datos
                        throw new AppException($message = "El observatorio de la jornada elegida no existe en la base de datos!!!",
                        $urlAceptar="/plataforma/backoffice.php?comando=participantes:default");
                    }
                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // jornada deseada no existe en la base de datos
                    throw new AppException($message = "La jornada elegida no existe en la base de datos!!!",
                    $urlAceptar="/plataforma/backoffice.php?comando=participantes:default");                    
                }
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");                
            }         
        } else {
            // lazo una excepción para notificar al usuario que no tiene permisos para incribirse a jornadas en la plataforma
            throw new AppException("Su usuario NO tiene permisos para inscribirse a jornadas en la plataforma!!!");
        }

    }

    // B) Métodos estáticos públicos para procesar los datos de las vistas específicas

    /**
     * Método estático general para procesar la inscripción de un usuario participante en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function inscribirParticipanteJornadaPlataforma($smarty) {

        // Recupero los datos de la nueva inscripcion desde el formulario para inscribirse a jornada
        $datosInscripción = [':idJornada' => intval(filter_input(INPUT_POST,'frm-idjornada', FILTER_SANITIZE_NUMBER_INT)),
            ':usuario' => filter_input(INPUT_POST,'frm-usuario'),
            ':inscripcion' => filter_input(INPUT_POST,'frm-inscripcion'),
            ':observacion' => filter_input(INPUT_POST,'frm-observacion'),
            ':asiste' => filter_input(INPUT_POST,'frm-asiste')];

        // Intento registrar una nueva inscripción de un usuario participante
        try { 
            // Registro a la nueva inscripción en la base de datos
            $ip = Participante::crearInscripcion($datosInscripción);            

            // Compruebo que la inscripción se creao correctamente
            if ($ip) {
                // Notifico al usuario el resultado de registrar una nueva inscripcion a jornada en la plataforma
                ErrorController::mostrarMensajeInformativo($smarty, "Nueva inscripción a jornadas registrada con éxito!!", "/plataforma/backoffice.php?comando=participantes:default");
            } else {
                // Lanzo excepción para notificar al usuario que hubo algún problema con su proceso de inscripción a jornadas
                throw new AppException("Uppps!! Hubo un problema con su registro. Por favor, contacte con los administradores","/plataforma/backoffice.php?comando=core:email:vista");
            } 

        // Manejo la excepción que se haya producido para notificarla al usuario
        } catch (AppException $ae) {
            // Si se produce una violación de restricción al registrarlos
            if ($ae->getCode() === AppException::DB_CONSTRAINT_VIOLATION_IN_QUERY)
            {                
                ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php?comando=participantes:default', "Esta inscripción ya esta registrada!!");
            }
            else
                ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php');
        }     
    }    
    
    // C) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados
    
    


}

 ?>
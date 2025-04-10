<?php

/**
 * Clase del controlador para gestionar todas las acciones con jornadas de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los jornadas de la plataforma correplayas.
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
use correplayas\excepciones\AppException;
use correplayas\modelo\Jornada;
use correplayas\modelo\Observatorio;
use Smarty\Smarty;

/**
 * Clase del controlador Jornadas para gestión de todas sus acciones disponibles en plataforma
 */
class Jornadas {

    /**
     * Método por defecto que muestra la vista del gestor de jornadas de la plataforma y además gestiona
     * las vistas auxiliares de acciones solicitadas por administradores desde el listado de jornadas.
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */    
    public static function default($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado es administrador
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Compruebo si está establecida la accion en el supergobal POST.
            if (isset($_POST['accion'])) {
                // Está establecida la acción en el superglobal POST. Entonces:                
                // Recupero la acción solicitada desde el listado de usaurios
                $accion = $_POST['accion'];
                // Establezco la variable sesion con el identificador de la jornada seleccionado en el listado
                $_SESSION['listado'] = $_POST['idJornada'];
                // Gestiono la vista que debo mostrarle al administrador según la acción solicitada
                switch($accion) {
                    case "actualizar":
                        Jornadas::mostrarEdicionJornadaPlataforma($smarty);
                        break;
                    case "eliminar":
                        Jornadas::mostrarConfirmaciónBajaJornadaPlataforma($smarty);
                        break;
                    default:
                        Jornadas::consultarDetallesJornadaPlataforma($smarty);
                        break;
                }
            } else {
                // De lo contario, muestro las vista por defecto del gestor de jornadas. Por tanto:
                Jornadas::listarJornadasPlataforma($smarty);
            }            
        } else {
            // De lo contario, el usuario logueado no tiene permisos para ejecutar este gestor
            // Por tanto, lanzo una excepción para notificar del error asl usuario
            throw new AppException("Su rol en la plataforma no le permite ejecutar el gestor de jornadas");
        }
    }

    // A) Método estáticos privados para gestioanr las vistas específicas solicitada desde el listado

    /**
     * Método estático auxiliar para mostrar la vista con el listado de jornadas disponibles en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function listarJornadasPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Si el usuario logueado es administrador entonces:
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {

            // Genero el listado de jornadas  disponibles en la plataforma
            $datos = Jornada::listarJornadas();

            // Asigno las variables requeridas por la plantila del listado de jornadas
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de jornadas
            $smarty->display('jornadas/listado.tpl');      

        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para listar y filtrar jornadas
            throw new AppException($message = "Tu rol en la plataforma no te permite listar ni filtrar jornadas", 
                $urlAceptar="/plataforma/backoffice.php");
        }        

    }

    /**
     * Método auxiliar para mostrar la vista de detalles de una jornada de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function consultarDetallesJornadaPlataforma($smarty) {

        // Recupero al usuario logueado en la plataforma
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado tiene el rol de administrador
        // que es el requerido para ejecutar la consulta de detalles de una jornada         
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {            
            // El usuario logueado es administrador. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado
            if (isset($_POST['idJornada'])) {
                // El usuario ha elegido una jornada del listado. Entonces:
                // Recupero el identificador de la jornada elegida por el usuario
                $idJornada = filter_input(INPUT_POST, 'idJornada');
                // Recupero los datos de la jornada elegida por el usuario
                $jornada = Jornada::consultarJornada($idJornada);
                // Compruebo si la jornada elegida existe en la base de datos
                if ($jornada instanceof Jornada) {
                    // Se ha podido recuperar la jornada de la base de datos. Entonces:
                    // Recupero los datos del observatorio asociado a la jornada elegida
                    $observatorio=Observatorio::consultarObservatorio($jornada->getIdObservatorioJornada());
                    // Compruebo si el observatorio asociado a la jornada existe en la base de datos
                    if ($observatorio instanceof Observatorio) {
                        // Se ha posido recuperar al observatorio asociadp a la jornada. Entonces:
                        // Recopilo la información de la plantilla para mostrar detalles de la jornada
                        $perfil = ['titulo' => $jornada->getTituloJornada(),
                            'fecha' => $jornada->getFechaJornada(),
                            'horaInicio' => $jornada->getHoraInicioJornada(),
                            'horaFin' => $jornada->getHoraFinJornada(),
                            'informacion' => $jornada->getInformacionJornada(),
                            'estado' => ucfirst(strtolower($jornada->getEstadoJornada())),
                            'asistencia' => $jornada->getControlAsistenciaJornada() === 1 ? 'Verificada' : 'Pendiente',
                            'observatorio' => $observatorio->getNombreObservatorio(),
                            'localidad' => $observatorio->getLocalidadObservatorio()];
                        // Asigno las variables requeridas por la plantila de detalles de una jornada
                        $smarty->assign('usuario', $usuario->getUsuario());
                        $smarty->assign('permisos', $permisosUsuario);
                        $smarty->assign('perfil', $perfil);
                        $smarty->assign('anyo', date('Y'));
                        // Muestro la plantilla de detalles de una jornada con sus datos
                        $smarty->display('jornadas/detalles.tpl');
                    } else {
                        // De lo contario, lanzo una excepción para notificar al usuario que el
                        // observatorio asociado a la jornada deseada no existe en la base de datos
                        throw new AppException($message = "El observatorio de la jornada elegida no existe en la base de datos!!!",
                        $urlAceptar="/plataforma/backoffice.php?comando=jornadas:default");
                    }
                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // jornada deseada no existe en la base de datos
                    throw new AppException($message = "La jornada elegida no existe en la base de datos!!!",
                    $urlAceptar="/plataforma/backoffice.php?comando=jornadas:default");
                }
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para mostrar detalles de una jornada
            throw new AppException("Su rol en la plataforma no le permite mostrar su detalles de una jornada");
        }

    }

    /**
     * Método auxiliar para mostrar la vista de edición de una jornada de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    private static function mostrarEdicionJornadaPlataforma($smarty) {
        // Recupero al usuario logueado en la plataforma
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado es administrador para
        // poder ejecutar la edición de una jornada de la plataforma
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Compruebo que el usuario haya elegido una jornada del listado
            if (isset($_POST['idJornada'])) {
                // El usuario ha elegido una jornada del listado. Entonces:
                // Recupero el identificador de la jornada elegida por el usuario
                $idJornada = filter_input(INPUT_POST, 'idJornada');
                // Recupero los datos de la jornada elegida por el usuario
                $jornada = Jornada::consultarJornada($idJornada);
                // Compruebo si la jornada elegida existe en la base de datos
                if ($jornada instanceof Jornada) {
                    // Se ha podido recuperar la jornada de la base de datos. Entonces:
                    // Recupero los datos del observatorio asociado a la jornada elegida
                    $observatorio=Observatorio::consultarObservatorio($jornada->getIdObservatorioJornada());
                    // Compruebo si el observatorio asociado a la jornada existe en la base de datos
                    if ($observatorio instanceof Observatorio) {
                        // Se ha posido recuperar al observatorio asociadp a la jornada. Entonces:
                        // Genero el nombre del observatorio asociado a la jornada
                        $nombreObservatorio = $observatorio->getNombreObservatorio() . " (" . $observatorio->getLocalidadObservatorio() . ")";
                        // Recopilo la información de la plantilla para mostrar detalles de la jornada
                        $perfil = ['titulo' => $jornada->getTituloJornada(),
                            'fecha' => $jornada->getFechaJornada(),
                            'horaInicio' => $jornada->getHoraInicioJornada(),
                            'horaFin' => $jornada->getHoraFinJornada(),
                            'informacion' => $jornada->getInformacionJornada(),
                            'estado' => $jornada->getEstadoJornada(),
                            'asistencia' => $jornada->getControlAsistenciaJornada() === 1 ? 'Verificada' : 'Pendiente',
                            'observatorio' => $jornada->getIdObservatorioJornada(),
                            'nombreObservatorio' => $nombreObservatorio];
                        // Establezco un array asociativo con los valores de estado del perfil posibles
                        $estadosJornada = ['Publicada' => 'PUBLICADA', 'Abierta' => 'ABIERTA', 
                            'Cerrada' => 'CERRADA', 'Cancelada' => 'CANCELADA'];                            
                        // Asigno las variables requeridas por la plantila de detalles de una jornada
                        $smarty->assign('usuario', $usuario->getUsuario());
                        $smarty->assign('permisos', $permisosUsuario);
                        $smarty->assign('estados', $estadosJornada);
                        $smarty->assign('perfil', $perfil);
                        $smarty->assign('anyo', date('Y'));
                        // Muestro la plantilla de detalles de una jornada con sus datos
                        $smarty->display('jornadas/edicion.tpl');
                    } else {
                        // De lo contario, lanzo una excepción para notificar al usuario que el
                        // observatorio asociado a la jornada deseada no existe en la base de datos
                        throw new AppException($message = "El observatorio de la jornada elegida no existe en la base de datos!!!",
                        $urlAceptar="/plataforma/backoffice.php?comando=jornadas:default");
                    }
                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // jornada deseada no existe en la base de datos
                    throw new AppException($message = "La jornada elegida no existe en la base de datos!!!",
                    $urlAceptar="/plataforma/backoffice.php?comando=jornadas:default");                    
                }         
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió una jornada del listado
                throw new AppException("No ha elegido una jornada del listado. Por favor, eliga una. Gracias!");
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para actualizar una jornada
            throw new AppException("Su rol en la plataforma no le permite actualizar una jornada");
        }
    }

    private static function mostrarConfirmaciónBajaJornadaPlataforma($smarty) {

    }

    // B) Métodos estáticos públicos para procesar los datos de las vistas específicas

    // NOTA: El filtrado o busqueda de jornadas lo dejo para el final para decidir campos y algoritmo

    // C) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados

    /**
     * Método estático general para mostrar la vista de registro de nuevas jornadas en la plataforma
     *
     * @param Smarty $smarty Obtejo que contiene al motor de plantilla Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarRegistroJornadaPlataforma($smarty) {
        // Recupero al usuario logueado de la sesión
        $usuario = $_SESSION['usuario'];
        // Asigno las variables de la plantilla de registro de jornada
        $smarty->assign('usuario', $usuario->getUsuario());
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('hoy', date('Y-m-d'));
        // Muestro la plantilla para el registro de un nuevo voluntario
        $smarty->display('jornadas/registro.tpl');    
    }

    public static function registrarJornadaPlataforma($smarty) {

        // Recupero los datos de la nueva jornada desde el formulario de registro
        $datosJornada = [':titulo' => filter_input(INPUT_POST,'frm-titulo'),
            ':fecha' => filter_input(INPUT_POST,'frm-fecha'),
            ':horaInicio' => filter_input(INPUT_POST,'frm-hora-inicio'),
            ':horaFin' => filter_input(INPUT_POST,'frm-hora-fin'),
            ':informacion' => filter_input(INPUT_POST,'frm-informacion'),
            ':estado' => 'PUBLICADA', ':asistencia' => 0, 
            ':observatorio' => intval(filter_input(INPUT_POST,'frm-observatorio', FILTER_SANITIZE_NUMBER_INT))];

        // Intento registrar a la nueva jornada
        try { 
            // Registro a la nueva jornada en la base de datos
            $j = Jornada::crearJornada($datosJornada);            

            // Compruebo que el usuario y su persona asociada se crearon correctamente
            if ($j) {
                // Notifico al usuario el resultado de registrar una nueva jornada en la plataforma
                ErrorController::mostrarMensajeInformativo($smarty, "Nueva jornada registrada con éxito!!", "/plataforma/backoffice.php?comando=jornadas:default");
            } else {
                // Lanzo excepción para notificar al usuario que hubo algún problema con su proceso de registro
                throw new AppException("Uppps!! Hubo un problema con su registro. Por favor, contacte con los administradores","/plataforma/backoffice.php?comando=core:email:vista");
            } 

        // Manejo la excepción que se haya producido para notificarla al usuario
        } catch (AppException $ae) {
            // Si se produce una violación de restricción al registrarlos
            if ($ae->getCode() === AppException::DB_CONSTRAINT_VIOLATION_IN_QUERY)
            {
                ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php?comando=jornadas:default', "Esta jornada ya esta registrada!!");
            }
            else
                ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php');
        }     
    }

}

?>
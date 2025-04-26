<?php

/**
 * Clase del controlador para gestionar todas las acciones con observatorios de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los observatorios de la plataforma correplayas.
 * 
  *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 * OBSERVACIONES: Desarrollo descartado por falta de tiempo para cumplir con plazos de entrega * 
 */

 // Defino el espacio de nombre para esta clase del controlador para observatorios
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\controladores\ErrorController;
use correplayas\excepciones\AppException;
use correplayas\modelo\Observatorio;
use Smarty\Smarty;

/**
 * Clase del controlador Observatorios para gestión de todas sus acciones disponibles en plataforma
 */
class Observatorios {

    /**
     * Método estático por defecto para mostrar vistas del gestor de observatorios de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción existe algún error con los permisos del usuario
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
                // Recupero la acción solicitada desde el listado de observatorios
                $accion = $_POST['accion'];
                // Establezco la variable sesion con el identificador del observatorio seleccionado en el listado
                $_SESSION['listado'] = $_POST['codigo'];                
                // Gestiono la vista que debo mostrarle al administrador según la acción solicitada
                switch($accion) {
                    default:
                        // Establezco la variable de sesión volver al gestor de observatorios tras consultar
                        // los detalles de un observatorio disponible en la plataforma
                        $_SESSION['volver'] = $_SERVER['REQUEST_URI'];
                        // Muestro la vista general con los detalles del observatorio de la plataforma deseado
                        Observatorios::consultarDetallesObservatorioPlataforma($smarty);
                        break;                    
                }                
            } else {
                // De lo contario, muestro las vista por defecto del gestor de observatorios. Por tanto:
                Observatorios::listarObservatoriosPlataforma($smarty);
            }            

        } else {
            // De lo contario, el usuario logueado no tiene permisos para ejecutar este gestor
            // Por tanto, lanzo una excepción para notificar del error asl usuario
            throw new AppException("Su rol en la plataforma no le permite ejecutar el gestor de observatorios");
        }

    }

    // A) Método estáticos privados para gestioanr las vistas específicas solicitada desde el listado

    /**
     * Método estático auxiliar para mostrar la vista con el listado de observatorios disponibles en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe problemas de pemrisos del usuario
     */
    private static function listarObservatoriosPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Si el usuario logueado es administrador entonces:
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {

            // Genero el listado de observatorios  disponibles en la plataforma
            $datos = Observatorio::listarObservatorios();

            // Asigno las variables requeridas por la plantila del listado de jornadas
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de jornadas
            $smarty->display('observatorios/listado.tpl');   
        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para listar y filtrar observatorios
            throw new AppException(message: "Tu rol en la plataforma no te permite listar ni filtrar observatorios", 
                urlAceptar: "/plataforma/backoffice.php");
        }
    }


    
    // B) Métodos estáticos públicos para procesar los datos de las vistas específicas

    /**
     * Método estático para filtrar listados de observatorios de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepcion cuando existe algún problema de permisos del usuario
     */
    public static function filtrarObservatoriosPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado tiene el rol de administrador  :
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Obtengo el campo de busqueda introducido por el usuario
            $busqueda = filter_input(INPUT_POST,'frm-busqueda', FILTER_SANITIZE_SPECIAL_CHARS);
            // Obtengo la columna por la que se desea ordenar los resultados
            $ordenarPor = filter_input(INPUT_POST, 'frm-ordenarpor', FILTER_SANITIZE_SPECIAL_CHARS);
            // Obtengo el modo de ordenarlos
            $orden = filter_input(INPUT_POST, 'frm-orden', FILTER_SANITIZE_SPECIAL_CHARS);
            // Obtengo los resultados del filtrado de observatorios en la plataforma            
            $resultados = Observatorio::buscarObservatorios($busqueda, $ordenarPor, $orden);
            // Asigno las variables requeridas por la plantila del listado de observatorios
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);            
            $smarty->assign('filas', $resultados);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de observatorios
            $smarty->display('observatorios/listado.tpl');               
        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para listar y filtrar observatorios
            throw new AppException(message: "Tu rol en la plataforma no te permite listar ni filtrar observatorios", 
                urlAceptar: "/plataforma/backoffice.php");
        }

    }    
    
    // C) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados    

    /**
     * Método estático general para mostrar la vista de detalles de un observatorio de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al mostrar detalles de un observatorio
     */
    public static function consultarDetallesObservatorioPlataforma($smarty) {

        // Recupero al usuario logueado en la plataforma
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado tiene permiso para ejecutar la consulta de detalles 
        // de un observatorio determinado de la plataforma
        if ($permisosUsuario->getPermisoConsultarJornada()) {
                // El usuario ha elegido un observatorio del listado. Entonces:
                // Recupero el identificador del observatorio elegido por el usuario
                $codigo = $_SESSION['listado'];
                // Desestablezco el identificador del observatorio elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);                
                // Recupero los datos del observatorio elegido por el usuario
                $observatorio = Observatorio::consultarObservatorio($codigo);
                // Compruebo si la jornada elegida existe en la base de datos
                if ($observatorio instanceof Observatorio) {
                    // Se ha posido recuperar al observatorio. Entonces:
                    // Recopilo la información de la plantilla para mostrar detalles del observatorio
                    $perfil = ['observatorio' => $observatorio->getNombreObservatorio(),
                        'direccion' => $observatorio->getDireccionObservatorio(),
                        'localidad' => $observatorio->getLocalidadObservatorio(),
                        'gps' => $observatorio->getGpsObservatorio(),
                        'historia' => $observatorio->getHistoriaObservatorio(),
                        'imagen' => $observatorio->getImagenObservatorio(),
                        'url' => $observatorio->getUrlObservatorio()];
                    // Asigno las variables requeridas por la plantila de detalles de un observatorio
                    $smarty->assign('usuario', $usuario->getUsuario());
                    $smarty->assign('permisos', $permisosUsuario);
                    $smarty->assign('perfil', $perfil);
                    $smarty->assign('volver', $_SESSION['volver']);
                    $smarty->assign('anyo', date('Y'));
                    // Desentablezco la variable de sesion volver porque aqui cumplió ya su función
                    unset($_SESSION['volver']);
                    // Muestro la plantilla de detalles de una jornada con sus datos
                    $smarty->display('observatorios/detalles.tpl');

                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // jornada deseada no existe en la base de datos
                    throw new AppException(message: "El observatorio elegido no existe en la base de datos!!!",
                    urlAceptar: "/plataforma/backoffice.php?comando=observatorios:default");
                }                
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para mostrar detalles de un observatorio
            throw new AppException("Su rol en la plataforma no le permite mostrar su detalles de un observatorio");
        }
    }        

    /**
     * Método estático general para mostrar la vista de registro de nuevos observatorios en la plataforma
     *
     * @param Smarty $smarty Obtejo que contiene al motor de plantilla Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarRegistroObservatorioPlataforma($smarty) {
        // Recupero al usuario logueado de la sesión
        $usuario = $_SESSION['usuario'];
        // Asigno las variables de la plantilla de registro de observatorio
        $smarty->assign('usuario', $usuario->getUsuario());
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('hoy', date('Y-m-d'));
        // Muestro la plantilla para el registro de un nuevo observatorio
        $smarty->display('observatorios/registro.tpl');    
    }

    /**
     * Método estático general para procesar el registro de un nuevo observatorio en la plataforma 
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al registrar un observatorio
     */
    public static function registrarObservatorioPlataforma($smarty) {

        // Recupero los datos del nuevo observatorio desde el formulario de registro
        $datosObservatorio = [':nombre' => filter_input(INPUT_POST,'frm-nombre'),
            ':direccion' => filter_input(INPUT_POST,'frm-direccion'),
            ':localidad' => filter_input(INPUT_POST,'frm-localidad'),
            ':gps' => filter_input(INPUT_POST,'frm-gps'),
            ':historia' => filter_input(INPUT_POST,'frm-historia'),
            ':imagen' => 'default.png', 
            ':url' => filter_input(INPUT_POST,'frm-url')];

        // Intento registrar al nuevo observatorio
        try { 
            // Registro al nuevo observatorio en la base de datos
            $ob = Observatorio::crearObservatorio($datosObservatorio);            

            // Compruebo que el nuevo observatorio se crearo correctamente
            if ($ob) {
                // Notifico al usuario el resultado de registrar un nuevo observatorio en la plataforma
                ErrorController::mostrarMensajeInformativo($smarty, "Nuevo observatorio registrado con éxito!!", "/plataforma/backoffice.php?comando=observatorios:default");
            } else {
                // Lanzo excepción para notificar al usuario que hubo algún problema durante el proceso de registro
                throw new AppException("Fallo al registrar el nuevo observatorio en la plataforma","/plataforma/backoffice.php?comando=observatorios:default");
            } 

        // Manejo la excepción que se haya producido para notificarla al usuario
        } catch (AppException $ae) {
            // Si se produce una violación de restricción al registrarlos
            if ($ae->getCode() === AppException::DB_CONSTRAINT_VIOLATION_IN_QUERY)
            {
                ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php?comando=observatorios:default', "Este observatorio ya esta registrado!!");
            }
            else
                ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php');
        }     
    }


}
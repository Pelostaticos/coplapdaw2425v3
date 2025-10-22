<?php

/**
 * Clase del controlador para gestionar todas las acciones con aves de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con las aves de la plataforma correplayas.
 * 
  *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 * OBSERVACIONES: Desarrollo descartado por falta de tiempo para cumplir con plazos de entrega * 
 */

 // Defino el espacio de nombre para esta clase del controlador para aves
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\controladores\ErrorController;
use correplayas\excepciones\AppException;
use correplayas\modelo\Ave;
use correplayas\modelo\Familia;
use correplayas\modelo\Orden;
use Smarty\Smarty;

/**
 * Clase del controlador Aves para gestión de todas sus acciones disponibles en plataforma
 */
class Aves {

    /**
     * Método estático por defecto para mostrar vistas del gestor de aves de la plataforma
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
                // Recupero la acción solicitada desde el listado de aves
                $accion = $_POST['accion'];
                // Establezco la variable sesion con el identificador del aves seleccionado en el listado
                $_SESSION['listado'] = $_POST['especie'];                
                // Gestiono la vista que debo mostrarle al administrador según la acción solicitada
                switch($accion) {
                    case "actualizar":
                        // Muestro la vista específica de edición de un ave de la plataforma
                        Aves::mostrarEdicionAvePlataforma($smarty);
                        break;
                    case "eliminar":
                        // Muestro la vista específica con el mensaje de confirmación de baja de un ave de la plataforma
                        Aves::mostrarConfirmaciónBajaAvePlataforma($smarty);
                        break;
                    default:
                        // Establezco la variable de sesión volver al gestor de aves tras consultar
                        // los detalles de un ave disponible en la plataforma
                        $_SESSION['volver'] = $_SERVER['REQUEST_URI'];
                        // Muestro la vista general con los detalles del ave de la plataforma deseado
                        Aves::consultarDetallesAvePlataforma($smarty);
                        break;                    
                }                
            } else {
                // De lo contario, muestro las vista por defecto del gestor de aves. Por tanto:
                Aves::listarAvesPlataforma($smarty);
            }  
        } else {
            // De lo contario, el usuario logueado no tiene permisos para ejecutar este gestor
            // Por tanto, lanzo una excepción para notificar del error asl usuario
            throw new AppException("Su rol en la plataforma no le permite ejecutar el gestor de aves");
        }

    }

    // A) Método estáticos privados para gestioanr las vistas específicas solicitada desde el listado
   
    /**
     * Método estático auxiliar para mostrar la vista con el listado de aves disponibles en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe problemas de pemrisos del usuario
     */
    private static function listarAvesPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Si el usuario logueado es administrador entonces:
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {

            // Genero el listado de aves  disponibles en la plataforma
            $datos = Ave::listarAves();

            // Asigno las variables requeridas por la plantila del listado de aves
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de aves
            $smarty->display('aves/listado.tpl');   
        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para listar y filtrar observatorios
            throw new AppException(message: "Tu rol en la plataforma no te permite listar ni filtrar aves", 
                urlAceptar: "/plataforma/backoffice.php");
        }
    }

    /**
     * Método auxiliar para mostrar la vista de edición de un ave de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe problemas para mostrar la vista de edición de aves
     */
    private static function mostrarEdicionAvePlataforma($smarty) {
        // Recupero al usuario logueado en la plataforma
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado es administrador para
        // poder ejecutar la edición de un ave de la plataforma
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Compruebo que el usuario haya elegido un ave del listado
            if (isset($_SESSION['listado'])) {
                // El usuario ha elegido un ave del listado. Entonces:
                // Recupero el identificador del ave elegido por el usuario
                $especie = $_SESSION['listado'];
                // Desestablezco el identificador del ave elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);                
                // Recupero los datos del ave elegido por el usuario
                $ave = Ave::consultarAve($especie);
                // Compruebo si el ave elegida existe en la base de datos
                if ($ave instanceof Ave) {
                    // Recupero la información acerca de la familia y orden del ave
                    $familia=$ave->getFamiliaAve();
                    $nombreFamilia=$familia->getFamilia();
                    $orden=$familia->getOrden();
                    $nombreOrden=$orden->getOrden();                    
                    // Recopilo la información de la plantilla para mostrar edición del ave
                    $perfil = ['especie' => $especie,
                    'familia' => $nombreFamilia,
                    'orden' => $nombreOrden,
                    'abreviatura' => $ave->getAbreviaturaAve(),
                    'comun' => $ave->getNombreComunAve(),
                    'ingles' => $ave->getNombreInglesAve(),
                    'imagen' => 'default.png',
                    'url' => $ave->getUrlAve()];
                    // Asigno las variables requeridas por la plantila de edición de un ave
                    $smarty->assign('usuario', $usuario->getUsuario());
                    $smarty->assign('permisos', $permisosUsuario);
                    $smarty->assign('perfil', $perfil);
                    $smarty->assign('anyo', date('Y'));
                    // Muestro la plantilla de edición de un ave con sus datos
                    $smarty->display('aves/edicion.tpl');
                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que el
                    // ave deseada no existe en la base de datos
                    throw new AppException(message: "El ave elegida no existe en la base de datos!!!",
                    urlAceptar: "/plataforma/backoffice.php?comando=aves:default");                    
                }         
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió un ave del listado
                throw new AppException("No ha elegido un ave del listado. Por favor, eliga una. Gracias!");
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para actualizar un ave
            throw new AppException("Su rol en la plataforma no le permite actualizar un ave");
        }
    }

    /**
     * Método auxiliar para mostrar la confirmación de baja de un ave de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema para mostrar confirmación de baja ave
     */
    private static function mostrarConfirmaciónBajaAvePlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo que el usuario logueado es un administrador
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Compruebo que el usuario haya elegido un ave del listado
            if (isset($_POST['especie'])) {
                // Establezco la configuración del mensaje de confirmación para el usuario autorizado
                $mensaje = "Has solicitado eliminar un ave de la plataforma";
                $pregunta = "¿Estás seguro que quieres eliminar a dicha ave?";
                $urlCancelar = "/plataforma/backoffice.php?comando=aves:default";
                $urlAceptar = "/plataforma/backoffice.php?comando=aves:eliminar:procesa";
                // Muestro el mensaje de confirmación de baja al usuario
                ErrorController::mostarMensajeAdvertencia($smarty,$mensaje,$pregunta,$urlCancelar,$urlAceptar);
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió un observatorio del listado
                throw new AppException("No ha elegido un ave del listado. Por favor, eliga una. Gracias!");                
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para eliminar un observatorio
            throw new AppException("Su rol en la plataforma no le permite eliminar un ave");            
        }
    }    

    // B) Métodos estáticos públicos para procesar los datos de las vistas específicas    

    /**
     * Método estático para actualizar un ave de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún probelma para actualizar el ave
     */
    public static function actualizarAvePlataforma($smarty) {

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos']; 

        // Compruebo si el usuario tiene rol de administrador
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Recupero el identificador del ave elegido por el usuario
            $especie = filter_input(INPUT_POST, 'frm-especie');
            // Recupero los datos del ave elegida por el usuario
            $ave = Ave::consultarAve($especie);
            // Compruebo si el ave elegida existe en la base de datos
            if ($ave instanceof Ave) {
                // Recupero del formulario de edición de ave los datos y actualizo el objeto
                $ave->setNombreComunAve(filter_input(INPUT_POST,'frm-comun'));
                $ave->setNombreInglesAve(filter_input(INPUT_POST,'frm-ingles'));
                $ave->setImagenAve(filter_input(INPUT_POST,'frm-imagen'));
                $ave->setUrlAve(filter_input(INPUT_POST,'frm-url'));
                // Actulizo los datos del ave y muestro la notificación del resultado
                if ($ave->actualizarAve()) {
                    // Notifico al usuario que la actualización del ave fue existosa
                    ErrorController::mostrarMensajeInformativo($smarty, "Ave actualizada con éxito!!", 
                        "/plataforma/backoffice.php?comando=aves:default");
                } else {
                    // Lanzo una excepción para indicar que no es posible obtener valores por defecto del ave
                    throw new AppException(message: "No es posible actualizar el ave", 
                        urlAceptar: "/plataforma/backoffice.php?comando=aves:default");
                }                    
            } else {
                // De lo contario, lanzo una excepción para notificar al usuario que el
                // ave deseada no existe en la base de datos
                throw new AppException(message: "El ave elegida no existe en la base de datos!!!",
                urlAceptar: "/plataforma/backoffice.php?comando=aves:default");                    
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para actualizar un ave
            throw new AppException("Su rol en la plataforma no le permite actualizar un ave");
        }

    }

    /**
     * Método estático para eliminar a un ave de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al eliminar un ave
     */
    public static function eliminarAvePlataforma($smarty) {

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo que el usuario tiene rol de administrador
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Compruebo que el usuario loqueado eligió un ave del listado
            if (isset($_SESSION['listado'])) {
                // Recupero el identificador del ave elegida por el usuario desde su sesion
                $especie = $_SESSION['listado'];
                // Desestablezco el identificador del ave elegida por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);
                // Recupero el ave elegida por el usuario que desea eleiminar
                $ave = Ave::consultarAve($especie);
                // Intento eliminar al ave deseada de la plataforma
                try {
                    // Procedo a eliminar el ave y compruebo su resultado
                    if ($ave->eliminarAve()) {
                        // Notifico al usuario que el ave se ha eliminado correctamente y lo devuelvo a su vista por defecto
                        ErrorController::mostrarMensajeInformativo($smarty, "El ave indicada se ha elminado correctamente!",
                            "/plataforma/backoffice.php?comando=aves:default");
                    } else {
                        // Lanzo una excepción para indicar que existe algún problema para dar de baja a un ave
                        throw new AppException("No es posible dar de baja al ave indicada!");
                    }
                // Manejo la excepción que se haya producido para notificarla al usuario
                } catch (AppException $ae) {
                    ErrorController::handleException($ae, $smarty, '/plataforma/backoffice.php?comando=aves:default', "No puedes elminiar este ave porque está en uso en la plataforma!!");
                }
            } else {
                // Lanzo una excepción para notificar que el usuario no eligió un ave del listado
                throw new AppException("No ha elegido un ave del listado. Por favor, eliga una. Gracias!");
            }         
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para eliminar un ave
            throw new AppException("Su rol en la plataforma no le permite eliminar un ave");
        }

    }

    /**
     * Método estático para filtrar listados de aves de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepcion cuando existe algún problema de permisos del usuario
     */
    public static function filtrarAvesPlataforma($smarty) {

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
            // Obtengo los resultados del filtrado de aves en la plataforma            
            $resultados = Ave::buscarAves($busqueda, $ordenarPor, $orden);
            // Asigno las variables requeridas por la plantila del listado de aves
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);            
            $smarty->assign('filas', $resultados);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de aves
            $smarty->display('aves/listado.tpl');               
        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para listar y filtrar aves
            throw new AppException(message: "Tu rol en la plataforma no te permite listar ni filtrar aves", 
                urlAceptar: "/plataforma/backoffice.php");
        }

    } 
    
    // C) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados    

    /**
     * Método estático general para mostrar la vista de detalles de un ave de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al mostrar detalles de un ave
     */
    public static function consultarDetallesAvePlataforma($smarty) {

        // Recupero al usuario logueado en la plataforma
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado tiene permiso para ejecutar la consulta de detalles 
        // de un ave determinada de la plataforma
        if ($permisosUsuario->getPermisoConsultarJornada()) {
                // El usuario ha elegido un observatorio del listado. Entonces:
                // Recupero el identificador del ave elegido por el usuario
                $especie = $_SESSION['listado'];
                // Desestablezco el identificador del ave elegido por el usuario desde la sesion porque
                // ya ha cumpplido su función aquí
                unset($_SESSION['listado']);                
                // Recupero los datos del ave elegido por el usuario
                $ave = Ave::consultarAve($especie);
                // Compruebo si el ave elegida existe en la base de datos
                if ($ave instanceof Ave) {
                    // Se ha posido recuperar al ave. Entonces:
                    // Recupero la información acerca de la familia y orden del ave
                    $familia=$ave->getFamiliaAve();
                    $nombreFamilia=$familia->getFamilia();
                    $descripcionFamilia=$familia->getDescripcion();
                    $orden=$familia->getOrden();
                    $nombreOrden=$orden->getOrden();
                    // Recopilo la información de la plantilla para mostrar detalles del ave
                    $perfil = ['especie' => $ave->getEspecieAve(),
                        'familia' => $nombreFamilia,
                        'descripcion' => $descripcionFamilia,
                        'orden' => $nombreOrden,
                        'abreviatura' => $ave->getAbreviaturaAve(),
                        'comun' => $ave->getNombreComunAve(),
                        'ingles' => $ave->getNombreInglesAve(),
                        'imagen' => $ave->getImagenAve(),
                        'url' => $ave->getUrlAve()];
                    // Asigno las variables requeridas por la plantila de detalles de un ave
                    $smarty->assign('usuario', $usuario->getUsuario());
                    $smarty->assign('permisos', $permisosUsuario);
                    $smarty->assign('perfil', $perfil);
                    $smarty->assign('volver', $_SESSION['volver']);
                    $smarty->assign('anyo', date('Y'));
                    // Desentablezco la variable de sesion volver porque aqui cumplió ya su función
                    unset($_SESSION['volver']);
                    // Muestro la plantilla de detalles de un ave con sus datos
                    $smarty->display('aves/detalles.tpl');

                } else {
                    // De lo contario, lanzo una excepción para notificar al usuario que la
                    // ave deseada no existe en la base de datos
                    throw new AppException(message: "El ave elegido no existe en la base de datos!!!",
                    urlAceptar: "/plataforma/backoffice.php?comando=aves:default");
                }                
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para mostrar detalles de un ave
            throw new AppException("Su rol en la plataforma no le permite mostrar su detalles de un ave");
        }
    }        

    /**
     * Método estático general para mostrar la vista de registro de nuevas aves en la plataforma
     *
     * @param Smarty $smarty Obtejo que contiene al motor de plantilla Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarRegistroAvePlataforma($smarty) {
        // Recupero al usuario logueado de la sesión
        $usuario = $_SESSION['usuario'];
        // Asigno las variables de la plantilla de registro de ave
        $smarty->assign('usuario', $usuario->getUsuario());
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('hoy', date('Y-m-d'));
        // Muestro la plantilla para el registro de una nueva ave
        $smarty->display('aves/registro.tpl');    
    }    

    /**
     * Método estático general para procesar el registro de una nueva ave en la plataforma 
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al registrar un ave
     */
    public static function registrarAvePlataforma($smarty) {

        // Recupero los datos de la nueva ave desde el formulario de registro
        $datosAve = [':especie' => filter_input(INPUT_POST,'frm-especie'),
            ':familia' => filter_input(INPUT_POST,'frm-familia'),
            ':abreviatura' => filter_input(INPUT_POST,'frm-codigo'),
            ':comun' => filter_input(INPUT_POST,'frm-comun'),
            ':ingles' => filter_input(INPUT_POST,'frm-ingles'),
            ':imagen' => 'default.png', 
            ':url' => filter_input(INPUT_POST,'frm-url')];

        // Intento registrar a la nueva ave
        try { 
            // Registro a la nueva ave en la base de datos
            $av = Ave::crearAve($datosAve);            

            // Compruebo que la nueva ave se creó correctamente
            if ($av) {
                // Notifico al usuario el resultado de registrar una nueva ave en la plataforma
                ErrorController::mostrarMensajeInformativo($smarty, "Nueva ave registrada con éxito!!", "/plataforma/backoffice.php?comando=aves:default");
            } else {
                // Lanzo excepción para notificar al usuario que hubo algún problema durante el proceso de registro
                throw new AppException("Fallo al registrar la nueva ave en la plataforma","/plataforma/backoffice.php?comando=aves:default");
            } 
        // Manejo la excepción que se haya producido para notificarla al usuario
        } catch (AppException $ae) {
            switch ($ae->getCode()) {
                // Si se produce una violación de restricción al registrarlos
                case AppException::DB_CONSTRAINT_VIOLATION_IN_QUERY:
                    ErrorController::handleException($ae, $smarty,
                        '/plataforma/backoffice.php?comando=aves:default',
                        "Este ave ya esta registrada!!");
                    break;
                // Si la demostración está habilitada por el modo sólo lectura
                case AppException::DB_READ_ONLY_MODE:
                    ErrorController::handleException($ae, $smarty,
                        '/plataforma/backoffice.php?comando=aves:default',
                        "Esta acción esta bloqueada en el modo demostración!!");
                    break;
                // Por defecto, para cualquier otra excepción capturada
                default:
                    ErrorController::handleException($ae, $smarty,
                        '/plataforma/backoffice.php');
                    break;
            }                
        }     
    }

}
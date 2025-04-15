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
     * Método por defecto que muestra la vista del gestor de usuarios de la plataforma y además gestiona
     * las acciones solicitadas por los usuarios administradores desde el listado de usuarios.
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function default($smarty) {
        // Recupero el rol del usuario logueado
        // $usuarioLogueado = $_SESSION['usuario'];

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
                case "activar":
                    // Elimino la variable de sesion listado por aquí ya cumplio su funcion
                    if (isset($_SESSION['listado'])) {unset($_SESSION['listado']);}
                    // Muestro el mensaje informativo indicandole al usuario que la funcionalidad no está disponible.
                    ErrorController::mostrarMensajeInformativo($smarty, "Esta autorizado para ejecutar esta funcionalidad. No obstante, por cuestones técnicas
                     el activar a un usuario desactivo no se encuentra disponible en la plataforma. Gracias!", $volver);
                    break;
                case "desactivar":
                    // Elimino la variable de sesion listado por aquí ya cumplio su funcion
                    if (isset($_SESSION['listado'])) {unset($_SESSION['listado']);}
                    // Muestro el mensaje informativo indicandole al usuario que la funcionalidad no está disponible.
                    ErrorController::mostrarMensajeInformativo($smarty, "Esta autorizado para ejecutar esta funcionalidad. No obstante, por cuestones técnicas
                     el desactivar a un usuario activo no se encuentra disponible en la plataforma. Gracias!", $volver);
                    break;
                case "actualizar":                   
                    // Ejecuto la acción mostrar vista de edición del perfil de usuario desde el listado
                    Usuarios::mostrarVistaEdicionUsuarioPlataforma($smarty);
                    break;
                case "eliminar":
                    // Ejecuto la acción mostrar confirmación para elminiar perfil de usuario desde el listado
                    Usuarios::mostrarConfirmacionBajaUsuarioPlataforma($smarty);
                    break;
                case "password":
                    // Ejecuto la acción de mostrar vista para cambio de contraseña del perfil de usuario desde el listado
                    Usuarios::mostrarVistaCambioContraseñaUsuarioPlataforma($smarty);
                    break;                    
                default:
                    // Ejecuto la acción de consultar perfil de usuario desde el lisstado
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
     * @throws AppException Excepción cuando existe algún problema al mostrar el perfil de usuario
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
            // Establezco a falso esta variable para no mostrar las acciones de perfil para usuario logueado
            $mostrarAccionesPerfil = false;
            // Elimino la variable de sesión listado porque ya ha cumplido su función en esta acción
            unset($_SESSION['listado']);
        } else {
            // De lo contrario, el usuario está pidiendo consultar su propio perfil de usuario
            // Obtengo al usuario de la sesión del navegacion
            $usuario = $_SESSION['usuario'];
            // Obtengo el hash identificador de usuario
            $hashUsuario = $usuario->getCodigo();
            // Establezco a falso esta variable para no mostrar las acciones de perfil para usuario logueado
            $mostrarAccionesPerfil = true;                      
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
                $smarty->assign('mostrarAccionesPerfil', $mostrarAccionesPerfil);
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

    /**
     * Método estático para listar los usuarios disponibles en la plataforma
     *
     * @param Smarty $smarty Obtejp que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al listar usuarios
     */
    public static function listarUsuariosPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];
        
        // Si el usuario logueado tiene permiso para filtrar usuarios entonces:
        if ($permisosUsuario->getPermisoFiltrarUsuarios()) {

            // Genero el listado de usuarios  disponibles en la plataforma
            $datos = Usuario::listarUsuarios();

            // Asigno las variables requeridas por la plantila del listado de usuarios
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de usuarios
            $smarty->display('usuarios/listado.tpl');      

        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para filtrar usuarios
            throw new AppException(message: "Disculpa! Tu rol no te permite listar usuarios en la plataforma", 
                urlAceptar: "/plataforma/backoffice.php?comando=usuarios:default");
        }


    }

    /**
     * Método estático para filtrar listados de usuarios de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al filtrar listados de usuarios
     */
    public static function filtrarUsuariosPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Si el usuario logueado tiene permiso para filtrar usuarios entonces:
        if ($permisosUsuario->getPermisoFiltrarUsuarios()) {
            // Obtengo el campo de busqueda introducido por el usuario
            $busqueda = filter_input(INPUT_POST,'frm-busqueda', FILTER_SANITIZE_SPECIAL_CHARS);
            // Obtengo la columna por la que se desea ordenar los resultados
            $ordenarPor = filter_input(INPUT_POST, 'frm-ordenarpor', FILTER_SANITIZE_SPECIAL_CHARS);
            // Obtengo el modo de ordenarlos
            $orden = filter_input(INPUT_POST, 'frm-orden', FILTER_SANITIZE_SPECIAL_CHARS);
            // Obtengo los resultados del filtrado de usuarios en la plataforma            
            $resultados = Usuario::buscarUsuarios($busqueda, $ordenarPor, $orden);
            // Asigno las variables requeridas por la plantila del listado de usuarios
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);            
            $smarty->assign('filas', $resultados);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de usuarios
            $smarty->display('usuarios/listado.tpl');               
        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para filtrar usuarios
            throw new AppException(message: "Disculpa! Tu rol no te permite filtrar usuarios en la plataforma", 
                urlAceptar: "/plataforma/backoffice.php?comando=usuarios:default");
        }

    }

    /**
     * Método estático para mostrar la vista de edición de usuarios
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No evuelve valor alguno
     * @throws AppException Excepción cuandi existe algún problema al mostrar la vista de edición
     */
    public static function mostrarVistaEdicionUsuarioPlataforma ($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo la procedencía de la ejecución de la presente acción
        // Si la variable de sesion listado está establecida junto 
        // El usuario logueado tiene permiso para listar usuarios. Entonces:
        if (isset($_SESSION['listado']) && $permisosUsuario->getPermisoListarUsuarios()) {
            // El usuario autorizado está solicitando actualizar datos de un usuario no logueado
            // Recupero el hash identificador de usuario desde la variable de sesion
            $hashUsuario = $_SESSION['listado'];
            // Consulto a la base de datos por el usuario contenido en la variable de sessión listado
            $usuario = Usuario::consultarUsuario($hashUsuario);
            // Elimino la variable de sesión listado porque ya ha cumplido su función en esta acción
            unset($_SESSION['listado']);
        } else {
            // De lo contrario, el usuario está pidiendo actualizar su propio perfil de usuario
            // Obtengo al usuario de la sesión del navegacion
            $usuario = $_SESSION['usuario'];
            // Obtengo el hash identificador de usuario
            $hashUsuario = $usuario->getCodigo();
        }

        // Compruebo si el usuario tiene permisos para consultar el perfil de usuario y actualizarlo
        if ($permisosUsuario->getPermisoConsultarUsuario() && $permisosUsuario->getPermisoActualizacionUsuario()) {

            // Identifico a la persona usuaria
            $personaUsuaria = Persona::identificarPersona($hashUsuario);

            // Proceso la informacion del perfil si este existe
            if ($usuario instanceof Usuario && $personaUsuaria instanceof Persona) {
                // Genero el nombre completo de la persona usuaria
                $nombrePersonaUsuaria = $personaUsuaria->getNombrePersona() . " " . $personaUsuaria->getPrimerApellido() . " " . $personaUsuaria->getSegundoApellido();
                // Recopilo información del perfil de usuario para la plantilla
                $perfil = ['codigo' => $hashUsuario,
                'usuario' => $usuario->getUsuario(),
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
                // Establezco un array asociativo con los valores de estado del perfil posibles
                $estadosPerfil = ['Activo' => 'ACTIVO', 'Desactivo' => 'DESACTIVO', 'Baja' => 'BAJA', 'Reactivar' => 'REACTIVAR'];
                // Asigno las variables requeridas por la plantila del perfil de usuario
                $smarty->assign('usuario', $usuario->getUsuario());
                $smarty->assign('permisos', $permisosUsuario);
                $smarty->assign('estados', $estadosPerfil);
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
                // Muestro la plantilla de edición del perfil de usaurio con sus datos
                $smarty->display('usuarios/edicion.tpl');                   
            } else {
                // Lanzo una excepción para indicar que no existe perfil de usuario
                throw new AppException("No existe el perfil de usuario");
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para actualizar su perfil
            throw new AppException("Su rol en la plataforma no le permite actualizar el perfil de usuario");
        }

    }

    /**
     * Método estático para actualizar el perfil de un usuario de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al actualizar el perfil de usuario
     */
    public static function actualizarUsuarioPlataforma($smarty) {

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo si el usuario tiene permisos para actualizar el perfil de usuario
        if ($permisosUsuario->getPermisoConsultarUsuario() && $permisosUsuario->getPermisoActualizacionUsuario()) {
        
            // Compruebo si el formualrio de actualización del perfil de usaurio está establecido            
            if (isset($_POST['frm-hashusuario'])) {
                // Recupero del formulario la URL a la que se redigirá al usuario tras aceptar notificación.
                $urlAceptarNotificacion = filter_input(INPUT_POST, 'frm-urlaceptar');
                // Recupero del formulario de actualizacion del perfil de usuario los datos
                $hashUsuario = filter_input(INPUT_POST, 'frm-hashusuario');
                $direccion = filter_input(INPUT_POST, 'frm-direccion');
                $localidad = filter_input(INPUT_POST, 'frm-localidad');
                $codPostal = filter_input(INPUT_POST, 'frm-codpostal');
                $email = filter_input(INPUT_POST, 'frm-email');
                $telefono = filter_input(INPUT_POST, 'frm-telefono');
                // Recupero al usuario actualizado desde su hash de usuario
                $usuario = Usuario::consultarUsuario($hashUsuario);
                // Recupero a la persona usuaria actualizada del anterior usuario
                $personaUsuaria = Persona::identificarPersona($hashUsuario);
                // Si ha sido posible recuparar al usuario para obtener los datos por defecto
                if ($usuario instanceof Usuario && $personaUsuaria instanceof Persona) {                
                    // Compruebo si hubo posibilidad de actualizar el estado y rol del perfil de usuario
                    if (isset($_POST['frm-estado'])) {
                        // Recupero los datos de estado y rol del perfil de usuario actualizados
                        $estado = filter_input(INPUT_POST, 'frm-estado');
                        $rol = filter_input(INPUT_POST, 'frm-rol');
                    } else {
                            // Recupero los valores de estado y rol del usuario por defecto
                            $estado = $usuario->getEstado();
                            $rol = $usuario->getRol();
                    }
                    // Preparo los datos para la actualización del perfil de usuario
                    $datosUsuario = [':codigo' => $hashUsuario, ':estado' => $estado, ':rol' => $rol];
                    $datosPersonaUsuaria = [':usuario' => $hashUsuario, ':email' => $email,
                        ':direccion' => $direccion, ':localidad' => $localidad, ':telefono' => $telefono, ':codigoPostal'  => $codPostal];
                    // Actulizo los datos del perfil de usuario y muestro la notificación del resultado
                    if ($usuario->actualizarUsuario($datosUsuario) || $personaUsuaria->actualizarPersona($datosPersonaUsuaria)) {
                        // Notifico al usuario que la actualización del perfil fue existosa
                        ErrorController::mostrarMensajeInformativo($smarty, "Perfil de usuario actualizado con éxito!!", $urlAceptarNotificacion);
                    } else {
                        // Lanzo una excepción para indicar que no es posible obtener valores por defecto del perfil de usuario
                        throw new AppException(message: "No es posible actualizar el perfil de usuario", 
                            urlAceptar: $urlAceptarNotificacion);
                    }
                } else {
                    // Lanzo una excepción para indicar que no es posible obtener valores por defecto del perfil de usuario
                    throw new AppException(message: "No es posible recuperar el perfil de usuario", 
                        urlAceptar: $urlAceptarNotificacion);                
                    }                    

            } else {
                // Lanzo una excepción para indicar que no existen datos para acutalizar el perfil de usuario
                throw new AppException("No existen datos para actualizar el perfil de usuario");                
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para actualizar su perfil
            throw new AppException("Su rol en la plataforma no le permite actualizar el perfil de usuario");
        }
    }


    /**
     * Método estático para mostrar la vista del cambio de contraseña del perfil de usuario
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al cambiar contraseña del usuario
     */
    public static function mostrarVistaCambioContraseñaUsuarioPlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo la procedencía de la ejecución de la presente acción
        // Si la variable de sesion listado está establecida junto 
        // El usuario logueado tiene permiso para listar usuarios. Entonces:
        if (isset($_SESSION['listado']) && $permisosUsuario->getPermisoListarUsuarios()) {
            // El usuario autorizado está solicitando cambiar el password de un usuario no logueado
            // Recupero el hash identificador de usuario desde la variable de sesion
            $hashUsuario = $_SESSION['listado'];
            // Consulto a la base de datos por el usuario contenido en la variable de sessión listado
            $usuario = Usuario::consultarUsuario($hashUsuario);
            // Elimino la variable de sesión listado porque ya ha cumplido su función en esta acción
            unset($_SESSION['listado']);
        } else {
            // De lo contrario, el usuario está pidiendo cambiar el password de su propio perfil de usuario
            // Obtengo al usuario de la sesión del navegacion
            $usuario = $_SESSION['usuario'];
            // Obtengo el hash identificador de usuario
            $hashUsuario = $usuario->getCodigo();
        }

        // Compruebo si el usuario tiene permisos para consultar el perfil de usuario y cambiar el password
        if ($permisosUsuario->getPermisoConsultarUsuario() && $permisosUsuario->getPermisoCambioPasswordUsuario()) {
            // Proceso la informacion del perfil si este existe
            if ($usuario instanceof Usuario) { 
                // Recopilo información del perfil de usuario para la plantilla
                $perfil = ['codigo' => $hashUsuario,
                'usuario' => $usuario->getUsuario(),
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
                    // De lo contario se bliga al usuario que inicie sesión con las nuevas credenciales
                    $smarty->assign('volver', '/plataforma/backoffice.php');
                }
                $smarty->assign('anyo', date('Y'));
                // Muestro la plantilla del cambio del password para el perfil de usaurio con sus datos
                $smarty->display('usuarios/password.tpl');                  
            } else {
                // Lanzo una excepción para indicar que no existe perfil de usuario
                throw new AppException("No existe el perfil de usuario");
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para modificar el password de su perfil
            throw new AppException("Su rol en la plataforma no le permite cambiar el password de su perfil de usuario");

        }

    }

    /**
     * Método estático para cambiar el password del perfil de usuario
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al procesar el cambio de contraseña del usuario
     */
    public static function modificarPasswordUsuarioPlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];        

        // Compruebo si el usuario tiene permisos para cambiar el password del perfil de usuario
        if ($permisosUsuario->getPermisoConsultarUsuario() && $permisosUsuario->getPermisoCambioPasswordUsuario()) {
        
            // Compruebo si el formualrio de actualización del perfil de usaurio está establecido            
            if (isset($_POST['frm-hashusuario'])) {
                // Recupero del formulario la URL a la que se redigirá al usuario tras aceptar notificación.
                $urlAceptarNotificacion = filter_input(INPUT_POST, 'frm-urlaceptar');                
                // Recupero los datos del formulario de cambio de password del perfil de usuario
                $hashUsuario = filter_input(INPUT_POST, 'frm-hashusuario');
                $nuevoPassword = filter_input(INPUT_POST, 'frm-nuevo-password');
                $repetirPassword = filter_input(INPUT_POST, 'frm-repetir-password');
                // Verifico que la contraseña nueva y la contraseña repetida coinciden antes de continuar el proceso
                if ($nuevoPassword !== $repetirPassword) {throw new AppException("Los campos de contraseña nueva y repetida no coinciden!!!");}
                // Recupero al usuario actualizado desde su hash de usuario
                $usuario = Usuario::consultarUsuario($hashUsuario);
                // Si ha sido posible recuparar al usuario para actualizarle su password de perfil
                if ($usuario instanceof Usuario) {     
                    // Genero el hash de la nueva contraseña del perfil de usuario
                    $nuevoPassword = hash('sha256', $usuario->getUsuario() . $nuevoPassword);
                    // Preparo los datos para la actualización del perfil de usuario
                    $datosUsuario = [':codigo' => $hashUsuario, ':contrasenya' => $nuevoPassword];
                    // Actulizo el password del perfil de usuario y muestro la notificación del resultado
                    if ($usuario->cambiarContraseñaUsuario($datosUsuario)) {
                        // Notifico al usuario que la actualización del perfil fue existosa
                        ErrorController::mostrarMensajeInformativo($smarty, "Password del perfil de usuario cambiado con éxito!!", $urlAceptarNotificacion);
                    } else {
                        // Lanzo una excepción para indicar que no es posible obtener valores por defecto del perfil de usuario
                        throw new AppException(message: "No es posible cambiar el password del perfil de usuario", 
                            urlAceptar: $urlAceptarNotificacion);
                    }                    
                } else {
                    // Lanzo una excepción para indicar que no es posible obtener el perfil de usuario
                    throw new AppException(message: "No es posible recuperar el perfil de usuario", 
                        urlAceptar: $urlAceptarNotificacion);   
                }                                
            } else {
                // Lanzo una excepción para indicar que no existen datos para acutalizar el perfil de usuario
                throw new AppException("No existen datos para cambiar el password del perfil de usuario");   
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para mostrar su perfil
            throw new AppException("Su rol en la plataforma no le permite cambiar el password  del perfil de usuario");

        }

    }
    
    /**
     * Método estático que solicita confirmación para eliminar un perfil de usuario de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarConfirmacionBajaUsuarioPlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo la procedencía de la ejecución de la presente acción
        // Si la variable de sesion listado está establecida junto 
        // El usuario logueado tiene permiso para listar usuarios. Entonces:        
        if (isset($_SESSION['listado']) && $permisosUsuario->getPermisoListarUsuarios()) {
            // Un usuario autorizado a elegido del listado la acción eliminar usuario
            // Establezco la configuración del mensaje de confirmación para el usuario autorizado
            $mensaje = "Has solicitado eliminar a un usuario de la plataforma";
            $pregunta = "¿Estás seguro que quieres eliminar a dicho usuario?";
            $urlCancelar = "/plataforma/backoffice.php?comando=usuarios:listar";
            $urlAceptar = "/plataforma/backoffice.php?comando=usuarios:eliminar:procesa";
        } else {
            // Un usuario logueado a elegido desde su perfil la acción eliminar usuario
            // Establezco la configuración del mensaje de confirmación para el usuario logueado
            $mensaje = "Has solicitado eliminar a su perfil de usuario en la plataforma";
            $pregunta = "¿Estás seguro que quieres eliminar su perfil de usuario?";
            $urlCancelar = "/plataforma/backoffice.php";
            $urlAceptar = "/plataforma/backoffice.php?comando=usuarios:eliminar:procesa";
        }

        // Muestro el mensaje de confirmación de baja al usuario
        ErrorController::mostarMensajeAdvertencia($smarty,$mensaje,$pregunta,$urlCancelar,$urlAceptar);
    }

    /**
     * Método estático para eliminar el perfil de un usuario de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al eliminar el perfil de un usuario
     */
    public static function eliminarUsuarioPlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo la procedencía de la ejecución de la presente acción
        // Si la variable de sesion listado está establecida junto 
        // El usuario logueado tiene permiso para listar usuarios. Entonces:
        if (isset($_SESSION['listado']) && $permisosUsuario->getPermisoListarUsuarios()) {
            // El usuario autorizado está solicitando eliminar el perfil de un usuario no logueado
            // Recupero el hash identificador de usuario desde la variable de sesion
            $hashUsuario = $_SESSION['listado'];
            // Consulto a la base de datos por el usuario contenido en la variable de sessión listado
            $usuario = Usuario::consultarUsuario($hashUsuario);
            // Establezco los mensajes de notificación y URL de destino para administradores
            $urlAceptarNotificacion = "/plataforma/backoffice.php?comando=usuarios:listar";
            $mensajeError = "No se ha podido completar la baja del usuario! Por favor, revise el perfil del usuario.";
            // Elimino la variable de sesión listado porque ya ha cumplido su función en esta acción
            unset($_SESSION['listado']);
        } else {
            // De lo contrario, el usuario está pidiendo eliminar su propio perfil de usuario
            // Obtengo al usuario de la sesión del navegacion
            $usuario = $_SESSION['usuario'];
            // Obtengo el hash identificador de usuario
            $hashUsuario = $usuario->getCodigo();
            // Establezco los mensajes de notificación y URL de destino para el resto de usuarios
            $urlAceptarNotificacion = "/plataforma/backoffice.php?comando=core:logout:procesa";
            $mensajeError = "No se ha podido completar su baja como usuario! Por favor, contacte con los administradores.";
        }

        // Compruebo si el usuario tiene permisos para eliminar el perfil de usuario
        if ($permisosUsuario->getPermisoEliminarUsuario()) {

            // Identifico a la persona usuaria
            $personaUsuaria = Persona::identificarPersona($hashUsuario);

            // Proceso la informacion del perfil si este existe
            if ($usuario instanceof Usuario && $personaUsuaria instanceof Persona) {

                // Preparo los datos para la eliminación del perfil de usuario
                $codigoUsuario = [':usuario' => $hashUsuario];

                // Compruebo si la persona usuario pudo eliminarse de la plataforma para
                // desvincular sus datos persnales del usuario y dejarlo para fines funcionales.
                if ($personaUsuaria->eliminarPersona($codigoUsuario)) {
                    // Modifico el estado del perfil del usuario a BAJA.
                    $usuario->setEstado('BAJA');
                    // Preparo la información para actualizar el nuevo estado del perfil de usuario elminiado
                    $datosUsuario = [':codigo' => $hashUsuario,':estado' => $usuario->getEstado(), ':rol' => $usuario->getRol()];
                    // Actualizo el estado del perfil de usuario elminado a su nuevo estado en la plataforma
                    if ($usuario->actualizarUsuario($datosUsuario)) {
                        // Notifico al usuario que el perfil se ha eliminado correctamente y cierro su sesión
                        ErrorController::mostrarMensajeInformativo($smarty, "El perfil de usuario se ha elminado correctamente!",
                            $urlAceptarNotificacion);
                    } else {
                        // Lanzo una excepción para indicar que no existe perfil de usuario
                        throw new AppException(message: $mensajeError, 
                            urlAceptar: $urlAceptarNotificacion);
                    }
                } else {
                    // Lanzo una excepción para indicar que existe algún problema para dar de baja al usuario
                    throw new AppException("No es posible dar de baja al usuario!");
                }
            } else {
                // Lanzo una excepción para indicar que no existe perfil de usuario
                throw new AppException("Este usuario ya está desvinculado de la platforma!");
            }
        } else {
            // Lanzo excepción para notificar al usuario que no tiene permiso para eliminar el perfil
            throw new AppException("Su rol en la plataforma no le permite eliminar el perfil de usuario");
        }

    }

    /**
     * Método estático para mostrar la confirmación de activación del perfil de un usuario (INCOMPLETA)
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema al mostrar confirmación para activación del perfil de usuario
     */
    public static function mostrarConfirmacionActivarUsuarioPlataforma($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo la procedencía de la ejecución de la presente acción
        // Si la variable de sesion listado está establecida junto 
        // El usuario logueado tiene permiso para listar usuarios. Entonces:
        if (isset($_SESSION['listado']) && $permisosUsuario->getPermisoListarUsuarios()) {
            // El usuario autorizado está solicitando activar el perfil de un usuario no logueado
            // Notifico al usuario autorizado que la funcionalidad no está implementada en la plataforma
            // RECUERDA: Sólo los administradores están autorizado a listar a los usuarios de la plataforma
            ErrorController::mostrarMensajeInformativo($smarty, "Disculpa! Por cuestiones técnicas esta acción no está disponible en la platforma. Gracias!",
                "/plataforma/backoffice.php?comando=usuarios:default");
        } else {
            // De lo contrario, el usuario logueado NO tiene permisos para activar el perfil de un usuario
            // lanzo una excepción para notificar al usuario de la incidencia
            throw new AppException("Su rol en la plataforma no le permite activar el perfil de usuario");
        }
        
        // NO IMPLEMENTO ESTA FUNCIONALIDAD POR FALTA DE TIEMPO EN DESARROLLO: 25/03/2025.

    }

    /* NO IMPLEMENTO ESTA FUNCIONALIDAD POR FALTA DE TIEMPO EN DESARROLLO: 25/03/2025.
    public static function activarUsuarioPlataforma($smarty) {...} */

    /**
     * Método estático para mostrar la confirmación de desactivación del perfil de un usuario (INCOMPLETA)
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantilla Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe algún problema de permitar para desactivar el perfil de usuario
     */
    public static function mostrarConfirmacionDesactivarUsuarioPlataforma($smarty) {
        
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo que el usuario tiene los permisos adecuados para desactivar el perfil del usuario
        if ($permisosUsuario->getPermisoDesactivarUsuario()) {
            // El usuario logueado tiene permisos para desactivar el perfil de usuario. Entonces:
            // Le notifico que la funcionalidad no se encuentra disponible en la plataforma
            ErrorController::mostrarMensajeInformativo($smarty, "Disculpa! Por cuestiones técnicas esta acción no está disponible en la platforma. Gracias!");
        } else {
            // De lo contrario, el usuario logueado NO tiene permisos para desactivar el perfil de un usuario
            // lanzo una excepción para notificar al usuario de la incidencia
            throw new AppException("Su rol en la plataforma no le permite desactivar el perfil de usuario");
        }

        // NO IMPLEMENTO ESTA FUNCIONALIDAD POR FALTA DE TIEMPO EN DESARROLLO: 25/03/2025.

    }

    /* NO IMPLEMENTO ESTA FUNCIONALIDAD POR FALTA DE TIEMPO EN DESARROLLO: 25/03/2025.
    public static function desactivarUsuarioPlataforma($smarty) {...} */

}

 ?>
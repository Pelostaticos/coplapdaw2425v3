<?php

/**
 * Enrutador del backoffice de la plataforma web Correplayas
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene el código PHP del enrutador de la plataforma web del proyecto, encargado de recbir del
 * usuario los comandos y datos de las acciones que desea realizar para decidir que controlador es
 * el encargado en la aplicación web de ejecutarlas.
 *
 * @category "Enrutador"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

// 0º) Defino el espacio de nombre del fichero
namespace correplayas;

// 1º) Cargo el fichero de configuración de la plataforma web
require_once(__DIR__ . '/config/config-inc.php');

// 2º) Cargo las librerias requeridas por la plataforma web
require_once(__DIR__ . SMARTY_LIB);
use Smarty\Smarty;
use correplayas\controladores\ErrorController;
use correplayas\excepciones\AppException;

// 3º) Inicio la sesion web en la plataforma web
session_start();

// 4º) Configuro el motor de plantillas Smarty
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . TEMPLATE_DIR);
$smarty->setCompileDir(__DIR__ . COMPILE_DIR);
$smarty->setCacheDir(__DIR__ . CACHE_DIR);
$smarty->setConfigDir(__DIR__ . CONFIGS_DIR);

// 5º) Obtengo el comando de acción requerida por el usuario.
$comando = filter_input(INPUT_GET, 'comando', FILTER_SANITIZE_SPECIAL_CHARS);

// Mensaje temporal para depuración del enrutador:
echo "Bienvenido al futuro enrutador de la Playaforma Correplayas...";
echo "<br/>";
echo "El comando que quieres ejecutar es: " . $comando;
echo "<br/>";

// 6º) Compruebo si el usuario tiene iniciada una sesion para restringir las acciones disponibles
try {
    // Intento ejecutar el comando solicitado por el usuario
    if (isset($_SESSION['usuario'])) {
        // 6.1º) Gestiono la petición como un comando del backoffice para un usuario logueado
        echo "Hola! Esta funciones no están disponible por el momento... Gracias!";
        switch ($comando) {
            // Por defecto si estas logueado y no solicitas nada te muestro la página de inicio del backoffice.
            default:
                echo "Por defecto siempre te mostraré la página de inicio del backoffice";
                break;
        }
    } else {
        // 6.2) Gestiono la petición como un comando esencial de la plataforma para un visitante web.
        switch ($comando) {
            // Solicita el inicio de sesión en la plataforma
            case "core:login:vista":
                echo "Te muestro el formulario de inicio de sesión...";                
                break;
            // Inicio el proceso de autenticación del usuario en la plataforma            
            case "core:login:procesa":
                echo "Inicio tu autenticación en la plataforma...";
                var_dump($_POST);
                break;
            // Un usuario visitante quiere registrarse en la plataforma
            case "core:signup:vista":
                echo "Te muestro el formulario de registro...";
                break;
            // Completo el proceso de registro de un nuevo usuario en la plataforma
            case "core:signup:procesa":
                echo "Bienvenido! Completo tu registro en nuestra plataforma...";
                var_dump($_POST);
                break;
            // Un usuario visitante quiere contactar con los administradores por email
            case "core:email":
                echo "Enviando formulario de contacto a los administradores de la plataforma...";
                var_dump($_POST);
                echo '<a href="/">Volver al inicio</a>';
                break;
            // Por defecto para un usuario no logueado y comando desconocido se le lleva al inicio de sesión
            default:
                echo "No estas logueado! Te llevo al inicio del sesión...";
                break;
        }
    }    
} catch (AppException $excepcion) {
    echo "No se ha podido ejecutar el comando solicitado!!";
    // ErrorController::handleException($e, $smarty);
}

?>
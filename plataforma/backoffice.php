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

// 1º) Cargo el fichero de configuración y clases de la plataforma web
require_once(__DIR__ . '/config/config-inc.php');
require_once(__DIR__ . '/excepciones/AppException.php');
require_once(__DIR__ . '/modelo/Persona.php');
require_once(__DIR__ . '/modelo/Usuario.php');
require_once(__DIR__ . '/modelo/Rol.php');
require_once(__DIR__ . '/controladores/ErrorController.php');
require_once(__DIR__ . '/nucleo/Core.php');


// 2.1º) Cargo las librerias requeridas por la plataforma web
require_once(__DIR__ . SMARTY_LIB);
require_once(__DIR__ . PHPMAILER_LIB);
require_once(__DIR__ . PHPMAILER_SMTP);
require_once(__DIR__ . PHPMAILER_EXCEPTION);

// 2.2º) Establezco los espacio de nombre que voy a utilizar
use Smarty\Smarty;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
use correplayas\controladores\ErrorController;
use correplayas\controladores\Usuarios;
use correplayas\excepciones\AppException;
use correplayas\nucleo\Core;

// 3º) Inicio la sesion web en la plataforma web
session_start();

// 4.1º) Configuro el motor de plantillas Smarty
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . TEMPLATE_DIR);
$smarty->setCompileDir(__DIR__ . COMPILE_DIR);
$smarty->setCacheDir(__DIR__ . CACHE_DIR);
$smarty->setConfigDir(__DIR__ . CONFIGS_DIR);

// 4.2) Configuro el servidor SMTP para envío de correo electrónico
$mail = new PHPMailer(true);
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->Host = SMTP_HOST;
$mail->SMTPAuth = true;
$mail->Username = SMTP_USER;
$mail->Password = SMTP_PASS;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = SMTP_PORT;
$mail->setFrom(SMTP_FROM, 'Plataforma Correplayas');

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
            // Solicita el cierre de sesión en la plataforma
            case "core:logout:vista":
                Core::mostrarCierreSesion($smarty);
                break;
            // Cierro la sesión del usuario en la plataforma
            case "core:logout:procesa":
                Core::cerrarSesion();
                break;
            // Por defecto si estas logueado y no solicitas nada te muestro la página de inicio del backoffice.
            default:
                // Solicito que se muestre la página de inicio del backoffice dela plataforma.
                Core::default($smarty);
                break;
        }
    } else {
        // 6.2) Gestiono la petición como un comando esencial de la plataforma para un visitante web.
        switch ($comando) {
            // Solicita el inicio de sesión en la plataforma
            case "core:login:vista":
                Core::mostrarInicioSesion($smarty);
                break;
            // Inicio el proceso de autenticación del usuario en la plataforma            
            case "core:login:procesa":
                Core::iniciarSesion($smarty);
                break;          
            // Un usuario visitante quiere registrarse en la plataforma
            case "core:signup:vista":
                Core::mostrarRegistroVoluntario($smarty);
                break;
            // Completo el proceso de registro de un nuevo usuario en la plataforma
            case "core:signup:procesa":
                Core::registrarVoluntario($smarty);
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
} catch (AppException $ae) {
    ErrorController::handleException($ae, $smarty);
}

?>
<?php
require_once("../plataforma/librerias/smarty/libs/Smarty.class.php");
//echo phpinfo();
$smarty = new Smarty\Smarty;
$smarty->setTemplateDir("../plataforma/plantillas");
$smarty->setCompileDir("../plataforma/vistas");
$smarty->setCacheDir("../plataforma/cache");
$smarty->setConfigDir("../plataforma/config");

$vista = filter_input(INPUT_GET,'vista',FILTER_SANITIZE_SPECIAL_CHARS);
echo $vista;

switch ($vista) {
    case '1':
        $smarty->assign('titulo', 'Notificaciones backoffice');
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('tipo', 'warning');
        $smarty->assign('mensaje', 'Has solicitado eliminar tu perfil de usuario de la plataforma');
        $smarty->assign('pregunta', '¿Quieres eliminar su usuario?');
        $smarty->assign('aceptar', '/plataforma/backoffice.php');
        $smarty->assign('cancelar', '/pruebas/smarty.php');              
        $smarty->display('comunes/notificaciones.tpl');
        break;
    case '2':
        $smarty->assign('titulo', 'Notificaciones backoffice');
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('tipo', 'info');
        $smarty->assign('mensaje', '¡Hemos enviado correctamente tu mensaje de contacto!');
        // $smarty->assign('pregunta', '¿Quieres eliminar su usuario?');
        $smarty->assign('aceptar', '/pruebas/smarty.php');
        $smarty->display('comunes/notificaciones.tpl');        
        break;
    case '3':
        $smarty->assign('titulo', 'Notificaciones backoffice');
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('tipo', 'error');
        $smarty->assign('mensaje', 'Tu rol de usuario no te permite ejecutar esta acción');
        // $smarty->assign('pregunta', '¿Quieres eliminar su usuario?');   
        $smarty->assign('aceptar', '/pruebas/smarty.php');             
        $smarty->display('comunes/notificaciones.tpl');        
        break;
    case '4':
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));        
        $smarty->display('comunes/logout.tpl');
        break;
    case '5':
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));        
        $smarty->display('comunes/login.tpl');
        break;
    case '6':
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));        
        $smarty->display('comunes/signup.tpl');
        break;
    case '7':         
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->display('comunes/contacto.tpl');
        break;
    case '8':
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->display('usuarios/perfil.tpl');        
        break;
    case '9':
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->display('usuarios/listado.tpl');        
        break;        
    default:
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->display('comunes/backoffice.tpl');
        break;
}
?>

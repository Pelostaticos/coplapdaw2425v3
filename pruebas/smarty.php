<?php
require_once("../plataforma/librerias/smarty/libs/Smarty.class.php");
//echo phpinfo();
$smarty = new Smarty\Smarty;
$smarty->setTemplateDir("../plataforma/plantillas");
$smarty->setCompileDir("../plataforma/vistas");
$smarty->setCacheDir("../plataforma/cache");
$smarty->setConfigDir("../plataforma/config");

$vista = filter_input(INPUT_GET,'vista',FILTER_SANITIZE_SPECIAL_CHARS);

switch ($vista) {
    case '1':
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('tipo', 'warning');
        $smarty->assign('mensaje', 'Has solicitado eliminar tu perfil de usuario de la plataforma');
        $smarty->assign('pregunta', '¿Quieres eliminar su usuario?');        
        $smarty->display('comunes/notificaciones.tpl');        
        break;
    default:
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        $smarty->display('comunes/backoffice.tpl');
        break;
}
?>

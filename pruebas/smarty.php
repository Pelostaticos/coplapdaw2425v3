<?php
require_once("../plataforma/librerias/smarty/libs/Smarty.class.php");
//echo phpinfo();
$smarty = new Smarty\Smarty;
$smarty->setTemplateDir("../plataforma/plantillas");
$smarty->setCompileDir("../plataforma/vistas");
$smarty->setCacheDir("../plataforma/cache");
$smarty->setConfigDir("../plataforma/config");
$smarty->assign('name', 'Ned');
$smarty->display('comunes/backoffice.tpl');
?>

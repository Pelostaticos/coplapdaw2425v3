<?php
require_once("../plataforma/librerias/smarty/libs/Smarty.class.php");
//echo phpinfo();
$smarty = new Smarty\Smarty;
$smarty->setTemplateDir("../plataforma/plantillas");
$smarty->setCompileDir("../plataforma/templates_c");
$smarty->setCacheDir("../plataforma/cache");
$smarty->setConfigDir("../plataforma/cache");
$smarty->assign('name', 'Ned');
$smarty->display('index.tpl');
?>

<?php

/**
 * Fichero configuración de la plataforma correplayas
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas rutas y datos de configuración requeridas por la aplicación web
 *
 * @category "Configuracion"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

// Datos de configuración del motor de plantillas Smarty
define('SMARTY_LIB', '/librerias/smarty/libs/Smarty.class.php');
define('TEMPLATE_DIR', '/plantillas');
define('COMPILE_DIR', '/vistas');
define('CACHE_DIR', '/cache');
define('CONFIGS_DIR', '/config');

// Datos de configuración de la base de datos
define('DB_DSN', 'mysql:host=sergiopdaw.xampp.local:3306;dbname=sergiodaw;charset=utf8mb4');
define('DB_USER','pelostaticos');
define('DB_PASSWORD','S04#G07#B80');

// Datos de configuración de la libreria PHPMailer para envío de correc electrónico
define('PHPMAILER_LIB','/librerias/phpmailer/PHPMailer.php');
define('PHPMAILER_SMTP','/librerias/phpmailer/SMTP.php');
define('PHPMAILER_EXCEPTION','/librerias/phpmailer/Exception.php');

// Datos de configuración del servidor SMTP para envío de formualrios de contacto
define('SMTP_HOST','cl2024010909001.dnssw.net');
define('SMTP_USER','webmaster@sergiofct.bitgarcia.es');
define('SMTP_PASS','qN5]gyT5*');
define('SMTP_PORT','25');
define('SMTP_FROM','webmaster@sergiofct.bitgarcia.es');
define('SMTP_BCC','sgarbut482@g.educaand.es');

 ?>
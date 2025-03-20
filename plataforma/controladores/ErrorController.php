<?php
/**
 * Clase del controlador de errores de la plataforma correplayas
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene la funciones esenciales para el manejo de errores y otras notificaciones
 * que puedan surgir durante el funcionamiento de la plataforma web.
 *
 * @category "Controlador"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

// Defino el espacio de nombre para esta clase
namespace correplayas\controladores;

// Establezco los espacio de nombres que va a utilizar esta clase
use correplayas\excepciones\AppException;
use Smarty\Smarty;

/**
 * Clase del controlador de errores de la plataforma web
 */
class ErrorController {

    /**
     * Método estático para manejar las excepceciones producidas en la plataforma
     *
     * @param AppException $ae Objeto que contiene información sobre la excepción de aplicación lanzada
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @param string $aceptar URL a donde se le redirige al usuario tras aceptar el mensaje de error
     * @param string $mensaje Mensaje de error que se le notifica al usuario
     * @return void No devuelve valor alguno
     */
    public static function handleException (AppException $ae, Smarty $smarty, ?string $aceptar=null, ?string $mensaje = null)
    {
        // Establezco el mennsaje por defecto de la excepción a manejar.
        if ($mensaje === null) {
            $mensaje = $ae->getMessage();
        }
        // Establezco la url para redirigir al aceptar el usuario la notificación
        if ($aceptar === null) {
            $aceptar = $ae->getUrlAceptar();
        }
        // Establezco las variables de la plantilla para las notificaciones
        $smarty->assign('titulo', 'Notificaciones backoffice');
        if (!isset($_SESSION['usuario']))
            $smarty->assign('usuario', 'Quierido/a voluntario/a');
        else
            $smarty->assign('usuario', $_SESSION['usuario']->getUsuario());
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('tipo', 'error');
        $smarty->assign('mensaje', $mensaje);
        $smarty->assign('aceptar', $aceptar);
        // Muestro la plantilla con la vista de notificaciones al usuario
        $smarty->display('comunes/notificaciones.tpl');
    }

    /**
     * Método estático que muestra al usuario un mensaje de advertencia o confirmación
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantilla Smarty
     * @param string $mensaje Mensaje de advertencia que se le quiere notificar al usuario
     * @param string $pregunta Pregunta a modo de confirmación de acción del usuario
     * @param string $urlCancelar URL que redirige al usuario en caso de cancelar la acción
     * @param string $urlAceptar URL que redirige al usuario en caso de aceptar la acción
     * @return void No devuelve valor alguno
     */
    public static function mostarMensajeAdvertencia(Smarty $smarty, $mensaje="", $pregunta ="", $urlCancelar="/plataforma/backoffice.php", $urlAceptar="/plataforma/backoffice.php") {
        // Establezco las variables para la plantilla de notificaciones en versión advertencia
        $smarty->assign('titulo', 'Notificaciones backoffice');
        if (!isset($_SESSION['usuario']))
            $smarty->assign('usuario', 'Quierido/a voluntario/a');
        else
            $smarty->assign('usuario', $_SESSION['usuario']->getUsuario());
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('tipo', 'warning');
        $smarty->assign('mensaje', $mensaje);
        $smarty->assign('pregunta', $pregunta);
        $smarty->assign('aceptar', $urlAceptar);
        $smarty->assign('cancelar', $urlCancelar);
        // Muestro la plantilla con la vista de notificaciones al usuario en modo mensaje advertencia         
        $smarty->display('comunes/notificaciones.tpl');    
    }

    /**
     * Método estático que muestra al usuario un mensaje informativo
     *
     * @param Smarty $smarty  Objeto del motor de plantillas Smarty
     * @param string $mensaje Mensaje informativo que se le notifica al usuario
     * @param string $urlAceptar URL a donde se le redirige al usuario al aceptar el mensaje informativo
     * @return void No devuelve valor alguno
     */
    public static function mostrarMensajeInformativo(Smarty $smarty, $mensaje="", $urlAceptar="/plataforma/backoffice.php") {
        // Establezco las variables para la plantilla de notificaciones en versión advertencia
        $smarty->assign('titulo', 'Notificaciones backoffice');
        if (!isset($_SESSION['usuario']))
            $smarty->assign('usuario', 'Quierido/a voluntario/a');
        else
            $smarty->assign('usuario', $_SESSION['usuario']->getUsuario());
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('tipo', 'info');
        $smarty->assign('mensaje', $mensaje);
        $smarty->assign('aceptar', $urlAceptar);
        // Muestro la plantilla con la vista de notificaciones al usuario en modo mensaje informativo
        $smarty->display('comunes/notificaciones.tpl');           

    }

    /**
     * Método estático que muestra al usuario un mensaje de error genérico
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @param string $mensaje Mensaje genérico de error que se le notifica al usuario
     * @param string $urlAceptar URL a donde se le redirige al usuario tras aceptar notificación
     * @return void No devuelve valor alguno
     */
    public static function mostrarMensajeError(Smarty $smarty, $mensaje="", $urlAceptar="/plataforma/backoffice.php") {
        // Establezco las variables para la plantilla de notificaciones en versión advertencia
        $smarty->assign('titulo', 'Notificaciones backoffice');
        if (!isset($_SESSION['usuario']))
            $smarty->assign('usuario', 'Quierido/a voluntario/a');
        else
            $smarty->assign('usuario', $_SESSION['usuario']->getUsuario());
        $smarty->assign('anyo', date('Y'));
        $smarty->assign('tipo', 'error');
        $smarty->assign('mensaje', $mensaje);
        $smarty->assign('aceptar', $urlAceptar);
        // Muestro la plantilla con la vista de notificaciones al usuario en modo mensaje error generico
        $smarty->display('comunes/notificaciones.tpl');           
    }

}
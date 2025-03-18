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
    public static function handleException (AppException $ae, Smarty $smarty, string $aceptar, ?string $mensaje = null)
    {
        // Establezco el mennsaje por defecto de la excepción a manejar.
        if ($mensaje === null) {
            $mensaje = $ae->getMessage();
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

    public static function mostarMensajeAdvertencia() {
        
    
    }

    public static function mostrarMensajeInformativo() {

    }

}
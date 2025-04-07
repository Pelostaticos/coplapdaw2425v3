<?php

/**
 * Clase del controlador para gestionar todas las acciones con censos de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los censos de la plataforma correplayas.
 * 
  *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 * OBSERVACIONES: Desarrollo descartado por falta de tiempo para cumplir con plazos de entrega * 
 */

 // Defino el espacio de nombre para esta clase del controlador para censos
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\controladores\ErrorController;
use Smarty\Smarty;

/**
 * Clase del controlador Censos para gestión de todas sus acciones disponibles en plataforma
 */
class Censos {

    /**
     * Método estático por defecto para mostrar vistas del gestor de censos de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function default($smarty) {

        // Le muestro un mensaje informativo indicandole que el gestor no se encuentra implementado
        ErrorController::mostrarMensajeInformativo($smarty, "Por cuestiones técnicas el gestor de censos no
            se encuentra implementado en la plataforma. Disculpe las molestias!!");

    }

    // RECUERDA: He descartado la implementación de este gestor por falta de tiempo para cumplir con plazos de entrega

}

?>
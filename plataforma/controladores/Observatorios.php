<?php

/**
 * Clase del controlador para gestionar todas las acciones con observatorios de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los observatorios de la plataforma correplayas.
 * 
  *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 * OBSERVACIONES: Desarrollo descartado por falta de tiempo para cumplir con plazos de entrega * 
 */

 // Defino el espacio de nombre para esta clase del controlador para observatorios
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\controladores\ErrorController;
use correplayas\excepciones\AppException;
use Smarty\Smarty;

/**
 * Clase del controlador Observatorios para gestión de todas sus acciones disponibles en plataforma
 */
class Observatorios {

    /**
     * Método estático por defecto para mostrar vistas del gestor de observatorios de la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción existe algún error con los permisos del usuario
     */
    public static function default($smarty) {

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado es administrador
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Le muestro un mensaje informativo indicandole que el gestor no se encuentra implementado
            ErrorController::mostrarMensajeInformativo($smarty, "Por cuestiones técnicas el gestor de observatorios no
                se encuentra implementado en la plataforma. Disculpe las molestias!!");
        } else {
            // De lo contario, el usuario logueado no tiene permisos para ejecutar este gestor
            // Por tanto, lanzo una excepción para notificar del error asl usuario
            throw new AppException("Su rol en la plataforma no le permite ejecutar el gestor de observatorios");
        }

    }

    // RECUERDA: He descartado la implementación de este gestor por falta de tiempo para cumplir con plazos de entrega

}
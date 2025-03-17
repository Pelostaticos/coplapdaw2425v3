<?php

/**
 * Clase del excepciones específcas de la plataforma correplayas
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos esenciales para generar las excepciones que
 * se produzca durante el funcionamiento de la plataforma.
 *
 * @category "Excepciones"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

// Defino el espacio de nombre de la presente clase
namespace correplayas\excepciones;

/**
 * Clase espécifica de excepciones para la plataforma web
 */
class AppException extends \Exception
{

    // Defino las constante con los errores más comunes de la plataforma web.
    public const DB_UNABLE_TO_CONNECT=100;
    public const DB_NOT_CONNECTED=101;
    public const DB_QUERY_EXECUTION_FAILURE=102;
    public const DB_CONSTRAINT_VIOLATION_IN_QUERY=103;
    public const DB_ERROR_IN_QUERY=104;
    public const RESTRICTED_AREA=101;
 
    // Defino los atributos de la propia clase
    protected $urlAceptar;

    // Defino el constructor de la propia clase

    /**
     * Constructor para la clase excepciones de la plataforma web
     *
     * @param string $message Mensaje del error que se desea notificar al usuario
     * @param integer $code Código del error que se desea notificar al usuario
     * @param string $urlAceptar URL a la que se le redirge al usuario tras aceptar la notificación del error
     * @param \Throwable|null $previous Controla la posibilidad de encadenar de excepciones
     */
    public function __construct($message = "", $code = 0, string $urlAceptar = '/plataforma/backoffice.php', ?\Throwable $previous = null) {
        // Establezco los párametros del constructor padre
        parent::__construct($message, $code, $previous);
        // Establezco el atributo que contiene la URL a donde se redigirá al usuario cuando pulse en aceptar notificacion
        $this->urlAceptar=$urlAceptar;
    }

    // Defino los métodos getters y setters para esta clase

    /**
     * Método GET para obtener la URL a donde se redireccionará al usuario tras aceptar la notificación
     *
     * @return void No devuelve valor alguno
     */
    public function getUrlAceptar() {
        return $this->urlAceptar;
    }

    // Defino los métodos estáticos con las funciones de excepciones más comunes

    /**
     * Método estático que genera una excepción de aplicación para notificar el área restringida de la plataforma web
     *
     * @return void
     */
    public static function restrictedArea()
    {
        return new self("Está intentando acceder a un área restringida. Login necesario.",self::RESTRICTED_AREA);
    }
}
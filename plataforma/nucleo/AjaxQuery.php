<?php

/**
 * Clase del núcleo para intercambio asíncrono de datos en la plataforma correplayas para lado servidor
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene la funciones esenciales para el intercambio asíncrono de datos con el frontend. En
 * concreto para compartir datos sobre: Roles, observatorios, aves, localidades y familias.
  *
 * @category "Núcleo"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

 // 0º) Defino el espacio de nombres de la clase
namespace correplayas\nucleo;

// 1º) Defino los espacios de nombres que voy a utilizar en esta clase

use correplayas\excepciones\AppException;
use PDO;
use PDOException;

// 2º) Defino la clase del nucleo AJAX de la plataforma correplayas

/**
 * Clase del núcleo AJAX de la plataforma correplayas para el intercambio asíncrono de datos
 */
class AjaxQuery {

    // A) Método estático por defecto para gestionar la peticiones AJAX del frontend

    public static function default() {
        // Recupero petición AJAX desde el frontend
        $peticionAjax = AjaxQuery::recuperarPeticionAjax();
        // Recupero el comando del intercambio de datos asincrono desde la petición AJAX
        var_dump($peticionAjax);
        exit;
        // Compruebo que hay una sesión de usuario iniciada antes de procesar la petición AJAX
        if (isset($_SESSION['usuario'])) {
            // Gestiono la petición AJAX para usuarios logueados
        } else {
            // Gestiono la petición AJAX para usuarios visitantes
        }
    }

    // B) Método estáticos privados para funciones auxiliares del intercambio asincrono de datos con frontend

    /**
     * Método estático auxiliar para recuperar las peticiones AJAX realizadas desde el frontend (Privado)
     *
     * @return array|null Devuelve un array asociativo con los datos de la petición Ajax desde frontend
     *                    Devuelve nulo cuando no se ha recibido petición Ajax desde el frontend
     */
    private static function recuperarPeticionAjax(): ?array {
        // Devuelvo los datos de la petición AJAX enviadas desde el frontend
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * Método estático auxiliar para responder a una petición AJAX realizada desde el frontend (Privado)
     *
     * @param array $respuesta Array asociativo que contiene los datos con la respuesta AJAX al frontend
     * @return void No devuelve valor alguno
     */
    private static function responderPeticionAjax(array $respuesta) {
        // Establezco el encabezado que le indica al frontend que la respuetsa del servidor 
        // está en formato JSON típica de un intercambio asincrono de datos con AJAX
        header('Content-Type: application/json');
        // Genero la respuesta del servidor a la petición AJAX en formato JSON.
        echo json_encode($respuesta);
    }

    /**
     * Método estático auxiliar para responder con error a una petición AJAX realizada desde el frontend (Privado)
     *
     * @param string $respuestaError Mensaje de respuesta del error de la petición AJAX del frontend
     * @param integer $codigo Código de estado HTTP de la respuesta
     * @return void No devuelve valor alguno
     */
    private static function responderErrorPeticionAjax(string $respuestaError, $codigo=400) {
        // Establezco el código de estado de la respuesta
        http_response_code($codigo);
        // Establezco encabezado de la respuesta del servidor para indicarle al frontend que 
        // está en formato JSON típico de un intercambio asíncrono de datos AJAX
        header('Content-Type: application/json');
        // Genero la respuesta de error del servidor a una petición AJAX en formato JSON
        echo json_encode($respuestaError);
    }

    // C) Método estáticos auxiliares para preparar los datos a intercambiar asincronamente con el frontend


}

?>
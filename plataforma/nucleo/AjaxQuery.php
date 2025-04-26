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

use correplayas\modelo\Localidad;
use correplayas\modelo\Observatorio;
use correplayas\modelo\Rol;

// 2º) Defino la clase del nucleo AJAX de la plataforma correplayas

/**
 * Clase del núcleo AJAX de la plataforma correplayas para el intercambio asíncrono de datos
 */
class AjaxQuery {

    // A) Método estático por defecto para gestionar la peticiones AJAX del frontend

    /**
     * Método estático por defecto que gestiona los comando de la peticiónes de datos asíncronas
     *
     * @return void
     */
    public static function default() {
        // Recupero el comando del intercambio de datos asincrono desde la petición AJAX
        $peticionAjax = AjaxQuery::recuperarPeticionAjax();
        $peticionAjax = isset($peticionAjax['ajaxquery']) ? $peticionAjax['ajaxquery'] : '';
        // Compruebo que hay una sesión de usuario iniciada antes de procesar la petición AJAX
        if (isset($_SESSION['usuario'])) {
            // Gestiono la petición AJAX para usuarios logueados
            switch ($peticionAjax) {
                case "usuarios:actualizar":
                    AjaxQuery::prepararDatosAjaxVistaEdicionUsuario();
                    break;
                case "jornadas:registrar":
                    AjaxQuery::prepararDatosAjaxVistaRegistroEdicionJornada();
                    break;
                case "jornadas:actualizar":
                    AjaxQuery::prepararDatosAjaxVistaRegistroEdicionJornada();
                    break;
                case "observatorios:registrar":
                    AjaxQuery::prepararDatosAjaxVistaRegistroObservatorio();
                    break;
                default:
                    // Por defecto si la petición Ajax es desconocida le respondo con un error
                    $mensaje = ['error' => 'Petición Ajax no soportada por plataforma!!!'];
                    AjaxQuery::responderErrorPeticionAjax($mensaje);
                    break;                    
            }
        } else {
            // Gestiono la petición AJAX para usuarios visitantes
            switch ($peticionAjax) {
                case "usuarios:registro":
                    AjaxQuery::prepararDatosAjaxVistaRegistroUsuario();
                    break;
                default:
                    // Por defecto si la petición Ajax es desconocida le respondo con un error
                    $mensaje = ['error' => 'Petición Ajax no soportada por plataforma!!!'];
                    AjaxQuery::responderErrorPeticionAjax($mensaje);
                    break;
            }
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
        echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Método estático auxiliar para responder con error a una petición AJAX realizada desde el frontend (Privado)
     *
     * @param array $respuestaError Array aspciativo que contiene al mensaje de respuesta del error de la petición AJAX del frontend
     * @param integer $codigo Código de estado HTTP de la respuesta
     * @return void No devuelve valor alguno
     */
    private static function responderErrorPeticionAjax(array $respuestaError, $codigo=400) {
        // Establezco el código de estado de la respuesta
        // http_response_code($codigo);
        // Establezco encabezado de la respuesta del servidor para indicarle al frontend que 
        // está en formato JSON típico de un intercambio asíncrono de datos AJAX
        header('Content-Type: application/json');
        // Genero la respuesta de error del servidor a una petición AJAX en formato JSON
        echo json_encode($respuestaError, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // C) Método estáticos auxiliares para preparar los datos a intercambiar asincronamente con el frontend

    /**
     * Método estático auxiliar para responder a una petición Ajax de la vista de registro de usuario
     *
     * @return void No devuelve valor alguno
     */
    private static function prepararDatosAjaxVistaRegistroUsuario() {
        // Defino el array asociativo con los datos de la respuesta a la petición Ajax
        $datosRespuestaAjax = [];
        // Obtengo las localidades disponibles en la plataforma
        $localidades = Localidad::listarLocalidades();        
        // Genero los datos de la respuesta Ajax con el formato adecuado para procesar el selector localidad.
        foreach($localidades as $localidad) {
            $datosRespuestaAjax[] = ['valor' => $localidad, 'nombre' => $localidad];
        }
        // Respongo al frontend con los datos solicitados en la petición Ajax
        AjaxQuery::responderPeticionAjax($datosRespuestaAjax);
    }

    /**
     * Método estático auxiliar para responder a una petición Ajax de la vista de edición de usuario
     *
     * @return void No devuelve valor alguno
     */
    private static function prepararDatosAjaxVistaEdicionUsuario() {
        // Defino el array asociativo con los datos de la respuesta a la petición Ajax
        $datosRespuestaAjax = [];
        // Defino el array asociativo con los datos de los selectores formateados
        $datosSelectorLocalidad = [];
        $datosSelectorRol = [];
        // Obtengo las localidades disponibles en la plataforma
        $localidades = Localidad::listarLocalidades();        
        // Genero los datos de la respuesta Ajax con el formato adecuado para procesar el selector localidad.
        foreach($localidades as $localidad) {
            $datosSelectorLocalidad[] = ['valor' => $localidad, 'nombre' => $localidad];
        }
        // Obtengo los roles disponibles en la plataforma
        $roles = Rol::listarRoles();
        // Genero los datos de la respuesta Ajax con el formato adecuado para procesar el selector localidad.
        foreach($roles as $rol) {
            $datosSelectorRol[] = ['valor' => $rol, 'nombre' => $rol];
        }
        // Genero la respuesta Ajax con los datos de los selectores formateados
        $datosRespuestaAjax = ['localidad' => $datosSelectorLocalidad, 'rol' => $datosSelectorRol];
        // Respongo al frontend con los datos solicitados en la petición Ajax
        AjaxQuery::responderPeticionAjax($datosRespuestaAjax);
    }

    /**
     * Método estático auxiliar para responder una petición Ajax de la visa de registro de jornada
     *
     * @return void No devuelve valor alguno
     */    
    private static function prepararDatosAjaxVistaRegistroEdicionJornada() {
        // Defino el array asociativo con los datos de la respuesta a la petición Ajax
        $datosRespuestaAjax = [];
        // Obtengo los observatorios disponibles en la plataforma
        $observatorios = Observatorio::listarObservatorios();
        // Genero los datos de la respuesta Ajax con el formato adecuado para procesar el selector observatorio.
        foreach($observatorios as $observatorio) {
            $nombre = $observatorio['nombre'] . ' (' . $observatorio['localidad'] . ')';
            $datosRespuestaAjax[] = ['valor' => $observatorio['codigo'], 'nombre' => $nombre];
        }
        // Respongo al frontend con los datos solicitados en la petición Ajax
        AjaxQuery::responderPeticionAjax($datosRespuestaAjax);             
    }

    /**
     * Método estático auxiliar para responder una petición Ajax de la vista de registro de observatorio
     *
     * @return void No devuelve valor alguno
     */    
    private static function prepararDatosAjaxVistaRegistroObservatorio() {
        // Defino el array asociativo con los datos de la respuesta a la petición Ajax
        $datosRespuestaAjax = [];
        // Obtengo los observatorios disponibles en la plataforma
        $localidades = Localidad::listarLocalidades();
        // Genero los datos de la respuesta Ajax con el formato adecuado para procesar el selector observatorio.
        foreach($localidades as $localidad) {
            $datosRespuestaAjax[] = ['valor' => $localidad, 'nombre' => $localidad];
        }
        // Respongo al frontend con los datos solicitados en la petición Ajax
        AjaxQuery::responderPeticionAjax($datosRespuestaAjax);   
    }

}

?>
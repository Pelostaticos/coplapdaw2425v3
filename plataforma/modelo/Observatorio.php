<?php

/**
 * Clase del modelo para trabajar con la tabla Observatorios de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene parcialmente las funciones y métodos para el manejo de la tabla "Jornadas" de la base
 * de datos de la plataforma correplayas, correspondiente al modelo de patrón MVC. Aquellas que son
 * estrictamente necesarias para interactuar con el gestor de jornada. Dado que el gestor de observatorios
 * se ha descartado su implementación por falta de tiempo para cumplir con entrega del proyecto DAW.
 *
 * @category "Modelo"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

// Defino el espacio de nombre para esta clase del modelo
namespace correplayas\modelo;

// Defino los espacios de mombres que voy a utilizar en esta clase
use \correplayas\nucleo\Core;

/**
 * Clase del modelo de datos para trabajar con Observatorios
 */
class Observatorio {

    // A) Defino los atributos de la clase Observatorio
    private $codigo;
    private $nombre;
    private $direccion;
    private $localidad;
    private $gps;
    private $historia;
    private $imagen;
    private $url;

    // B) Defino el constructor privado de la clase Observatorio    
    private function __construct($observatorio) {
        // Establezco los atributos de la clase Observatorio        
        $this->codigo=$observatorio['codigo'];
        $this->nombre=$observatorio['nombre'];
        $this->direccion=$observatorio['direccion'];
        $this->localidad=$observatorio['localidad'];
        $this->gps=$observatorio['gps'];
        $this->historia=$observatorio['historia'];
        $this->imagen=$observatorio['imagen'];
        $this->url=$observatorio['url'];
    }

    // C) Defino los métodos propios de la clase Observatorio
    // RECUERDA: No están implementados porque se ha descartado el gestor de observatorios.

    // D) Defino los métodos getter y setter de la clase Observatorio

    /**
     * Método GET para obtener el código del observatorio
     *
     * @return unsigned Devuelve el código del observatorio
     */
    public function getCodigoObservatorio() {
        return $this->codigo;
    }

    /**
     * Método GET para obtener el nombre del observatorio
     *
     * @return string Devuelve el nombre del observatorio
     */
    public function getNombreObservatorio() {
        return $this->nombre;
    }

    /**
     * Método GET para obtener la direccion del observatorio
     *
     * @return string Devuelve la direccion del observatorio
     */
    public function getDireccionObservatorio() {
        return $this->direccion;
    }    

    /**
     * Método GET para obtener la localidad del observatorio
     *
     * @return string Devuelve la localidad del observatorio
     */
    public function getLocalidadObservatorio() {
        return $this->localidad;
    }

    /**
     * Método GET para obtener las coordenadas GPS del observatorio
     *
     * @return string Devuelve las coordenadas GPS del observatorio
     */
    public function getGpsObservatorio() {
        return $this->gps;
    }

    /**
     * Método GET para obtener la historia del observatorio
     *
     * @return unsigned Devuelve la historia del observatorio
     */
    public function getHistoriaObservatorio() {
        return $this->historia;
    }
     
    /**
     * Método GET para obtener la imagen del observatorio
     *
     * @return unsigned Devuelve la imagen del observatorio
     */
    public function getImagenObservatorio() {
        return $this->imagen;
    }

    /**
     * Método GET para obtener la url del observatorio
     *
     * @return unsigned Devuelve la url del observatorio
     */
    public function getUrlObservatorio() {
        return $this->url;
    }

    /**
     * Método SET para modificar el nombre al observatorio
     *
     * @param string $nombre Nuevo nombre del observatorio
     * @return void No devuelve valor alguno
     */
    public function setNombreObservatorio($nombre) {
        $this->nombre=$nombre;
    }

    /**
     * Método SET para modificar la direccion del observatorio
     *
     * @param string $direccion Nueva direccion del observatorio
     * @return void No devuelve valor alguno
     */
    public function setDireccionObservatorio($direccion) {
        $this->direccion=$direccion;
    }

    /**
     * Método SET para modificar la localidad del observatorio
     *
     * @param string $localidad Nuevo nombre de la localidad del observatorio
     * @return void No devuelve valor alguno
     */
    public function setLocalidadObservatorio($localidad) {
        $this->localidad=$localidad;
    }

    /**
     * Método SET para modificar las coordenadas GPS del observatorio
     *
     * @param string $gps Nuevas coordenadas GPS del observatorio
     * @return void No devuelve valor alguno
     */
    public function setGpsbservatorio($gps) {
        $this->gps=$gps;
    }

    /**
     * Método SET para modificar la historia del observatorio
     *
     * @param string $historia Nueva historia del observatorio
     * @return void No devuelve valor alguno
     */
    public function setHistoriaObservatorio($historia) {
        $this->historia=$historia;
    }

    /**
     * Método SET para modificar la imagen del observatorio
     *
     * @param string $imagen Nueva imagen del observatorio
     * @return void No devuelve valor alguno
     */
    public function setImagenObservatorio($imagen) {
        $this->imagen=$imagen;
    }

    /**
     * Método SET para modificar la URL del observatorio
     *
     * @param string $url Nueva URL del observatorio
     * @return void No devuelve valor alguno
     */
    public function setUrlObservatorio($url) {
        $this->url=$url;
    }    

    // E) Defino los métodos estáticos de la clase Observatorio
    // RECUERDA: Sólo se implementan los estrictamentes necesarios para interactuar con el gestor de Jornadas.

    /**
     * Método estático que permite consultar datos de un observatorio
     *
     * @param string $codigo Código del observatorio del que se quiere consultar sus datos
     * @return Observatorio|null Devuelve un objeto observatorio si se ha encontrado en la base de datos
     *                           Devuelve nulo si el observatorio solicitado NO se ha encontrado en la base de datos
     */
    public static function consultarObservatorio($codigo): ?Observatorio
    {   
        // Construyo la sentencia SQL para recuperar a la jornada de la base de datos     
        $sql="SELECT * FROM pdaw_observatorios WHERE codigo=:codigo";
        // Ejecuto la sentencia SQL para recuperar a la jornada de la base de datos
        $res=Core::ejecutarSql($sql,[':codigo'=>$codigo]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo a la jornada recuperada de la base de datos
            return new Observatorio($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }    

    /**
     * Método estático para listar a todos las observatorios disponibles en la base de datos
     *
     * @return Array|null Devuelve un array asociativo con el listado completo de observatorios en la base de datos
     *                    Devuelve nulo si NO pudo obtnerse un listado completo de observatorios en la base de datos
     */
    public static function listarObservatorios(): ?Array {
        // Construyo la sentencia SQL para recuperar los observatorios de la base de datos     
        $sql="SELECT codigo, nombre, localidad, direccion FROM pdaw_observatorios";
        // Ejecuto la sentencia SQL para recuperar a los observatorios de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo a los observatorios recuperados de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }   

}

 ?>
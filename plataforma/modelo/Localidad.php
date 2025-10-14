<?php
/**
 * Clase auxiliar del modelo para trabajar con la tabla Localidades de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Localidades" de la
 * base de datos de la plataforma correplayas, correspondiente al modelo de patrón MVC. Lo
 * que pemrite asignar localidad a personas usuarias y observatorios de la plataforma. Además
 * supone el apoyo esencial para la funcioanlidad de intercambio asincrono de datos.
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
use \PDO;
use \PDOException;
use \correplayas\nucleo\Core;

/**
 * Clase auxiliar del modelo de datos para trabajar con Localidades
 */
class Localidad {

    // A) Defino los atributos de la clase auxiliar Localidad
    private $localidad="";
    private $provincia="";

    // B) Defino el constructor privado de la clase auxiliar Localidad
    public function __construct($localidad) {
        $this->localidad = $localidad['localidad'];
        $this->provincia = $localidad['provincia'];        
    }

    // C) Defino los métodos getter y setter de la clase auxiliar Localidad

    /**
     * Método GET para obtener el nombre de la localidad
     *
     * @return string|null Devuelve la localidad o nulo sino está establecida.
     */
    public function getLocalidad(): ?string {
        return $this->localidad;
    }

    /**
     * Método GET para obtener el nombre de la provincia asociadad a la localidad
     *
     * @return string|null Devuelve el nombre de la provincia asociada a la localidad
     *                     Nulo si no hay localidad establecida
     */
    public function getProvncia(): ?string {
        return $this->provincia;
    }

    // D) Defino los métodos estáticos de la clase auxiliar Localidad

    /**
     * Método éstatico para asignar una localidad a entidades de la plataforma que lo requieran
     *
     * @param String $localidad Nombre de la localidad que se desea recuperar
     * @return Localidad|null Devuelve un objeto Localidad con los datos recuperados
     *                        Devuelve nulo si no puedo recuperarse la localidad indicada por parámetro
     */
    public static function asignarLocalidad($localidad): ?Localidad {
        // Construyo la sentencia SQL para recuperar la localidad de la base de datos     
        $sql="SELECT * from pdaw_localidades where localidad=:localidad";
        // Ejecuto la sentencia SQL para recuperar a la localidad de la base de datos
        $res=Core::ejecutarSql($sql,[':localidad'=>$localidad]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo a la localidad recuperado de la base de datos
            return new Localidad($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * Método estático para obtener un listado con todas las localidades disponibles en la plataforma
     *
     * @return Array|null Devuelve el conjunto de localidades disponibles en la plataforma
     *                    Devuelve nulo cuando no es posible recuperar el conjunto de localidades disponibles.
     */
    public static function listarLocalidades(): ?Array {
        // Defino el array localidades que contendra a todas las disponibles para la plataforma
        $localidades = [];
        // Construyo la sentencia SQL para recuperar las localidades de la base de datos     
        $sql="SELECT localidad FROM pdaw_localidades WHERE NOT localidad='Demo'";
        // Ejecuto la sentencia SQL para recuperar las localidades de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Proceso los resultados para obtener las localidades disponibles en la plataforma
            foreach ($res as $localidad) {
                $localidades[] = $localidad['localidad'];
            }
            // Devuelvo el array con las localidades disponibles en la plataforma
            return $localidades;
        }
        else
            // De lo contario devuelvo un array vacio
            return [];
    }

}

?>
<?php
/**
 * Clase auxiliar del modelo para trabajar con la tabla Ordenes de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Ordenes" de la
 * base de datos de la plataforma correplayas, correspondiente al modelo de patrón MVC. Lo
 * que pemrite asignar orden a las aves registradas en la plataforma. Además supone el apoyo 
 * esencial para la funcioanlidad de intercambio asincrono de datos.
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
 * Clase auxiliar del modelo de datos para trabajar con Ordenes
 */
class Orden {

    // A) Defino los atributos de la clase auxiliar Orden
    private $codigoOrden;
    private $orden;

    // B) Defino el constructor privado de la clase auxiliar Orden
    public function __construct($orden) {
        $this->codigoOrden=$orden['codOrden'];
        $this->orden=filter_var($orden['orden'], FILTER_SANITIZE_NUMBER_INT);        
    }

    // C) Defino los métodos getter y setter de la clase auxiliar Orden

    /**
     * Método GET para obtener el código del orden en la aves
     *
     * @return integer Devuelve el código del orden en las aves
     */
    public function getCodigoOrden(): int {
        return (int) $this->codigoOrden;
    }

    /**
     * Método GET para obtener el nombre del orden en las aves
     *
     * @return String Devuelve el nombre del orden en las aves
     */
    public function getOrden(): String {
        return $this->orden;
    }

    // D) Defino los métodos estáticos de la clase auxiliar Orden    

    /**
     * Método éstatico para asignar un orden a entidades de la plataforma que lo requieran
     *
     * @param int $codOrden Código del orden que se desea recuperar
     * @return Orden|null Devuelve un objeto Orden con los datos recuperados
     *                    Devuelve nulo si no puedo recuperar el orden indicado por parámetro
     */
    public static function asignarOrden($codigoOrden): ?Orden { 
        // Construyo la sentencia SQL para recuperar el orden de la base de datos     
        $sql="SELECT * from pdaw_ordenes where codOrden=:codOrden";
        // Ejecuto la sentencia SQL para recuperar al orden de la base de datos
        $res=Core::ejecutarSql($sql,[':codOrden'=>$codigoOrden]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo al orden recuperado de la base de datos
            return new Orden($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;        
    }

    /**
     * Método estático para obtener un listado con todas las ordenes disponibles en la plataforma
     *
     * @return Array|null Devuelve un array asociativo con el listado completo de ordenes disponibles en la plataforma
     *                    Devuelve nulo cuando no es posible recuperar el conjunto de ordenes disponibles.
     */
    public static function listarOrdenes(): ?Array {
        // Construyo la sentencia SQL para recuperar las ordenes de la base de datos     
        $sql="SELECT codOrden, orden from pdaw_ordenes";
        // Ejecuto la sentencia SQL para recuperar las ordenes de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            return $res;
        }
        else
            // De lo contario devuelvo un nulo
            return null;
    }    

}

?>
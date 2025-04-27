<?php
/**
 * Clase auxiliar del modelo para trabajar con la tabla Familia de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Familias" de la
 * base de datos de la plataforma correplayas, correspondiente al modelo de patrón MVC. Lo
 * que pemrite asignar familia a las aves registradas en la plataforma. Además supone el 
 * apoyo esencial para la funcioanlidad de intercambio asincrono de datos.
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
 * Clase auxiliar del modelo de datos para trabajar con Familias
 */
class Familia {

    // A) Defino los atributos de la clase auxiliar Familia
    private $familia;
    private $descripcion;
    private $codOrden;
    
    
    // B) Defino el constructor privado de la clase auxiliar Familia
    public function __construct($familia) {        
        $this->familia=$familia['familia'];
        $this->descripcion=$familia['descripcion'];
        $this->codOrden=filter_var($familia['codOrden'], FILTER_SANITIZE_NUMBER_INT);
    }
        
    // C) Defino los métodos getter y setter de la clase auxiliar Familia

    /**
     * Método GET para obtener la familia de un ave registrada en la plataforma
     *
     * @return String Nombre de la familia de un ave
     */
    public function getFamilia(): String {
        return $this->familia;
    }

    /**
     * Método GET para obtener la descripción de la familia de un ave
     *
     * @return String Devuelve una descripción sobre la familia del ave
     */
    public function getDescripcion(): String {
        return $this->descripcion;
    }

    /**
     * Método GET para obtener el código del orden asociado a la familia del ave
     *
     * @return integer Devuelve el código del orden asopciado a la familia del ave
     */
    public function getCodigoOrden(): int {
        return (int) $this->codOrden;
    }

    // D) Defino los métodos estáticos de la clase auxiliar Familia    

    /**
     * Método éstatico para asignar una familia a entidades de la plataforma que lo requieran
     *
     * @param String $familia Nombre de la familia que se desea recuperar
     * @return Familia|null Devuelve un objeto Familia con los datos recuperados
     *                        Devuelve nulo si no puedo recuperar la indicada indicada por parámetro
     */
    public static function asignarFamilia($familia): ?Familia {
        // Construyo la sentencia SQL para recuperar la familia de la base de datos     
        $sql="SELECT * from pdaw_familias where familia=:familia";
        // Ejecuto la sentencia SQL para recuperar a la familia de la base de datos
        $res=Core::ejecutarSql($sql,[':familia'=>$familia]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo a la familia recuperada de la base de datos
            return new Familia($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * Método estático para obtener un listado con todas las familias disponibles en la plataforma
     *
     * @return Array|null Devuelve un array asociativo con el listado completo de familias disponibles en la plataforma
     *                    Devuelve nulo cuando no es posible recuperar el conjunto de familias disponibles.
     */
    public static function listarFamilias(): ?Array {
        // Construyo la sentencia SQL para recuperar las familias de la base de datos     
        $sql="SELECT familia from pdaw_familias";
        // Ejecuto la sentencia SQL para recuperar las familias de la base de datos
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
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
use \correplayas\modelo\Orden;

/**
 * Clase auxiliar del modelo de datos para trabajar con Familias
 */
class Familia {

    // A) Defino los atributos de la clase auxiliar Familia
    private $familia;
    private $descripcion;
    private Orden $orden;
    
    
    // B) Defino el constructor privado de la clase auxiliar Familia
    public function __construct($familia) {     
        // Compruebo si los datos de la familia del ave están establecidos
        if (isset($familia)) {
            // Los datos de la familia están establecidos. Entonces:
            // Incializo los atributos de Familia con dichos datos
            $this->familia=$familia['familia'];
            $this->descripcion=$familia['descripción'];
            $this->orden=Orden::asignarOrden(filter_var($familia['codOrden'], FILTER_SANITIZE_NUMBER_INT));    
        } else {
            // De lo contrario, inicializo Familia con datos por defecto
            $this->familia="Desconocida";
            $this->descripcion="Ninguna";
            $this->orden=Orden::asignarOrden(0);
        }
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
     * @return Orden Devuelve el código del orden asopciado a la familia del ave
     */
    public function getOrden(): Orden {
        return $this->orden;
    }

    // D) Defino los métodos estáticos de la clase auxiliar Familia    

    /**
     * Método éstatico para asignar una familia a entidades de la plataforma que lo requieran
     *
     * @param String $familia Nombre de la familia que se desea recuperar
     * @return Familia Devuelve un objeto Familia con los datos recuperados o vacío si no puedo hacerlo     
     */
    public static function asignarFamilia($familia): Familia {
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
            // De lo contario devolveré un objeto Familia con los atributos por defecto
            return new Familia([]);
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
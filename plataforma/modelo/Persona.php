<?php
/**
 * Clase auxiliar del modelo para trabajar con la tabla Personas de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Personas" de la base
 * de datos de la plataforma correplayas, correspondiente al modelo de patrón MVC. 
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
 *  Clase auxiliar del modelo de datos para trabajar con Personas
 */
class Persona {

    // A) Defino los atributos de la clase auxiliar Persona
    private $documento;
    private $tipo;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $email;
    private $telefono;
    private $direccion;
    private $localidad;
    private $codigoPostal;
    private $usuario;

    // B) Defino el constructor privado de la clase auxiliar Persona
    private function __construct($persona) {
        // Defino los atributos de la clase auxiliar Persona
        $this->documento=$persona['documento'];
        $this->tipo=$persona['tipo'];
        $this->nombre=$persona['nombre'];
        $this->apellido1=$persona['apellido1'];
        $this->apellido2=$persona['apellido2'];
        $this->email=$persona['email'];
        $this->telefono=$persona['telefono'];
        $this->direccion=$persona['direccion'];
        $this->localidad=$persona['localidad'];
        $this->codigoPostal=$persona['codigo_postal'];
        $this->usuario=$persona['usuario'];

    }

    // C) Defino los métodos propios de la clase auxiliar Persona


    // D) Defino los métodos getter y setter de la clase auxiliar Persona

    /**
     * Método GET para obtener el documento de identidad de la persona usuaria
     *
     * @return string Documento de identidad de la persona usuaria
     */
    public function getDocumento() {
        // Devuelvo el documento d eidentidad de la persona usuaria
        return $this->documento;
    }

    /**
     * Método GET para obtener el tipo de documento de identidad de la persona usuaria
     *
     * @return string Tipo de documento de identidad de la persona usuaria
     */
    public function getTipoDocumento() {
        // Devuelvo el tipo de documento d eidentidad de la persona usuaria
        return $this->tipo;
    }  
    
    /**
     * Método GET para obtener el nombre de la persona usuaria
     *
     * @return string Nombre de la persona usuaria
     */
    public function getNombrePersona() {
        // Devuelvo el nombre de la persona usuaria
        return $this->nombre;
    }

    /**
     * Método GET para obtener el primer apellido de la persona usuaria
     *
     * @return string Primer apellido de la persona usuaria
     */
    public function getPrimerApellido() {
        // Devuelvo el primer apellido de la persona usuaria
        return $this->apellido1;
    }

    /**
     * Método GET para obtener el segundo apellido de la persona usuaria
     *
     * @return string Segundo apellido d ela persona usuaria
     */
    public function getSegundoApellido() {
        // Devuelvo el segundo apellido de la persona usuaria
        return $this->apellido2;
    }
    
    /**
     * Método GET para obtener el email de la persona usuaria
     *
     * @return string Email de la persona usuaria
     */
    public function getEnailPersona() {
        // Devuelvo el email de la persona usuaria
        return $this->email;
    }     
    
    /**
     * Método SET para establcer un nuevo email a la persona usuaria
     *
     * @param string $email Nuevo email de la persona usuaria
     * @return void No devuelve valor alguno
     */
    public function setEmailPersona($email) {
        // Establezco el atributo Email de la persona usuaria
        $this->email = $email;
    }

    /**
     * Método GET para obtener el telefono de la persona usuaria
     *
     * @return string Telefono de la persona usuaria
     */
    public function getTelefonoPersona() {
        // Devuelvo el telefono de la persona usuaria
        return $this->telefono;
    }     
    
    /**
     * Método SET para establcer un nuevo telefono a la persona usuaria
     *
     * @param string $telefono Nuevo telefono de la persona usuaria
     * @return void No devuelve valor alguno
     */
    public function setTelefonoPersona($telefono) {
        // Establezco el atributo Telefono de la persona usuaria
        $this->telefono = $telefono;
    }
    
    /**
     * Método GET para obtener la dirección de la persona usuaria
     *
     * @return string Dirección de la persona usuaria
     */
    public function getDireccionPersona() {
        // Devuelvo la direccion de la persona usuaria
        return $this->direccion;
    }     
    
    /**
     * Método SET para establcer un nueva direccion a la persona usuaria
     *
     * @param string $direccion Nueva direccion de la persona usuaria
     * @return void No devuelve valor alguno
     */
    public function setDireccionPersona($direccion) {
        // Establezco el atributo Direccion de la persona usuaria
        $this->direccion = $direccion;
    }

    /**
     * Método GET para obtener la localidad de la persona usuaria
     *
     * @return string Localidad de la persona usuaria
     */
    public function getLocalidadPersona() {
        // Devuelvo la localidad de la persona usuaria
        return $this->localidad;
    }     
    
    /**
     * Método SET para establcer un nueva localidad a la persona usuaria
     *
     * @param string $localidad Nueva localidad de la persona usuaria
     * @return void No devuelve valor alguno
     */
    public function setLocalidadPersona($localidad) {
        // Establezco el atributo Localidad de la persona usuaria
        $this->localidad = $localidad;
    }

    /**
     * Método GET para obtener el código postal de la persona usuaria
     *
     * @return string Código postal de la persona usuaria
     */
    public function getCodigoPostalPersona() {
        // Devuelvo el codigo postal de la persona usuaria
        return $this->codigoPostal;
    }     
    
    /**
     * Método SET para establcer un nuevo codigo postal a la persona usuaria
     *
     * @param string $codigoPostal Nuevo codigo postal de la persona usuaria
     * @return void No devuelve valor alguno
     */
    public function setCodigoPostalPersona($codigoPostal) {
        // Establezco el atributo Direccion de la persona usuaria
        $this->codigoPostal = $codigoPostal;
    }

    /**
     * Método GET para obtener el identificador de la persona usuaria en la plataforma
     *
     * @return string Identificador de la persona usuaria en la plataforma
     */
    public function getIdentificadorPersona() {
        // Devuelvo el identificador de la persona usuaria en la plataforma
        return $this->usuario;
    }   

    // E) Defino los métodos estáticos de la clase auxiliar Persona 

    /**
     * Método que realiza la identificación de un usuario como persona
     *
     * @param string $hashUsuario Código del usuario al que se desea identificar como persona
     * @return Persona|null Devuelve un objeto Persona con todos sus datos si es identificado
     *                      Devuelve nulo si no es posibler autenticar al usuario indicado por parámetros
     */
    public static function identificarPersona($hashUsuario): ?Persona
    {   
        // Construyo la sentencia SQL para recuperar al usuario de la base de datos     
        $sql="SELECT * from pdaw_personas where usuario=:usuario";
        // Ejecuto la sentencia SQL para recuperar al usuario de la base de datos
        $res=Core::ejecutarSql($sql,[':usuario'=>$hashUsuario]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo al usuario recuperado de la base de datos
            return new Persona($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * Método estático para crear una nueva persona usuaria en la plataforma
     *
     * @param Array $datos Conjunto de datos d ela persna usuario a cerar en la plataforma
     * @return void No devuelve valor alguno
     */
    public static function crearPersona ($datos)
    {
        // Construyo la sentencia SQL para añadir un nuevo usuario a la tabla Usuarios de la base datos
        $sql="INSERT INTO pdaw_personas (documento, tipo, nombre, apellido1, apellido2, email, telefono
        , direccion, localidad, codigo_postal, usuario) VALUES (:documento, :tipo, :nombre, :apellido1
        , :apellido2, :email, :telefono, :direccion, :localidad, :codigoPostal, :usuario)";
        // Si al ejecutar la sentencia SQL me devuelve uno
        if (Core::ejecutarSql($sql,$datos)===1)
        {
            // Entonces devuelvo un objeto Usuario con su datos recientemente creados.
            return true;
        }        
        // De lo contrario devuelvo nulo porque no se pudo añadir al nuuevo usuario
        else return false;
    }    

}

<?php
/**
 * Clase del modelo para trabajar con la tabla Usuarios de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Usuarios" de la base
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
 * Clase del modelo de datos para trabajar con Usuarios
 */
class Usuario {

    // A) Defino los atributos de la clase Usuario
    private $codigo;
    private $usuario;
    private $estado;
    private $rol;

    // B) Defino el constructor privado de la clase Usuario
    private function __construct($usuario) {
        var_dump($usuario);
        // Defino los atributos de la clase Usuario

        $this->codigo=$usuario['codigo'];
        $this->usuario=$usuario['nombre'];
        $this->estado=$usuario['estado'];
        $this->rol=$usuario['rol'];

    }

    // C) Defino los métodos propios de la clase Usuario

    public function modificarPassword($passwordActual, $passwordNueva)
    {
        // $sql="UPDATE usuarios SET password=SHA2(CONCAT(:username,:newpassword),256) WHERE username=:username and password=SHA2(CONCAT(:username,:currentpassword),256)";
        // return DB::doSql($sql,[':usuario'=>$this->usuario,':currentpassword'=>$currentpassword,':newpassword'=>$newpassword]);        
    }
    

    // D) Defino los métodos getter y setter de la clase Usuario

    /**
     * Método GET para obtener el código del usuario.
     *
     * @return string Código del Usuario 
     */
    public function getCodigo() {
        // Devuelvo el valor del atributo que contiene el código de la clase Usuario.
        return $this->codigo;
    }

    /**
     * Método GET para obtener el nombre del usuario.
     *
     * @return string Nombre del usuario
     */
    public function getUsuario() {
        // Devuelvo el valor del atributo que contiene el nombre de usuario.
        return $this->usuario;
    }

    /**
     * Método GET para obtener el estado de un usuario registrado en la plataforma.
     *
     * @return string Estado de un usuario registrado en la plataforma
     */
    public function getEstado() {
        // Devuelvo el valor del atributo que contiene el estado de un usuario
        return $this->estado;
    }

    /**
     * Método SET para establecer el estado de un usuario registrado en la plataforma
     *
     * @param string $estado Nuevo estado del usuario registrado en la plataforma
     * @return void No devuelve nada
     */
    public function setEstado($estado) {
        // Establezco el valor del atributo que contiene el estado de un usuario
        $this->estado=$estado;
    }

    /**
     * Método GET para obtener el rol del usuario en la plataforma.
     *
     * @return string Rol de usuario en la plataforma
     */
    public function getRol() {
        // Devuelvo el valor del atributo que contiene el rol del usuario.
        return $this->rol;
    }

    /**
     * Método SET para establecer un nuevo rol de usuario emn la plataforma
     *
     * @param string $rol Nuevo rol del usuario en la plataforma
     * @return void
     */
    public function setRol($rol) {
        // Establezco el rol del usuario en la plataforma.
        $this->rol=$rol;
    }

    // E) Defino los métodos estáticos de la clase Usuario

    /**
     * Método que realiza la autenticación de un usuario en la plataforma
     *
     * @param string $usuario Nombre de usuario con que se desea autenticarse en la plataforma
     * @param string $password Contraseña del usuario que desea autenticarse en la paltaforma
     * @return Usuario|null Devuelve un objeto Usuario con todos sus datos si es auntenticado.
     *                      Devuelve nulo si no es posibler autenticar al usuario indicado por parámetros
     */
    public static function autenticarUsuario($usuario, $password): ?Usuario
    {   
        // Construyo la sentencia SQL para recuperar al usuario de la base de datos     
        $sql="SELECT * from pdaw_usuarios where nombre=:usuario and contrasenya=SHA2(CONCAT(:usuario,:password),256)";
        // Ejecuto la sentencia SQL para recuperar al usuario de la base de datos
        $res=Core::ejecutarSql($sql,[':usuario'=>$usuario,':password'=>$password]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo al usuario recuperado de la base de datos
            return new Usuario($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * Método estático para crear un nuevo usuario en la plataforma
     *
     * @param Array $datos Conjunto de datos del usuario a crear en la plataforma
     * @return void No devuelve valor alguno
     */
    public static function crearUsuario ($datos)
    {
        // Construyo la sentencia SQL para añadir un nuevo usuario a la tabla Usuarios de la base datos
        $sql="INSERT INTO pdaw_usuarios (codigo, nombre, contrasenya, estado, rol) VALUES (:codigo, :nombre, :contrasenya, :estado, :rol)";
        // Si al ejecutar la sentencia SQL me devuelve uno
        if (Core::ejecutarSql($sql,$datos)===1)
        {
            
            // Estandarizo 

            // Entonces devuelvo un objeto Usuario con su datos recientemente creados.
            return true;
        }        
        // De lo contrario devuelvo nulo porque no se pudo añadir al nuuevo usuario
        else return false;
    }

}

?>
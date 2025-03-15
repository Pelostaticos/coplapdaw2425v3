<?php
/**
 * Clase auxiliar del modelo para trabajar con la tabla Roles de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Roles" de la base
 * de datos de la plataforma correplayas, correspondiente al modelo de patrón MVC. Esta
 * pemrite asignarle a los usuarios de la plataforma los permisos de acceso a las diver-
 * sas acciones que pueden ejecutar en la misma.
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
 * Clase auxiliar del modelo de datos para trabajar con Roles
 */
class Rol {

    // A) Defino los atributos de la clase auxiliar Rol
    private $permisos;

    // B) Defino el constructor privado de la clase Usuario
    private function __construct($rol) {
        // Inicializo el atributo permisos con el valor del paŕametro rol.
        $this->permisos=$rol;
        // Eliminio del atributo permisos el nombre del rol asociado.
        unset($this->permisos['rol']);
    }

    // C) Defino los métodos getter y setter de la clase auxiliar Rol

    /**
     * Método GET para obtener el permiso para el acceso al perfil de un usuario (B2)
     *
     * @return boolean Estado del permiso para consultar el perfil de usuario.
     */
    public function getPermisoConsultaUsuario() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso1 de la tabla Roles.
        return $this->permisos['permiso1'];
    }

    /**
     * Método GET para obtener el permiso para actualización del perfil de un usuario (B3.1)
     *
     * @return boolean Estado del permiso para actualización del perfil de un usuario
     */
    public function getPermisoActualizacionUsuario() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso2 de la tabla Roles.
        return $this->permisos['permiso2'];
    }

     /**
     * Método GET para obtener el permiso para cambio contraseña del perfil de un usuario (B3.2)
     *
     * @return boolean Estado del permiso para cambio contraseña del perfil de un usuario
     */
    public function getPermisoCambioPasswordUsuario() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso3 de la tabla Roles.
        return $this->permisos['permiso3'];
    }   

     /**
     * Método GET para obtener el permiso para desactivar el perfil de un usuario (B3.3)
     *
     * @return boolean Estado del permiso para desactivar el perfil de un usuario
     */
    public function getPermisoDesactivarUsuario() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso4 de la tabla Roles.
        return $this->permisos['permiso4'];
    }   

     /**
     * Método GET para obtener el permiso para activar el perfil de un usuario (B3.4)
     *
     * @return boolean Estado del permiso para activar el perfil de un usuario
     */
    public function getPermisoActivarUsuario() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso5 de la tabla Roles.
        return $this->permisos['permiso5'];
    }   

     /**
     * Método GET para obtener el permiso para eliminar el perfil de un usuario (B4)
     *
     * @return boolean Estado del permiso para eliminar el perfil de un usuario
     */
    public function getPermisoElimianrUsuario() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso6 de la tabla Roles.
        return $this->permisos['permiso6'];
    }   

     /**
     * Método GET para obtener el permiso para listar usuarios registrados en la plataforma (B5)
     *
     * @return boolean Estado del permiso para listar usuarios registrados en la plataforma
     */
    public function getPermisoListarUsuarios() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso7 de la tabla Roles.
        return $this->permisos['permiso7'];
    }       

     /**
     * Método GET para obtener el permiso para filtrar usuarios registrados en la plataforma (B6)
     *
     * @return boolean Estado del permiso para filtrar usuarios registrados en la plataforma
     */
    public function getPermisoFiltrarUsuarios() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso8 de la tabla Roles.
        return $this->permisos['permiso8'];
    }        
    
     /**
     * Método GET para obtener el permiso para registrar jornada censal en la plataforma (C1)
     *
     * @return boolean Estado del permiso para registrar jornada censal en la plataforma
     */
    public function getPermisoRegistrarJornada() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso9 de la tabla Roles.
        return $this->permisos['permiso9'];
    }      

     /**
     * Método GET para obtener el permiso para consultar jornada censal en la plataforma (C2)
     *
     * @return boolean Estado del permiso para consultar jornada censal en la plataforma
     */
    public function getPermisoConsultarJornada() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso10 de la tabla Roles.
        return $this->permisos['permiso10'];
    }  
    
     /**
     * Método GET para obtener el permiso para actualizar jornada censal en la plataforma (C3)
     *
     * @return boolean Estado del permiso para actualizar jornada censal en la plataforma
     */
    public function getPermisoActualizarJornada() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso11 de la tabla Roles.
        return $this->permisos['permiso11'];
    }
    
     /**
     * Método GET para obtener el permiso para eliminar jornada censal en la plataforma (C4)
     *
     * @return boolean Estado del permiso para eliminar jornada censal en la plataforma
     */
    public function getPermisoEliminarJornada() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso12 de la tabla Roles.
        return $this->permisos['permiso12'];
    }      

     /**
     * Método GET para obtener el permiso para listar jornadas censales en la plataforma (C5)
     *
     * @return boolean Estado del permiso para listar jornadas censales en la plataforma
     */
    public function getPermisoListarJornadas() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso13 de la tabla Roles.
        return $this->permisos['permiso13'];
    }      

     /**
     * Método GET para obtener el permiso para filtrar jornadas censales en la plataforma (C6)
     *
     * @return boolean Estado del permiso para filtrar jornadas censales en la plataforma
     */
    public function getPermisoFiltrarJornadas() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso14 de la tabla Roles.
        return $this->permisos['permiso14'];
    }      



    // D) Defino los métodos estáticos de la clase auxiliar Rol
    
    /**
     * Método estático para asignarle a un usuario los permisos en la plataforma conforme a su rol
     *
     * @param string $rol Rol de usuario al que recuperar sus permisos en la plataforma
     * @return Rol|null Objeto Rol con los permisos del usuario si la ejecución devuelve array con un elemento
     *                  Nulo si la ejecución no devuelve nada
     */
    public static function asignarPermisos($rol): ?Rol
    {   
        // Construyo la sentencia SQL para recuperar al usuario de la base de datos     
        $sql="SELECT * from pdaw_roles where rol=:rol";
        // Ejecuto la sentencia SQL para recuperar al usuario de la base de datos
        $res=Core::ejecutarSql($sql,[':rol'=>$rol]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo al usuario recuperado de la base de datos
            return new Rol($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }    

    /**
     * Método estático para obtener los roles admitidos por la plataforma
     *
     * @return Array Listado con todos los roles disponibles en la plataforma
     */
    public static function listarRoles(): ?Array{
        // Defino el array roles que contendra todos los disponibles para la paltaforma
        $roles = [];
        // Construyo la sentencia SQL para recuperar al usuario de la base de datos     
        $sql="SELECT rol from pdaw_roles";
        // Ejecuto la sentencia SQL para recuperar al usuario de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Proceso los resultados para obtener los roles disponibles en la plataforma
            foreach ($res as $rol) {
                $roles=[] = $rol['rol'];
            }
            // Devuelvo el array con los roles disponibles en la plataforma
            return $roles;
        }
        else
            // De lo contario devuelvo un array vacio
            return [];
    }

}

 ?>
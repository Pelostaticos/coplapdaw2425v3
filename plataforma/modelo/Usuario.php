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
        // Defino los atributos de la clase Usuario
        $this->codigo=$usuario['codigo'];
        $this->usuario=$usuario['nombre'];
        $this->estado=$usuario['estado'];
        $this->rol=$usuario['rol'];

    }

    // C) Defino los métodos propios de la clase Usuario

    /**
    * Método para actualizar los datos del usuario en la base de datos
    *
    * @param Array $datos Conjunto de datos para actualizar al usuario
    * @return boolean Devuelve verdadero si se actualizo al usuario
    *                 Devuelve falso si no se pudo actualizar al usuario  
    */
    public function actualizarUsuario($datos): ?bool {       
        // Construyo la sentencia SQL para actualizar al usuario de la base de datos     
        $sql="UPDATE pdaw_usuarios SET estado=:estado, rol=:rol where codigo=:codigo";
        // Ejecuto la sentencia SQL para actualizar al usuario de la base de datos
        $res=Core::ejecutarSql($sql,$datos);
        // Si el resultado es mayor de cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que el usuario se ha actualizado
            return true;
        }
        else
            // De lo contario devuelvo falso para indicar que el usuario no se ha actualizado
            return false;
    }

     /**
      * Método para cambiar la contraseña del usuario en la base de datos
      *
      * @param Array $datos Conjunto de datos para actualizar contraseña al usuario
      * @return boolean Devuelve verdadero si se actualizo contraseña al usuario
      *                 Devuelve falso si no se pudo actualizar contraseña al usuario  
      */
    public function cambiarContraseñaUsuario($datos) {
        // Construyo la sentencia SQL para actualizar contraseña del usuario de la base de datos     
        $sql="UPDATE pdaw_usuarios SET contrasenya=:contrasenya where codigo=:codigo";
        // Ejecuto la sentencia SQL para actualizar contraseña del usuario de la base de datos
        $res=Core::ejecutarSql($sql,$datos);
        // Si el resultado es mayor que cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que la contraseña de usuario se ha actualizado
            return true;
        }
        else
            // De lo contario devuelvo falso para indicar que la contraseña de usuario NO se ha actualizado
            return false;
    }

    /**
     * Método para eliminar a un usuario de la base de datos
     *
     * @param Array $codigo Conjunto de datos requeridos para eliminar al usuario
     * @return boolean Devuelve verdadero si se eliminó al usuario d ela base de datos
     *                 Devuelve falso si NO se eliminó al usuario de la base de datos
     */
    public function eliminarUsuario($codigo): ?bool {
        // Construyo la sentencia SQL para eliminar al usuario de la base de datos     
        $sql="DELETE FROM pdaw_usuarios WHERE codigo=:codigo";
        // Ejecuto la sentencia SQL para eliminar al usuario de la base de datos
        $res=Core::ejecutarSql($sql,$codigo);
        // Si el resultado es mayor que cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que el usuario se ha eliminado
            return true;
        }
        else
            // De lo contario devuelvo falso para indicar que el usuario NO se ha eliminado
            return false;
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
     * Método estático que permite consultar datos de un usuario
     *
     * @param string $codigo código de usuario del que se quiere consultar sus datos
     * @return Usuario|null Devuelve un objeto usuario si se ha encontrado en la base de datos
     *                      Devuelve nulo si el usuario solicitado NO se ha encontrado en la base de datos
     */
    public static function consultarUsuario($codigo): ?Usuario
    {   
        // Construyo la sentencia SQL para recuperar al usuario de la base de datos     
        $sql="SELECT * from pdaw_usuarios where codigo=:codigo";
        // Ejecuto la sentencia SQL para recuperar al usuario de la base de datos
        $res=Core::ejecutarSql($sql,[':codigo'=>$codigo]);
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
     * Método estático para crear un nuevo usuario en la base de datos
     *
     * @param Array $datos Conjunto de datos del usuario a crear en la base de datos
     * @return boolean Devuelve verdadero si el nuevo usuario se creó
     *                 Devuelve falso si el nuevo usuario NO se creó
     */
    public static function crearUsuario($datos): ?bool
    {
        // Construyo la sentencia SQL para añadir un nuevo usuario a la tabla Usuarios de la base datos
        $sql="INSERT INTO pdaw_usuarios (codigo, nombre, contrasenya, estado, rol) VALUES (:codigo, :nombre, :contrasenya, :estado, :rol)";
        // Si al ejecutar la sentencia SQL me devuelve uno
        if (Core::ejecutarSql($sql,$datos)===1)
        {
            // Entonces devuelvo un objeto Usuario con su datos recientemente creados.
            return true;
        }        
        // De lo contrario devuelvo nulo porque no se pudo añadir al nuuevo usuario
        else return false;
    }

    /**
     * Método estático para listar a todos los usuarios disponibles en la base de datos
     *
     * @return Array|null Devuelve un array asociativo con el listado completo de usuarios en la base de datos
     *                    Devuelve nulo si no pudo obtnerse un listado completo de usuarios en la base de datos
     */
    public static function listarUsuarios(): ?Array {
        // Construyo la sentencia SQL para recuperar al usuario de la base de datos     
        $sql="SELECT u.codigo as hashusuario, u.nombre as usuario, CONCAT(p.apellido1, ' ', p.apellido2, ', ', p.nombre) as nombre, u.estado as estado, u.rol as rol  FROM pdaw_usuarios u 
            LEFT JOIN pdaw_personas p ON u.codigo=p.usuario";
        // Ejecuto la sentencia SQL para recuperar al usuario de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo al usuario recuperado de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * Método estático para buscar Usuarios en la base de datos.
     *
     * @param string $busqueda
     * @param string $ordenarPor
     * @param string $orden
     * @return Array|null Devuelve un array con los resultados de la búsqueda de Usuarios
     *                    Devuelve nulo si el criterio de búsqueda no ha encontrado Usuarios
     */
    public static function buscarUsuarios($busqueda, $ordenarPor, $orden) {

        // Defino las columnas de busqueda para encontrar usuarios
        $columnas = ['u.nombre', 'p.nombre', 'p.apellido1', 'p.apellido2', 'u.estado', 'u.rol'];

        // Defino una array vacio en donde generar las condiciones de búsqueda
        $condiciones = [];

        // Defino un array asociativo con los parámetros de busqueda
        $parametros = [];

        // Genero las condiciones de búsqueda para encontrar Usuarios.
        foreach($columnas as $columna) {
            $parametro = str_replace('.','',$columna);
            $parametros[":".$parametro] = "%$busqueda%";
            $condiciones[] = "$columna LIKE :$parametro";                      
        }

        // Construyo la sentencia SQL para realizar la búsqueda de Usuarios
        $sql="SELECT u.codigo as hashusuario, u.nombre as usuario, CONCAT(p.apellido1, ' ', p.apellido2, ', ', p.nombre) as nombre, u.estado as estado, u.rol as rol  FROM pdaw_usuarios u 
            LEFT JOIN pdaw_personas p ON u.codigo=p.usuario";

        // Añado las condiciones de búsqueda a la sentencia SQL anterior
        if (!empty($condiciones)) {
            // Genero la cadena completa con todas las condiciones de búsqueda SQL.
            $sql .= " WHERE " . implode(" OR ", $condiciones);
        }

        // Añado la funcionalidad para ordenar el resultado de la búsqueda
        $columnasPermitidas = ['usuario', 'nombre', 'estado', 'rol'];
        $ordenesPemritidos = ['ASC', 'DESC'];

        if (in_array($ordenarPor, $columnasPermitidas) && in_array($orden, $ordenesPemritidos)) {
            $sql .= " ORDER BY $ordenarPor $orden";
        }
        // var_dump($condiciones);
        // var_dump($parametros);
        // echo $busqueda . " - " . $ordenarPor . " -  " . $orden . "- " . $sql;
        // exit;
        // Ejecuto la sentencia SQL para recuperar a los usuario de la base de datos que coincidan el criterio de búsqueda
        $res=Core::ejecutarSql($sql, $parametros);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo al usuario recuperado de la base de datos
            return $res;
        }
        else {
            // De lo contario devolveré nulo
            return null;
        }
        
    }

}

/* OBSERVACIONES: He observado que no he implementado correctamente los métodos de objeto eliminar, 
actualizar y cambio de contraseña del usuarios ya que reciben como parámetros datos para ejecutar 
la acción, y al ser un método de objeto pueden tomar estos datos de los propios atributos de objeto
y a partir de ellos construir el array asociativo con los parámetros de consulta SQL preparada. No
obstante, debido a plazo de tiempo justo que dispongo, la corrección de esto lo hare por los otros
modelos de la aplicación web: Jornada y Participante. */

?>
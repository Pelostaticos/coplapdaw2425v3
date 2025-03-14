<?php

/**
 * Clase del núcleo de la plataforma correplayas
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene la funciones esenciales para el funcionamiento de la palatforma web: Conexión con base
 * de datos, envío de correos electrónico, registro de usuarios, inicio y cierre de sesión. Testeo
 * del estado de las cuentas de usuario registradas en la plataforma.
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
use PDO;
use PDOException;
use correplayas\excepciones\AppException;

// 2º) Defino la clase del nucleo de la plataforma correplayas
class Core {

    // Bloque-A: Definición de atributos de la clase.
    private static $connDB=null;

    // Bloque-B: Base de datos.

    /**
     * Método estático para abrir una conexión con la base de datos
     *
     * @return mixed Devuelve la conexión con la base de datos o nulo si hay errores
     * @throws AppException Lanza el código de excepción correspondiente por fallo al abrir conexión con base de datos.
     */
    public static function abrirConexionDB ()
    {
        if (!(static::$conn instanceof \PDO))
        {            
            try {
                static::$conn = new \PDO(\DB_DSN, \DB_USER, \DB_PASSWD, 
                    array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            } 
            catch (\PDOException $e)
            {
                static::$conn=false;
                throw new AppException
                    ('Error DB. No se puede continuar. Revisa el valor de las constantes DB_USER y DB_PASSWD en el archivo conf.php.',
                      AppException::DB_UNABLE_TO_CONNECT);                                
            }

        }
        return static::$conn;
    }     

    /**
     * Método estático para cerrar la conexión con la base de datos
     */

    public static function cerarConexionDB()
    {
        static::$conn=null;
    }

    /**
     * Método estático para ejecutar una sentencia SQL (Conforme sentencias preparadas PDO)
     *
     * @param $sql sentencia SQL (Conforme a PDO Prepared Statement)
     * @param array $data array asociativo con los datos a reemplazar en la consulta (conforme a PDO Prepared Statement)
     * @return mixed Si la consulta es tipo SELECT se obtendrá un array asociativo con todos los registros
     *               Si la consulta es tipo INSERT/UPDATE/DELETE se obtendrá el número de registros afectados.
     * @throws AppException Si algo en la consulta va mal eleva una excepción tipo AppException con
     * uno de los códigos disponibles en función del problema producido.
     */
    public static function doSQL($sql, $datos = [])
    {
        $ret = false;
        $pdo = self::abrirConexionDB();
        if (!$pdo) throw new AppException('Error DB: no se puede conectar con la base de datos',
                                          AppException::DB_NOT_CONNECTED);
        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($datos)) {
                if (preg_match('/^\s*SELECT\s/i', $sql))
                    $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                else
                    $ret = $stmt->rowCount();
            }
            else
                throw new AppException('Error DB: Fallo al ejecutar la consulta SQL.',
                    AppException::DB_QUERY_EXECUTION_FAILURE
                );
        } catch (\PDOException $ex) {            
            if ($ex->getCode()==='23000')
            {
                throw new AppException('Error DB: la consulta realizada incumple las restricciones de la base de datos.',
                    AppException::DB_CONSTRAINT_VIOLATION_IN_QUERY);
            }   
            throw new AppException('Error DB: error en la consulta.',
                    AppException::DB_ERROR_IN_QUERY);            
        }
        return $ret;
    }

    // Bloque-C: Correo electrónico.

    // Bloque-D: Control de acceso a la plataforma.
    
    /**
     * Método estático que muestra la vista de inicio de sesión al usuario.
     *
     * @param Smarty $smarty Contiene el objeto del motor del plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarInicioSesion($smarty) {
        // Asigno las variables de la plantilla de inicio de seesión
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        // Muestro la plantilla de inicio de sesión
        $smarty->display('comunes/login.tpl');
    }


    public static function iniciarSesion() {

    }

    /**
     * Método estático que muestra la vista de cierre de sesión al usuario.
     *
     * @param Smarty $smarty Contiene el objeto del motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarCierreSesion($smarty) {
        // Asigno las variables de la plantilla de cierre de sesión
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        // Muestro la plantilla del cierre de sesión
        $smarty->display('comunes/logout.tpl');
    }

    public static function cerrarSesion() {

    }

    /**
     * Método estático que muestra la vista del registro de un nuevo voluntario
     *
     * @param Smarty $smarty Contiene el objeto del motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */
    public static function mostrarRegistroVoluntario($smarty) {
        // Asigno las variables de la plantilla de registro de voluntario
        $smarty->assign('usuario', 'Pelostaticos');
        $smarty->assign('anyo', date('Y'));
        // Muestro la plantilla para el registro de un nuevo voluntario
        $smarty->display('comunes/signup.tpl');        
    }

    public static function registrarVoluntario() {

    }

    // Bloque-E: Ayuda de la plataforma.


}




 ?>
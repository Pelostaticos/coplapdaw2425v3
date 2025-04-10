<?php

/**
 * Clase del modelo para trabajar con la tabla Jornadas de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Jornadas" de la base
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
use \correplayas\nucleo\Core;

/**
 * Clase del modelo de datos para trabajar con Jornadas
 */
class Jornada {

    // A) Defino los atributos de la clase Jornadas
    private $idJornada;
    private $titulo;
    private $fecha;
    private $horaInicio;
    private $horaFin;
    private $informacion;
    private $estado;
    private $asistencia;
    private $observatorio;

    // B) Defino el constructor privado de la clase Jornada
    private function __construct($jornada) {
        // Defino los atributos de la clase Jornada
        $this->idJornada=$jornada['id_jornada'];
        $this->titulo=$jornada['titulo'];
        $this->fecha=$jornada['fecha'];
        $this->horaInicio=$jornada['hora_inicio'];
        $this->horaFin=$jornada['hora_fin'];
        $this->informacion=$jornada['informacion'];
        $this->estado=$jornada['estado'];
        $this->asistencia=$jornada['asistencia'];
        $this->observatorio=$jornada['observatorio'];
    }

    // C) Defino los métodos propios de la clase Jornada

    /**
    * Método para actualizar los datos de una jornada en la base de datos
    *
    * @return boolean Devuelve verdadero si se actualizo al usuario
    *                 Devuelve falso si no se pudo actualizar al usuario  
    */
    public function actualizarJornada(): ?bool {       
        // Construyo la sentencia SQL para actualizar al usuario de la base de datos     
        $sql="UPDATE pdaw_jornadas SET hora_inicio=:horaInicio, hora_fin=:horaFin, informacion=:informacion,
            estado=:estado, asistencia:asistencia WHERE id_jornada=:idJornada";
        // Preparo los datos de la jornada a actualizar en la base de datos
        $datos = [':horaInicio' => $this->horaInicio, ':horaFin' => $this->horaFin, ':informacion' => $this->informacion,
            ':estado' => $this->estado, ':asistencia' => $this->asistencia, ':idJornada' => $this->idJornada];
        // Ejecuto la sentencia SQL para actualizar al usuario de la base de datos
        $res=Core::ejecutarSql($sql,$datos);
        // Si el resultado es mayor de cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que la jornada se ha actualizado correctamente
            return true;
        }
        else {
            // De lo contario devuelvo falso para indicar que la jornada no se ha actualizado correctamente
            return false;
        }
    }
    
    /**
     * Método para eliminar a una jornada de la base de datos
     *
     * @return boolean Devuelve verdadero si se eliminó la jornada de la base de datos
     *                 Devuelve falso si NO se eliminó la jornada de la base de datos
     */
    public function eliminarJornada(): ?bool {
        // Construyo la sentencia SQL para eliminar al usuario de la base de datos     
        $sql="DELETE FROM pdaw_jornadas WHERE id_jornada=:idJornada";
        // Preparo el código de la jornada que se desea eliminar de la base de datos
        $codigo = [':idJornada' => $this->idJornada];
        // Ejecuto la sentencia SQL para eliminar a la jornada de la base de datos
        $res=Core::ejecutarSql($sql,$codigo);
        // Si el resultado es mayor que cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que la jornada se ha eliminado correctamente
            return true;
        }
        else
            // De lo contario devuelvo falso para indicar que la jornada NO se ha eliminado correctamente
            return false;
    }    

    // D) Defino los métodos getter y setter de la clase Jornada

    /**
     * Método GET para obtener el identificador único de la jornada
     *
     * @return unsigned Devuelve el identificador único de la jornada
     */
    public function getIdJornada() {
        return $this->idJornada;
    }

    /**
     * Método GET para obtener el titulo de la jornada
     *
     * @return string Devuelve el titulo único de la jornada
     */
    public function getTituloJornada() {
        return $this->titulo;
    }

    /**
     * Método GET para obtener la fecha de la jornada
     *
     * @return string Devuelve la fecha de la jornada
     */
    public function getFechaJornada() {
        return $this->fecha;
    }    

    /**
     * Método GET para obtener la hora de inicio de la jornada
     *
     * @return string Devuelve la hora de inicio de la jornada
     */
    public function getHoraInicioJornada() {
        return $this->horaInicio;
    }  

    /**
     * Método GET para obtener la hora de fin de la jornada
     *
     * @return string Devuelve la hra de fin de la jornada
     */
    public function getHoraFinJornada() {
        return $this->horaFin;
    }

    /**
     * Método GET para obtener la informacion de la jornada
     *
     * @return string Devuelve la informacion de la jornada
     */
    public function getInformacionJornada() {
        return $this->informacion;
    }

    /**
     * Método GET para obtener el estado de la jornada
     *
     * @return string Devuelve el estado de la jornada
     */
    public function getEstadoJornada() {
        return $this->estado;
    }
    
    /**
     * Método GET para obtener el estado del control de asistencia de la jornada
     *
     * @return string Devuelve el estado del control de asistencia fecha de la jornada
     */
    public function getControlAsistenciaJornada() {
        return $this->asistencia;
    }

    /**
     * Método GET para obtener el identificador del observatorio de la jornada
     *
     * @return string Devuelve el identificador del observatorio fecha de la jornada
     */
    public function getIdObservatorioJornada() {
        return $this->observatorio;
    }
    
    /**
     * Método SET para establecer una nueva hora de inicio de la jornada
     *
     * @param string $horaInicio Nueva hora de inicio de la jornada que se desea establecer
     * @return void No devuelve valor alguno
     */
    public function setHoraInicioJornada($horaInicio) {
        $this->horaInicio=$horaInicio;
    }

    /**
     * Método SET para establecer una nueva hora de finde la jornada
     *
     * @param string $horaFin Nueva hora de fin de la jornada que se desea establecer
     * @return void No devuelve valor alguno
     */
    public function setHoraFinJornada($horaFin) {
        $this->horaFin=$horaFin;
    }    

    /**
     * Método SET para establecer una nueva información sobre la jornada
     *
     * @param string $informacion Nueva información sobre la jornada que se desea establecer
     * @return void No devuelve valor alguno
     */
    public function setInformacionJornada($informacion) {
        $this->informacion=$informacion;
    }    

    /**
     * Método SET para establecer un nuevo estado de la jornada
     *
     * @param string $estado Nuevo estado de la jornada que se desea establecer
     * @return void No devuelve valor alguno
     */
    public function setEstadoJornada($estado) {
        $this->estado=$estado;
    }

    /**
     * Método SET para establecer el control de asistencia de la jornada
     *
     * @param string $asistencia Nuevo estado del control de asistencia de la jornada que se desea establecer
     * @return void No devuelve valor alguno
     */
    public function setControlAsistenciaJornada($asistencia) {
        $this->asistencia=$asistencia;
    }        

    // E) Defino los métodos estáticos de la clase Jornada

    /**
     * Método estático para crear una nueva jornada en la base de datos
     *
     * @param Array $datos Array asociativo con los datos a insertar de la nueva jornada en la base de datos
     * @return boolean Devuelve verdadero si la jornada se creó correctamente
     *                 Devuelve falso si la jornada no pudo crearse correctamente
     */
    public static function crearJornada($datos): ?bool
    {       
        // Construyo la sentencia SQL para añadir una nueva jornada a la tabla Jornadas de la base datos
        $sql="INSERT INTO pdaw_jornadas (titulo, fecha, hora_inicio, hora_fin,
            informacion, estado, asistencia, observatorio) VALUES (:titulo, :fecha, :horaInicio, :horaFin,
            :informacion, :estado, :asistencia, :observatorio)";
        // Si al ejecutar la sentencia SQL me devuelve uno
        if (Core::ejecutarSql($sql,$datos)===1)
        {
            // Entonces devuelvo verdadero porque la jornada se ha creado correctamente.
            return true;
        }        
        // De lo contrario devuelvo falso porque la jornada NO se ha creado correctamente.
        else return false;
    }

    /**
     * Método estático que permite consultar datos de una jornada
     *
     * @param string $idJornada Identificador de la jornada de la que se quiere consultar sus datos
     * @return Jornada|null Devuelve un objeto jornada si se ha encontrado en la base de datos
     *                      Devuelve nulo si la jornada solicitada NO se ha encontrado en la base de datos
     */
    public static function consultarJornada($idJornada): ?Jornada
    {   
        // Construyo la sentencia SQL para recuperar a la jornada de la base de datos     
        $sql="SELECT * FROM pdaw_jornadas WHERE id_jornada=:idJornada";
        // Ejecuto la sentencia SQL para recuperar a la jornada de la base de datos
        $res=Core::ejecutarSql($sql,[':idJornada'=>$idJornada]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo a la jornada recuperada de la base de datos
            return new Jornada($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * Método estático para listar a todas las jornadas disponibles en la base de datos
     *
     * @return Array|null Devuelve un array asociativo con el listado completo de jornadas en la base de datos
     *                    Devuelve nulo si NO pudo obtnerse un listado completo de jornadas en la base de datos
     */
    public static function listarJornadas(): ?Array {
        // Construyo la sentencia SQL para recuperar a las jornadas de la base de datos     
        $sql="SELECT j.id_jornada as idJornada, j.titulo as titulo, ob.nombre as observatorio, j.fecha as fecha,
            j.estado as estado FROM pdaw_jornadas j 
            JOIN pdaw_observatorios ob ON j.observatorio=ob.codigo";
        // Ejecuto la sentencia SQL para recuperar a las jornadas de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo a las jornadas recuperadas de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }    

    // OJO HAY QUE ADAPTARLA A LAS NECESIDADES DE JORNADAS ...... (Hacerlo conjunto con el controlador)

    /**
     * Método estático para buscar Jornadas en la base de datos.
     *
     * @param string $busqueda Cadena de busqueda en las Jornadas de la base de datos
     * @param string $ordenar Por Campo por el que se quiere ordenar los resultado
     * @param string $orden El tipo de orden que se desea para los resultados
     * @return Array|null Devuelve un array con los resultados de la búsqueda de Jornadas
     *                    Devuelve nulo si el criterio de búsqueda no ha encontrado Jornadas
     */
    public static function buscarJornadas($busqueda, $ordenarPor, $orden) {

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

?>
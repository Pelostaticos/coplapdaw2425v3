<?php

/**
 * Clase del modelo para trabajar con la tabla Participantes de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Participantes" de la base
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

use correplayas\excepciones\AppException;
use \correplayas\nucleo\Core;
use DateTime;

/**
 * Clase del modelo de datos para trabajar con participantes
 */
class Participante {

    // A) Defino los atributos de la clase Participante
    private $idJornada;
    private $usuario;
    private $inscripción;
    private $observacion;
    private $asiste;

    // B) Defino el constructor privado de la clase Participante
    private function __construct($inscripcion) {
        $this->idJornada=$inscripcion['id_jornada'];
        $this->usuario=$inscripcion['usuario'];
        $this->inscripción=$inscripcion['inscripcion'];
        $this->observacion=$inscripcion['observacion'];
        $this->asiste=$inscripcion['asiste'];
    }
    
    // C) Defino los métodos propios de la clase Participante

    /**
    * Método para actualizar los datos de una inscripción en la base de datos
    *
    * @return boolean Devuelve verdadero si se actualizo la inscripción del participate
    *                 Devuelve falso si no se pudo actualizar la inscripción del participate
    */
    public function actualizarInscripción(): ?bool {       
        // Construyo la sentencia SQL para actualizar la inscripción de la base de datos     
        $sql="UPDATE pdaw_participantes SET observacion=:observacion, asiste=:asiste 
            WHERE id_jornada=:idJornada AND usuario=:usuario";
        // Preparo los datos de la inscripción a actualizar en la base de datos
        $datos = [':observacion' => $this->observacion, ':asiste' => $this->asiste, 
        ':idJornada' => $this->idJornada, ':usuario' => $this->usuario];
        // Ejecuto la sentencia SQL para actualizar a la inscripción de la base de datos
        $res=Core::ejecutarSql($sql,$datos);
        // Si el resultado es mayor de cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que la inscripción se ha actualizado correctamente
            return true;
        }
        else {
            // De lo contario devuelvo falso para indicar que la inscripción no se ha actualizado correctamente
            return false;
        }
    }
    
    /**
     * Método para eliminar a una inscripción de la base de datos
     *
     * @return boolean Devuelve verdadero si se eliminó la inscripción de la base de datos
     *                 Devuelve falso si NO se eliminó la inscripción de la base de datos
     */
    public function eliminarInscripcion(): ?bool {
        // Construyo la sentencia SQL para eliminar a la inscripcion de la base de datos     
        $sql="DELETE FROM pdaw_participantes WHERE id_jornada=:idJornada AND usuario=:usuario";
        // Preparo la clave primaria de la inscripción que se desea eliminar de la base de datos
        $codigo = [':idJornada' => $this->idJornada, ':usuario' => $this->usuario];
        // Ejecuto la sentencia SQL para eliminar a la inscripcion de la base de datos
        $res=Core::ejecutarSql($sql,$codigo);
        // Si el resultado es mayor que cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que la inscripción se ha eliminado correctamente
            return true;
        }
        else
            // De lo contario devuelvo falso para indicar que la inscripcion NO se ha eliminado correctamente
            return false;
    }  

    // D) Defino los métodos getter y setter de la clase Participante

    /**
     * Método GET para obtener el identificador único de la jornada en la que se participa
     *
     * @return string Devuelve el identificador único de jornada a la que participa
     */
    public function getIdJornada() {
        return $this->idJornada;
    }

    /**
     * Método GET para obtener el usuario que participa en una jornada de la plataforma
     *
     * @return string Devuelve el usuario que participa en una jornada de la plataforma
     */
    public function getUsuario() {
        return $this->usuario;
    }
    
     /**
     * Método GET para obtener la fecha del momento de inscripción de un usuario a una jornada de la plataforma
     *
     * @return string Devuelve la fecha del momento de inscripción de un usuario a una jornada de la plataforma
     */
    public function getInscripción() {
        return $this->inscripción;
    }   

     /**
     * Método GET para obtener la observación que hace un participante sobre su inscripción de participación 
     *
     * @return string Devuelve la observación que hace un participante a una inscripción de participación
     */
    public function getObservación() {
        return $this->observacion;
    }

     /**
     * Método GET para obtener si el participante inscrito en una jornada de la plataforma asiste o no
     *
     * @return string Devuelve el estado de asistencia del participante a la jornada inscrita o no
     */
    public function getAsiste() {
        return $this->asiste;        
    }

    /**
     * Método SET para establcer una nueva observación a la inscripción de un participante
     *
     * @param string $observacion Nueva observación echa por el participante a su inscripción
     * @return void No devuelve valor alguno
     */
    public function setObservacion($observacion) {
        $this->observacion=$observacion;
    }

    /**
     * Método SET para establcer el estado de asistencia de un participante a una jornada inscrita
     *
     * @param string $asiste estado de asistencia de un participante a una jornada inscrita
     * @return void No devuelve valor alguno
     */
    public function setAsiste($asiste) {
        $this->asiste=$asiste;
    }    

    // E) Defino los métodos estáticos de la clase Participante

    /**
     * Método estático para crear una nueva inscripción en la base de datos
     *
     * @param Array $datos Array asociativo con los datos a insertar de la nueva inscripción en la base de datos
     * @return boolean Devuelve verdadero si la inscripción se creó correctamente
     *                 Devuelve falso si la inscripción no pudo crearse correctamente
     */
    public static function crearInscripcion($datos): ?bool
    {       
        // Construyo la sentencia SQL para añadir una nueva inscripción a la tabla Participantes de la base datos
        $sql="INSERT INTO pdaw_participantes (id_jornada, usuario, inscripcion, observacion,
            asiste) VALUES (:idJornada, :usuario, :inscripcion, :observacion, :asiste)";
        // Si al ejecutar la sentencia SQL me devuelve uno
        if (Core::ejecutarSql($sql,$datos)===1)
        {
            // Entonces devuelvo verdadero porque la inscripción se ha creado correctamente.
            return true;
        }        
        // De lo contrario devuelvo falso porque la inscripción NO se ha creado correctamente.
        else return false;
    }

    /**
     * Método estático que permite consultar datos de una inscripción
     *
     * @param Array $idInscripción Array asociativo que contiene la clave primaria de una inscripción en la base de datos
     *                  >> idJornada: Llave que contiene el valor del identificador de la jornada inscrita.
     *                  >> usuario: Llave que contiene el valor del usuario que participan en la jornada isncrita.
     * @return Participante|null Devuelve un objeto participante si se ha encontrado en la base de datos
     *                           Devuelve nulo si la inscripción solicitada NO se ha encontrado en la base de datos
     */
    public static function consultarInscripcion($idInscripción): ?Participante
    {   
        // Construyo la sentencia SQL para recuperar a la jornada de la base de datos     
        $sql="SELECT * FROM pdaw_participantes WHERE id_jornada=:idJornada AND usuario=:usuario";
        // Ejecuto la sentencia SQL para recuperar a la jornada de la base de datos
        $res=Core::ejecutarSql($sql,[':idJornada'=>$idInscripción['idJornada'], ':usuario' => $idInscripción['usuario']]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo a la jornada recuperada de la base de datos
            return new Participante($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * Método estático para listar las jornadas disponibles en la base de datos para un usuario participante
     *
     * @param string $participante Hash del usuario que quiere participan en las jornadas abiertas inscripción
     * @return Array|null Devuelve un array asociativo con el listado de jornadas disponibles para inscripción de dicho participante
     *                    Devuelve nulo si NO pudo obtnerse un listado de jornadas disponibles para inscripción de dicho participante
     */
    public static function listarJornadasInscripcion($participante): ?Array {
        // Construyo la sentencia SQL base para recuperar a las jornadas de la base de datos     
        $sql="SELECT j.id_jornada as idJornada, j.titulo as titulo, ob.nombre as observatorio, j.fecha as fecha,
            j.estado as estado, ob.localidad as localidad FROM pdaw_jornadas j 
            JOIN pdaw_observatorios ob ON j.observatorio=ob.codigo
            WHERE j.id_jornada NOT IN (SELECT id_jornada FROM pdaw_participantes WHERE (inscripcion BETWEEN :inicioMesAnterior AND :hoy) AND usuario=:usuario) AND j.estado='ABIERTA'";
        // Preparo los paŕametros requeridos por la consulta de inscripciones a la base de datos        
        $datos=[':inicioMesAnterior' => date('Y-m-01 00:00:00', strtotime('first day of last month')),':hoy' => date('Y-m-d H:i:s'), ':usuario' => $participante];
        // Ejecuto la sentencia SQL para recuperar a las jornadas de la base de datos
        $res=Core::ejecutarSql($sql, $datos);
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

    /**
     * Método estático para listar el histórico de participación de un usuario de la plataforma
     *
     * @param string $participante Hash del usuario del que se desea listar su hitórico de participanción en la plataforma
     * @return Array|null Devuelve un array asociativo con el listado de inscripciones de dicho participante
     *                    Devuelve nulo si NO pudo obtnerse un listado de inscripciones de dicho participante
     */
    public static function listarHistoricosInscripcion($participante): ?Array {
        // Construyo la sentencia SQL base para recuperar el histórico de participación del usuario de la base de datos     
        $sql="SELECT j.id_jornada as idJornada, j.titulo as titulo, 
            CONCAT(j.fecha,' - ', j.hora_inicio, ' - ', j.hora_fin) as programada, 
            p.inscripcion as inscrito, j.estado, 
            CASE j.estado
                WHEN 'ABIERTA' THEN 'NO'
                WHEN 'CANCELADA' THEN 'NO'
                WHEN 'CERRADA' THEN 'SI'
                WHEN 'PUBLICADA' THEN 'NO'                
            END AS realizada
            FROM pdaw_jornadas j 
            JOIN pdaw_observatorios ob ON j.observatorio=ob.codigo
            JOIN pdaw_participantes p ON p.id_jornada=j.id_jornada
            WHERE p.usuario=:usuario";
        // Preparo los paŕametros requeridos por la consulta del histórico de participación a la base de datos        
        $datos=[':usuario' => $participante];
        // Ejecuto la sentencia SQL para recuperar el histórico de participación jornadas de la base de datos
        $res=Core::ejecutarSql($sql, $datos);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo a las inscripciones recuperadas de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    // F) Métodos estáticos privados de apoyo a la búsquedas de jornadas por fechas y rango de fechas

    /**
     * Método auxiliar para limpiar el término de dúsqueda de jornadas
     *
     * @param string $terminoBusqueda El término de búsqueda introciduo por el usuario
     * @return string Devuelve limpio el termino de búsqueda introducido por el usuario
     */
    private static function limpiarBusqueda($terminoBusqueda) {
        // Retorno el término de búsqueda limpio
        return htmlspecialchars(strip_tags(trim($terminoBusqueda)));
    }

    /**
     * Método auxiliar para limpiar y dar formato adecuado a la fecha introducida por el usuario
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @param string $fecha Fecha de búsqueda introducida por el usuario 
     * @return string Devuelve la fecha introducida por el usuario en el formato correcto
     */
    private static function prepararFechas($fecha) {
        // Limpio la fecha introducida por el usuario en el campo de búsqueda
        $fecha = Participante::limpiarBusqueda($fecha);
        // Intento obtener un objeto fecha a partir de la cadena de fecha introducida por el usuario
        // Obtengo un objeto fecha a partir de la cadena de fecha introducida por el usuario
        $fechaObjeto = DateTime::createFromFormat('d-m-Y', $fecha);
        // Si el objeto fecha NO se pudo crear correctamente. Entonces:
        if (!$fechaObjeto) {
            // Notifico al usuario que el formato de la fecha introducida por el usuario es incorrecta
            throw new AppException("Recuerda! El formato de fecha introducido debe ser: DD-MM-YYYY");
        }
        // Devuelvo el formato de la fecha de búsqueda en el formato adecuado para la base de datos
        return $fechaObjeto->format('Y-m-d');
    }

    /**
     * Método estático auxiliar para limpiar y dar formato correcto al rango de fechas introducido por el usuario
     *
     * @param string $rangoFechas Rango de fecha de búsqueda introducido por el usuario
     * @return list Devuelve un objeto tipo listado con las fechas del rango introducido en formato correcto
     */
    private static function prepararRangoFechas($rangoFechas) {
        // Limpio la fecha introducida por el usuario en el campo de búsqueda
        $rangoFechas = Participante::limpiarBusqueda($rangoFechas);
        // Divido el rango de fechas introducido por el usuario en sus partes
        // RECUERDA: El formato de rango de fechas admitidos en frontend es: DD-MM-YYYY a DD-MM-YYYY
        $partes = explode('a', $rangoFechas);
        // Compruebo si el rango de fechas deseado se compone de dos partes
        if (count($partes) === 2) {
            // Obtengo la fecha de inicio del rango de búsqueda deseado en el formato correcto
            $fechaInicio = Participante::prepararFechas(trim($partes[0]));
            // Obtengo la fecha de finc del rango de búsqueda deseado en el formato correcto
            $fechaFin = Participante::prepararFechas(trim($partes[1]));
        } else {
            // Notifico al usuario que el formato del rango fecha introducida por el usuario es incorrecto
            throw new AppException("Recuerda! El formato para el fecha introducido debe ser: DD-MM-YYYY a DD-MM-YYYY");
        }
        // Devuelvo las fechas del rango de búsqueda en el formato correcto para la base de datos
        return [$fechaInicio, $fechaFin];
    }


}

 ?>
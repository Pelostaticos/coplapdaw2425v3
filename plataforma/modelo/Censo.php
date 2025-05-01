<?php

/**
 * Clase del modelo para trabajar con la tabla Censos de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Censos" de la base
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
 * Clase del modelo de datos para trabajar con censos
 */
class Censo {

    // A) Defino los atributos de la clase Censo
    private $idJornada;
    private $especie;
    private $hora;
    private $cantidad;
    private $nubosidad;
    private $visibilidad;
    private $dirViento;
    private $velViento;
    private $procedencia;
    private $destino;
    private $altVuelo;
    private $formaVuelo;
    private $distCosta;
    private $comentario;

    // B) Defino el constructor privado de la clase Censo
    private function __construct($censo) {
        $this->idJornada=$censo['id_jornada'];
        $this->especie=$censo['especie'];
        $this->hora=$censo['hora'];
        $this->cantidad=$censo['canrtidad'];
        $this->nubosidad=$censo['nubosidad'];
        $this->visibilidad=$censo['visibilidad'];
        $this->dirViento=$censo['dirViento'];
        $this->velViento=$censo['velViento'];
        $this->procedencia=$censo['procedencia'];
        $this->destino=$censo['destino'];
        $this->altVuelo=$censo['altVuelo'];
        $this->formaVuelo=$censo['formaVuelo'];
        $this->comentario=$censo['comentario'];
    }    

    // C) Defino los métodos propios de la clase Censo
    
    /**
    * Método para actualizar los datos de un registro censal del ave en la base de datos
    *
    * @return boolean Devuelve verdadero si se actualizo el registro censal del ave
    *                 Devuelve falso si no se pudo actualizar el registro censal del ave
    */
    public function actualizarRegistroCensal(): ?bool {       
        // Construyo la sentencia SQL para actualizar el registro censal del ave en la base de datos     
        $sql="UPDATE pdaw_censos SET cantidad=:cantidad, nubosidad=:nubosidad, visibilidad=:visibilidad, dirViento=:dirViento,
                velViento=:velViento, procedencia=:procedencia, destino=:destino, altVuelo=:altVuelo, formaVuelo=:formaVuelo,
                distCosta=:distCosta, comentario=:comentario 
                WHERE id_jornada=:idJornada AND especie=:especie AND hora=:hora";
        // Preparo los datos del registro censal del ave a actualizar en la base de datos
        $datos = [':cantidad' => $this->cantidad, ':nubosidad' => $this->nubosidad, ':visibilidad' => $this->visibilidad,
            ':dirViento' => $this->dirViento, ':velViento' => $this->velViento, ':procedencia' => $this->procedencia,
            ':destino' => $this->destino, ':AltVuelo' => $this->altVuelo, ':formaVuelo' => $this->formaVuelo,
            ':distCosta' => $this->distCosta, ':comentario' => $this->comentario, ':especie' => $this->especie,
            ':idJornada' => $this->idJornada, ':hora' => $this->hora];
        // Ejecuto la sentencia SQL para actualizar el registro censal del ave en la base de datos
        $res=Core::ejecutarSql($sql,$datos);
        // Si el resultado es mayor de cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que el registro censal del ave se ha actualizado correctamente
            return true;
        }
        else {
            // De lo contario devuelvo falso para indicar que el registro censal del ave no se ha actualizado correctamente
            return false;
        }
    }

    /**
     * Método para eliminar a un registro censal de un ave de la base de datos
     *
     * @return boolean Devuelve verdadero si se eliminó el registro censal de un ave de la base de datos
     *                 Devuelve falso si NO se eliminó el registro censal de un ave de la base de datos
     */
    public function eliminarRegistroCensal(): ?bool {
        // Construyo la sentencia SQL para eliminar el registro censal de un ave de la base de datos     
        $sql="DELETE FROM pdaw_censos WHERE id_jornada=:idJornada AND especie=:especie AND hora=:hora";
        // Preparo la clave primaria del registro censal del ave que se desea eliminar de la base de datos
        $codigo = [':idJornada' => $this->idJornada, ':especie' => $this->especie, ':hora' => $this->hora];
        // Ejecuto la sentencia SQL para eliminar al registro censal del ave de la base de datos
        $res=Core::ejecutarSql($sql,$codigo);
        // Si el resultado es mayor que cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que el registro censal del ave se ha eliminado correctamente
            return true;
        }
        else
            // De lo contario devuelvo falso para indicar que el registro censal del ave  NO se ha eliminado correctamente
            return false;
    }
    
    // D) Defino los métodos getter y setter de la clase Censo
    
    /**
     * Método GET para obtener el identificador único de la jornada censal
     *
     * @return string Devuelve le identificado único de la jornada censal
     */
    public function getIdJornada() {
        return $this->idJornada;
    }

    /**
     * Método GET para obtener la especie del ave del resgitro censal
     *
     * @return string Devuelve la especie del ave del registro censal
     */
    public function getEspecie() {
        return $this->especie;
    }

    /**
     * Método GET para obtener la hora del registro censal del ave
     *
     * @return string Devuelve la hora del registro censal del ave
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * Método GET para obtener la cantidad de aves anotadas en el registro censal
     *
     * @return string Devuelve la cantidad de aves anotadas en el registro censal
     */
    public function getCantidad() {
        return $this->cantidad;
    }    

    /**
     * Método GET para obtener la nubosidad en momento del registro censal del ave
     *
     * @return string Devuelve la nubosidad en momento del registro censal del ave
     */
    public function getNubosidad() {
        return $this->nubosidad;
    }

    /**
     * Método GET para obtener la visibilidad en momento del registro censal del ave
     *
     * @return string Devuelve la visibilidad en momento del registro censal del ave
     */
    public function getVisibilidad() {
        return $this->visibilidad;
    }

    /**
     * Método GET para obtener la dirección del viento en momento del registro censal del ave
     *
     * @return string Devuelve la dirección del viento en momento del registro censal del ave
     */
    public function getDireccionViento() {
        return $this->dirViento;
    }
    
    /**
     * Método GET para obtener la velocidad del viento en momento del registro censal del ave
     *
     * @return string Devuelve la velocidad del viento en momento del registro censal del ave
     */
    public function getVelocidadViento() {
        return $this->velViento;
    }

    /**
     * Método GET para obtener la procedencia del ave en momento del registro censal
     *
     * @return string Devuelve la procedencia del ave en momento del registro censal
     */
    public function getProcedenciaAve() {
        return $this->procedencia;
    }
    
    /**
     * Método GET para obtener la destino del ave en momento del registro censal
     *
     * @return string Devuelve la destino del ave en momento del registro censal
     */
    public function getDestinoAve() {
        return $this->destino;
    }
    
    /**
     * Método GET para obtener la altura de vuelo del ave en momento del registro censal
     *
     * @return string Devuelve la altura de vuelo del ave en momento del registro censal
     */
    public function getAltturaVueloAve() {
        return $this->altVuelo;
    }
    
    /**
     * Método GET para obtener la forma de vuelo del bando de aves en momento del registro censal
     *
     * @return string Devuelve la forma de vuelo del bando de aves en momento del registro censal
     */
    public function getFormsaVueloAve() {
        return $this->formaVuelo;
    }

    /**
     * Método GET para obtener la distancia a costa del ave en momento del registro censal
     *
     * @return string Devuelve la distancia a costa del ave en momento del registro censal
     */
    public function getDistanciaCostaAve() {
        return $this->distCosta;
    }
    
    /**
     * Método GET para obtener el comentario adicional a la observación en momento del registro censal
     *
     * @return string Devuelve el comentario adicional a la observación en momento del registro censal
     */
    public function getComentario() {
        return $this->comentario;
    }
    
    /**
     * Método SET para establecer la cantidad de aves observadas en el momento del registro censal
     *
     * @param string $cantidad Cantidad de aves observadas en el momento del registro censal
     * @return void No devuelve valor alguno
     */
    public function setCantidad($cantidad) {
        $this->cantidad=$cantidad;
    }

    /**
     * Método SET para establecer la nubosidad en el momento del registro censal del ave
     *
     * @param string $nubosidad Nubosidad en el momento del registro censal del ave
     * @return void No devuelve valor alguno
     */
    public function setNubosidad($nubosidad) {
        $this->nubosidad=$nubosidad;
    }

    /**
     * Método SET para establecer la visibilidad en el momento del registro censal del ave
     *
     * @param string $visibilidad Visibilidad en el momento del registro censal del ave
     * @return void No devuelve valor alguno
     */
    public function setVisibilidad($visibilidad) {
        $this->visibilidad=$visibilidad;
    }
    
    /**
     * Método SET para establecer la dirección del viento en el momento del registro censal del ave
     *
     * @param string $dirViento Dirección del viento en el momento del registro censal del ave
     * @return void No devuelve valor alguno
     */
    public function setDireccionViento($dirViento) {
        $this->dirViento=$dirViento;
    }
    
    /**
     * Método SET para establecer la velocidad del viento en el momento del registro censal del ave
     *
     * @param string $velViento Velocidad del viento en el momento del registro censal del ave
     * @return void No devuelve valor alguno
     */
    public function setVelocidadViento($velViento) {
        $this->velViento=$velViento;
    }
    
    /**
     * Método SET para establecer la procedencia del ave en el momento del registro censal
     *
     * @param string $procedencia Procedencia del ave en el momento del registro censal
     * @return void No devuelve valor alguno
     */
    public function setProcedenciaAve($procedencia) {
        $this->procedencia=$procedencia;
    }

    /**
     * Método SET para establecer la destino del ave en el momento del registro censal
     *
     * @param string $destino Procedencia del ave en el momento del registro censal
     * @return void No devuelve valor alguno
     */
    public function setDestinoAve($destino) {
        $this->destino=$destino;
    }
    
    /**
     * Método SET para establecer la altura de vuelo del ave en el momento del registro censal
     *
     * @param string $destino Altura de vuelo del ave en el momento del registro censal
     * @return void No devuelve valor alguno
     */
    public function setAlturaVueloAve($altVuelo) {
        $this->altVuelo=$altVuelo;
    }
    
    /**
     * Método SET para establecer la formación de vuelo del de un bando de avea en el momento del registro censal
     *
     * @param string $formaVuelo Formación de vuelo de un banndo de aves en el momento del registro censal
     * @return void No devuelve valor alguno
     */
    public function setFormacionVueloAve($formaVuelo) {
        $this->formaVuelo=$formaVuelo;
    }
    
    /**
     * Método SET para establecer la distancia a costa del ave en el momento del registro censal
     *
     * @param string $distCosta Distancia a costa del ave en el momento del registro censal
     * @return void No devuelve valor alguno
     */
    public function setDistanicaCostaAve($distCosta) {
        $this->distCosta=$distCosta;
    }

    /**
     * Método SET para establecer el comentario con información adicional al momento del registro censal
     *
     * @param string $comentario Comentario con información adicional al momento del registro censal
     * @return void No devuelve valor alguno
     */
    public function setComentaerio($comentario) {
        $this->comentario=$comentario;
    }     

    // E) Defino los métodos estáticos de la clase Censo

    /**
     * Método estático para crear un nuevo registro censal en la base de datos
     *
     * @param Array $datos Array asociativo con los datos a insertar del nuevo registro censal en la base de datos
     * @return boolean Devuelve verdadero si el registro censal se creó correctamente
     *                 Devuelve falso si el registro censal no pudo crearse correctamente
     */
    public static function crearRegistroCensal($datos): ?bool
    {       
        // Construyo la sentencia SQL para añadir un nuevo registro censal a la tabla Censos de la base datos
        $sql="INSERT INTO pdaw_censos (id_jornada, especie, hora, cantidad, nubosidad, visibilidad, dirViento,
            velViento, procedencia, destino, altVuelo, formaVuelo, distCosta, comentario) VALUES (:idJornada, :especie, 
            :hora, :cantidad, :nubosidad, :visibilidad, :dirViento, :velViento, :procedencia, :destino, :altVuelo,
            :formaVuelo, :distCosta, :comentario)";
        // Si al ejecutar la sentencia SQL me devuelve uno
        if (Core::ejecutarSql($sql,$datos)===1)
        {
            // Entonces devuelvo verdadero porque el registro censal se ha creado correctamente.
            return true;
        }        
        // De lo contrario devuelvo falso porque el resgitro censal NO se ha creado correctamente.
        else return false;
    }

    /**
     * Método estático que permite consultar datos de un registro censal
     *
     * @param Array $registroCensal Array asociativo que contiene la clave primaria de un registro censal en la base de datos
     *                  >> idJornada: Llave que contiene el valor del identificador de la jornada del censo.
     *                  >> especie: Llave que contiene la especie del registro censal.
     *                  >> hora: Llave que contiene la hora del momento del registro censal del ave.
     * @return Censo|null Devuelve un objeto censo si se ha encontrado en la base de datos
     *                    Devuelve nulo si el registro censal solicitado NO se ha encontrado en la base de datos
     */
    public static function consultarRegistroCensal($registroCensal): ?Censo
    {   
        // Construyo la sentencia SQL para recuperar al registro censal de la base de datos     
        $sql="SELECT * FROM pdaw_censos WHERE id_jornada=:idJornada AND especie=:especie AND hora=:hora";
        // Ejecuto la sentencia SQL para recuperar a la jornada de la base de datos
        $res=Core::ejecutarSql($sql,[':idJornada'=>$registroCensal['idJornada'], 
            ':especie' => $registroCensal['especie'], ':hora' => $registroCensal['hora']]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo el registro censal recuperado de la base de datos
            return new Censo($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }    

    /**
     * Método estático para listar las jornadas censales en la base de datos
     *
     * @return Array|null Devuelve un array asociativo con el listado de jornadas abiertas al censo
     *                    Devuelve nulo si NO pudo obtnerse un listado de jornadas abiertas al censo
     */
    public static function listarJornadasCensales(): ?Array {
        // Construyo la sentencia SQL base para recuperar a las jornadas de la base de datos     
        $sql="SELECT j.id_jornada as idJornada, j.titulo as titulo, ob.nombre as observatorio, j.fecha as fecha,
            j.estado as estado, ob.localidad as localidad FROM pdaw_jornadas j 
            JOIN pdaw_observatorios ob ON j.observatorio=ob.codigo WHERE j.fecha=:hoy AND j.estado='ABIERTA'";
        // Preparo los paŕametros requeridos por la consulta de jornadas censales a la base de datos        
        $datos=[':hoy' => date('Y-m-d H:i:s')];
        // Ejecuto la sentencia SQL para recuperar a las jornadas censales de la base de datos
        $res=Core::ejecutarSql($sql, $datos);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo a las jornadas censales recuperadas de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * Método estatico para listar el histórico de jornadas censales realizadas
     *
     * @return Array|null Devuelve un array asociativo con el listado de jornadas censales realizadas
     *                    Devuelve un array vacio cuando no es posible listar el históricos de jornadas censales realizadas
     */
    public static function listarHistoricoCensos(): ?Array {
        // Construyo la sentencia SQL base para recuperar el histórico de jornadas censales realizadas de la base de datos     
        $sql="SELECT j.id_jornada as idJornada, j.titulo as titulo, ob.nombre as observatorio, j.fecha as fecha,
            j.estado as estado, ob.localidad as localidad, COUNT(cn.especie) as registros, SUM(cn.cantidad) as censadas 
            FROM pdaw_jornadas j 
            JOIN pdaw_observatorios ob ON j.observatorio=ob.codigo 
            JOIN pdaw_censos cn ON cn.id_jornada=j.id_jornada
            WHERE j.estado='CERRADA'
            GROUP BY cn.id_jornada";
        // Ejecuto la sentencia SQL para recuperar al histórico de jornadas censales de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array con elementos
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo al histórico con jornadas censales recuperadas de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }

    /**
     * 
     * Método estático para listar los registros censales de una deterinada jornada censal
     *
     * @return Array|null Devuelve un array asociativo con el listado de registros censales para una jornada determinada
     *                    Devuelve un array vacío cuando no es posible listar los registros decnsales de una jornada determinada
     */
    public function listarRegistrosCensales($idJornada): ?Array {
        // Construyo la sentencia SQL base para recuperar a las jornadas de la base de datos     
        $sql="SELECT * FROM pdaw_censos WHERE id_jornada=:idJornada";
        // Preparo los paŕametros requeridos por la consulta de jornadas censales a la base de datos        
        $datos=[':idJornada' => $idJornada];
        // Ejecuto la sentencia SQL para recuperar a las jornadas censales de la base de datos
        $res=Core::ejecutarSql($sql, $datos);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo a los registros censales recuperados de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }
    
    /**
     * 
     * Método estático para listar a los participantes de una deterinada jornada censal
     *
     * @return Array|null Devuelve un array asociativo con el listado de participantes para una jornada determinada
     *                    Devuelve un array vacío cuando no es posible listar a los participantes de una jornada determinada
     */
    public function listarParticipantesJornadaCensal($idJornada): ?Array {
        // Construyo la sentencia SQL base para recuperar a los participantes de una jornada censal de la base de datos     
        $sql="SELECT u.nombre FROM pdaw_participantes pt JOIN pdaw_usuarios u ON u.codigo=pt.usuario
                WHERE pt.id_jornada=:idJornada";
        // Preparo los paŕametros requeridos por la consulta de particioantes a una jornada censal a la base de datos        
        $datos=[':idJornada' => $idJornada];
        // Ejecuto la sentencia SQL para recuperar a los participantes a una jornada censal de la base de datos
        $res=Core::ejecutarSql($sql, $datos);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo a los participantes de la jornada censal recuperados de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }
    
    /**
     * Método estático para buscar Inscripciones en la base de datos.
     *
     * @param string $busqueda Cadena de busqueda en las Inscripciones de la base de datos
     * @param string $ordenar Por Campo por el que se quiere ordenar los resultado
     * @param string $orden El tipo de orden que se desea para los resultados
     * @return Array|null Devuelve un array con los resultados de la búsqueda de Inscripciones
     *                    Devuelve nulo si el criterio de búsqueda no ha encontrado Inscripciones
     */
    public static function buscarCensos($busqueda, $ordenarPor, $orden) {

        // Defino las columnas de busqueda para encontrar inscripciones
        $columnas = ['av.comun', 'av.ingles', 'av.familia','cn.especie', 'ob.nombre', 'ob.localidad'];

        // Defino una array vacio en donde generar las condiciones de búsqueda
        $condiciones = [];

        // Defino un array asociativo con los parámetros de busqueda
        $parametros = [];

        // Limpio el término de búsqueda introducido por el usuario
        $busqueda = Censo::limpiarBusqueda($busqueda);

        // Establezco expresiones regulares para detectar fechas y rango de fechas
        // RECUERDA: El formato admitidos en el frontend es DD-MM-YYYY para fechas
        // y en el caso de rangos de fechas es DD-MM-YYYY a DD-MM-YYYY.
        $fechaRegex = '/^\d{2}-\d{2}-\d{4}$/';
        $rangoFechaRegex = '/^\d{2}-\d{2}-\d{4}\s+(a)\s+\d{2}-\d{2}-\d{4}$/';

        // Detecto el tipo de búsqueda de jornadas que ha solicitado el usuario
        // CASO-A: Detecta búsqueda por fecha única
        if (preg_match($fechaRegex, $busqueda)) {
            // Obtengo la fecha de búsqueda en el formato correcto para la consulta SQL
            $fecha = Censo::prepararFechas($busqueda);
            // Genero la condicion de busqueda para la consulta SQL
            $condiciones[]="j.fecha=:fecha";
            $condiciones[]="p.inscripcion=:fecha";
            // Genero los parámetros para la consulta SQL preparada
            $parametros[':fecha']=$fecha;
        // CASO-B: Detecta búsqueda por rango de fechas
        } elseif (preg_match($rangoFechaRegex, $busqueda, $matches)) {
            // Obtengo las fechas individuales del rango de fechas deseado por el usuario
            list($fechaInicio, $fechaFin) = Censo::prepararRangoFechas($busqueda);
            // Genero la condicion de busqueda para la consulta SQL
            $condiciones[]="(j.fecha>=:fechaInicio AND j.fecha<=:fechaFin)";
            $condiciones[]="(p.inscripcion>=:fechaInicio AND p.inscripcion<=:fechaFin)";
            // Genero los parámetros para la consulta SQL preparada
            $parametros[':fechaInicio']=$fechaInicio;
            $parametros[':fechaFin']=$fechaFin;        
        // CASO-C: Detecta búsqueda por titulo, observatorio o localidad.
        } else {
            // Genero las condiciones de búsqueda para encontrar jornadas por los campos.
            // Nombre común, nombre inglés, especie, familia, observatorio y localidad.
            foreach($columnas as $columna) {
                $parametro = str_replace('.','',$columna);
                $parametros[":".$parametro] = "%$busqueda%";
                $condiciones[] = "$columna LIKE :$parametro";                      
            }
        }

        // Construyo la sentencia SQL base para recuperar el histórico de participación del usuario de la base de datos     
        $sql="SELECT j.id_jornada as idJornada, j.titulo as titulo, ob.nombre as observatorio, j.fecha as fecha,
            j.estado as estado, ob.localidad as localidad, cn.especie as esppecie, av.familia as familia, 
            av.comun as comun, av.ingles as ingles FROM pdaw_jornadas j 
            JOIN pdaw_observatorios ob ON j.observatorio=ob.codigo 
            JOIN pdaw_censos cn ON cn.id_jornada=j.id_jornada
            JOIN pdaw_aves av ON av.especie=cn.especie";

        // Defino párametro de la consulta con una subconsulta para obtener los identificadores de las jornadas censales realizadas
        $parametros = [':subconsulta' => 'SELECT id_jornada FROM pdaw_censos GROUP BY id_jornada'];

        // Añado las condiciones de búsqueda a la sentencia SQL anterior
        if (!empty($condiciones)) {
            // Genero la cadena completa con todas las condiciones de búsqueda SQL.
            $sql .= " WHERE j.id_jornada IN (:subconsulta) AND j.estado='CERRADA' AND (" . implode(" OR ", $condiciones) . ")";
        }

        // Añado la funcionalidad para ordenar el resultado de la búsqueda
        $columnasPermitidas = ['comun', 'ingles', 'especie', 'familia', 'observatorio', 'localidad'];
        $ordenesPemritidos = ['ASC', 'DESC'];

        if (in_array($ordenarPor, $columnasPermitidas) && in_array($orden, $ordenesPemritidos)) {
            $sql .= " ORDER BY $ordenarPor $orden";
        }

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
     * @throws AppException Excepción cuando el formato de entrada de la fecha no es DD-MM-YYYY
     */
    private static function prepararFechas($fecha) {
        // Limpio la fecha introducida por el usuario en el campo de búsqueda
        $fecha = Censo::limpiarBusqueda($fecha);
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
     * @throws AppException Excepción cuando el formato de entrada del rango de fechas no es: DD-MM-YYYY a DD-MM-YYYY
     */
    private static function prepararRangoFechas($rangoFechas) {
        // Limpio la fecha introducida por el usuario en el campo de búsqueda
        $rangoFechas = Censo::limpiarBusqueda($rangoFechas);
        // Divido el rango de fechas introducido por el usuario en sus partes
        // RECUERDA: El formato de rango de fechas admitidos en frontend es: DD-MM-YYYY a DD-MM-YYYY
        $partes = explode('a', $rangoFechas);
        // Compruebo si el rango de fechas deseado se compone de dos partes
        if (count($partes) === 2) {
            // Obtengo la fecha de inicio del rango de búsqueda deseado en el formato correcto
            $fechaInicio = Censo::prepararFechas(trim($partes[0]));
            // Obtengo la fecha de finc del rango de búsqueda deseado en el formato correcto
            $fechaFin = Censo::prepararFechas(trim($partes[1]));
        } else {
            // Notifico al usuario que el formato del rango fecha introducida por el usuario es incorrecto
            throw new AppException("Recuerda! El formato para el fecha introducido debe ser: DD-MM-YYYY a DD-MM-YYYY");
        }
        // Devuelvo las fechas del rango de búsqueda en el formato correcto para la base de datos
        return [$fechaInicio, $fechaFin];
    }

}

?>
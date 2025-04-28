<?php

/**
 * Clase del modelo para trabajar con la tabla Aves de la base de datos.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para el manejo de la tabla "Aves" de la base
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
use \correplayas\modelo\Familia;

/**
 * Clase del modelo de datos para trabajar con Aves
 */
class Ave {

    // A) Defino los atributos de la clase Ave
    private $especie;
    private Familia $familia;
    private $abreviatura;
    private $comun;
    private $ingles;
    private $imagen;
    private $url;
    
    
    // B) Defino el constructor privado de la clase Ave
    public function __construct($ave) {
        $this->especie=$ave['especie'];
        $this->familia=Familia::asignarFamilia($ave['familia']);
        $this->abreviatura=$ave['abreviatura'];
        $this->comun=$ave['comun'];
        $this->ingles=$ave['ingles'];
        $this->imagen=$ave['imagen'];
        $this->url=$ave['url'];
    }
    
    // C) Defino los métodos propios de la clase Ave

    /**
    * Método para actualizar los datos de un ave en la base de datos
    *
    * @return boolean Devuelve verdadero si se actualizo el ave
    *                 Devuelve falso si no se pudo actualizarse el ave
    */
    public function actualizarAve(): ?bool {       
        // Construyo la sentencia SQL para actualizar al ave de la base de datos     
        $sql="UPDATE pdaw_aves SET comun=:comun, ingles=:ingles, imagen=:imagen, url=:url WHERE especie=:especie";
        // Preparo los datos del ave a actualizar en la base de datos
        $datos = [':especie' => $this->especie, ':comun' => $this->comun, ':ingles' => $this->ingles,
            ':imagen' => $this->imagen,':url' => $this->url];
        // Ejecuto la sentencia SQL para actualizar al ave de la base de datos
        $res=Core::ejecutarSql($sql,$datos);
        // Si el resultado es mayor de cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que el ave se ha actualizado correctamente
            return true;
        }
        else {
            // De lo contario devuelvo falso para indicar que el ave no se ha actualizado correctamente
            return false;
        }
    }    

    /**
     * Método para eliminar a un ave de la base de datos
     *
     * @return boolean Devuelve verdadero si se eliminó al ave de la base de datos
     *                 Devuelve falso si NO se eliminó al ave de la base de datos
     */
    public function eliminarAve(): ?bool {
        // Construyo la sentencia SQL para eliminar al ave de la base de datos     
        $sql="DELETE FROM pdaw_aves WHERE especie=:especie";
        // Preparo el código del ave que se desea eliminar de la base de datos
        $especie = [':especie' => $this->especie];
        // Ejecuto la sentencia SQL para eliminar al ave de la base de datos
        $res=Core::ejecutarSql($sql,$especie);
        // Si el resultado es mayor que cero entonces:
        if ($res > 0)        
        {
            // Devuelvo verdadero para indicar que el ave se ha eliminado correctamente
            return true;
        }
        else
            // De lo contario devuelvo falso para indicar que el ave NO se ha eliminado correctamente
            return false;
    }      

    // D) Defino los métodos getter y setter de la clase Ave

    /**
     * Método GET para obtener el nombre de la especie del ave disponible en la base de datos
     *
     * @return string Devuelve el nombre de la especie del ave
     */
    public function getEspecieAve(): string {
        return $this->especie;
    }

    /**
     * Método GET para obtener la familia de la especie del ave disponible en la base de datos
     *
     * @return Familia Devuelve la familia de la especie del ave
     */
    public function getFamiliaAve(): Familia {
        return $this->familia;
    }

    /**
     * Método GET para obtener la abreviatura del ave disponible en la base de datos
     *
     * @return string Devuelve la abreviatura del ave
     */
    public function getAbreviaturaAve(): string {
        return $this->abreviatura;
    }

    /**
     * Método GET para obtener el nombre común del ave disponible en la base de datos
     *
     * @return string Devuelve el nombre común del ave
     */
    public function getNombreComunAve(): string {
        return $this->comun;
    }    

    /**
     * Método GET para obtener el nombre inglés del ave disponible en la base de datos
     *
     * @return string Devuelve el nombre inglés del ave
     */
    public function getNombreInglesAve(): string {
        return $this->ingles;
    }    

    /**
     * Método GET para obtener la imagen del ave disponible en la base de datos
     *
     * @return string Devuelve la imagen del ave
     */
    public function getImagenAve(): string {
        return $this->imagen;
    } 

    /**
     * Método GET para obtener la url con información adicional del ave disponible en la base de datos
     *
     * @return string Devuelve la url con información adicional inglés del ave
     */
    public function getUrlAve(): string {
        return $this->url;
    }     

    /**
     * Método SET para establecer el nombre de la especie de un ave
     *
     * @param string $especie Nombre de la especie del ave
     * @return void No devuelve valor alguno
     */
    public function setEspecieAve($especie) {
        $this->especie=$especie;
    }

    /**
     * Método SET para establecer la familia de un ave
     *
     * @param string $familia Familia del ave
     * @return void No devuelve valor alguno
     */
    public function setFamiliaAve($familia) {
        $this->familia=Familia::asignarFamilia($familia);
    }

    /**
     * Método SET para establecer la abreviatura de un ave
     *
     * @param string $abreviatura Abreviatura del ave
     * @return void No devuelve valor alguno
     */
    public function setAbreviaturaAve($abreviatura) {
        $this->abreviatura=$abreviatura;
    }
    
    /**
     * Método SET para establecer el nombre común del ave
     *
     * @param string $comun Nombre común del ave
     * @return void No devuelve valor alguno
     */
    public function setNombreComunAve($comun) {
        $this->comun=$comun;
    }
    
    /**
     * Método SET para establecer el nombre inglés del ave
     *
     * @param string $ingles Nombre inglés del ave
     * @return void No devuelve valor alguno
     */
    public function setNombreInglesAve($ingles) {
        $this->ingles=$ingles;
    }

    /**
     * Método SET para establecer la imagen del ave
     *
     * @param string $imagen Imagen del ave
     * @return void No devuelve valor alguno
     */
    public function setImagenAve($imagen) {
        $this->imagen=$imagen;
    }
    
    /**
     * Método SET para establecer URL con información adicional del ave
     *
     * @param string $url URL con información adicional del ave
     * @return void No devuelve valor alguno
     */
    public function setUrlAve($url) {
        $this->url=$url;
    }        

    // E) Defino los métodos estáticos de la clase Ave

    /**
     * Método estático para crear una nueva ave en la base de datos
     *
     * @param Array $datos Array asociativo con los datos a insertar de la nueva ave en la base de datos
     * @return boolean Devuelve verdadero si el ave se creó correctamente
     *                 Devuelve falso si el ave no pudo crearse correctamente
     */
    public static function crearAve($datos): ?bool
    {       
        // Construyo la sentencia SQL para añadir una nueva ave a la tabla Aves de la base datos
        $sql="INSERT INTO pdaw_aves (especie, familia, abreviatura, comun,
            ingles, imagen, url) VALUES (:especie, :familia, :abreviatura, :comun,
            :ingles, :imagen, :url)";
        // Si al ejecutar la sentencia SQL me devuelve uno
        if (Core::ejecutarSql($sql,$datos)===1)
        {
            // Entonces devuelvo verdadero porque el aves se ha creado correctamente.
            return true;
        }        
        // De lo contrario devuelvo falso porque el aves NO se ha creado correctamente.
        else return false;
    }

    /**
     * Método estático que permite consultar datos de un aves
     *
     * @param string $especie Especie del ave que se quiere consultar sus datos
     * @return Ave|null Devuelve un objeto ave si se ha encontrado en la base de datos
     *                  Devuelve nulo si el ave solicitada NO se ha encontrado en la base de datos
     */
    public static function consultarAve($especie): ?Ave
    {   
        // Construyo la sentencia SQL para recuperar al ave de la base de datos     
        $sql="SELECT * FROM pdaw_aves WHERE especie=:especie";
        // Ejecuto la sentencia SQL para recuperar al ave de la base de datos
        $res=Core::ejecutarSql($sql,[':especie'=>$especie]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo al ave recuperada de la base de datos
            return new Ave($res[0]);
        }
        else
            // De lo contario devolveré nulo
            return null;
    }       

    /**
     * Método estático para listar a todas las aves disponibles en la base de datos
     *
     * @return Array|null Devuelve un array asociativo con el listado completo de aves en la base de datos
     *                    Devuelve nulo si NO pudo obtnerse un listado completo de aves en la base de datos
     */
    public static function listarAves(): ?Array {
        // Construyo la sentencia SQL para recuperar las aves de la base de datos     
        $sql="SELECT especie, familia, abreviatura, comun, ingles, imagen, url FROM pdaw_aves";
        // Ejecuto la sentencia SQL para recuperar a las aves de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo a las aves recuperados de la base de datos
            return $res;
        }
        else
            // De lo contario devolveré nulo
            return null;
    }   

    /**
     * Método estático para buscar Aves en la base de datos.
     *
     * @param string $busqueda Término de busqueda de aves
     * @param string $ordenarPor Campo utilizado para ordenar resultados de aves
     * @param string $orden Establece el orden ascendente o descendente de los resultados
     * @return Array|null Devuelve un array con los resultados de la búsqueda de Aves
     *                    Devuelve nulo si el criterio de búsqueda no ha encontrado Aves
     */
    public static function buscarAves($busqueda, $ordenarPor, $orden) {

        // Defino las columnas de busqueda para encontrar Aves
        $columnas = ['av.especie', 'av.familia', 'av.comun', 'av.ingles'];

        // Defino una array vacio en donde generar las condiciones de búsqueda
        $condiciones = [];

        // Defino un array asociativo con los parámetros de busqueda
        $parametros = [];

        // Genero las condiciones de búsqueda para encontrar Aves.
        foreach($columnas as $columna) {
            $parametro = str_replace('.','',$columna);
            $parametros[":".$parametro] = "%$busqueda%";
            $condiciones[] = "$columna LIKE :$parametro";                      
        }

        // Construyo la sentencia SQL para realizar la búsqueda de Aves
        $sql="SELECT av.especie as especie, av.familia as familia, av.comun as comun, av.ingles as ingles
            FROM pdaw_aves av";

        // Añado las condiciones de búsqueda a la sentencia SQL anterior
        if (!empty($condiciones)) {
            // Genero la cadena completa con todas las condiciones de búsqueda SQL.
            $sql .= " WHERE " . implode(" OR ", $condiciones);
        }

        // Añado la funcionalidad para ordenar el resultado de la búsqueda
        $columnasPermitidas = ['especie', 'familia', 'comun', 'ingles'];
        $ordenesPemritidos = ['ASC', 'DESC'];

        if (in_array($ordenarPor, $columnasPermitidas) && in_array($orden, $ordenesPemritidos)) {
            $sql .= " ORDER BY $ordenarPor $orden";
        }

        // Ejecuto la sentencia SQL para recuperar a las aves de la base de datos que coincidan el criterio de búsqueda
        $res=Core::ejecutarSql($sql, $parametros);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Devuelvo el resultado con las aves encontradas en la base de datos
            return $res;
        }
        else {
            // De lo contario devolveré nulo
            return null;
        }
        
    }    
    

}

?>
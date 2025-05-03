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
use \correplayas\nucleo\Core;

/**
 * Clase auxiliar del modelo de datos para trabajar con Roles
 */
class Rol {

    // A) Defino los atributos de la clase auxiliar Rol
    private $rol;
    private $permisos;

    // B) Defino el constructor privado de la clase auxiliar Rol
    private function __construct($rol) {
        // Inicializo el atributo permisos con el valor del paŕametro rol.
        $this->permisos=$rol;
        // Inicializo el atributo rol con el valor disponibe en el parámetro rol
        $this->rol=$rol['rol'];
        // Eliminio del atributo permisos el nombre del rol asociado.
        unset($this->permisos['rol']);
    }

    // C) Defino los métodos getter y setter de la clase auxiliar Rol

    /**
     * Método GET para obtener el permiso para el acceso al perfil de un usuario (B2)
     *
     * @return boolean Estado del permiso para consultar el perfil de usuario.
     */
    public function getPermisoConsultarUsuario() {
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
    public function getPermisoEliminarUsuario() {
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

     /**
     * Método GET para obtener el permiso para inscribirse a jornadas censales en la plataforma (D1)
     *
     * @return boolean Estado del permiso para inscribirse jornadas censales en la plataforma
     */
    public function getPermisoInscribirseJornadas() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso15 de la tabla Roles.
        return $this->permisos['permiso15'];
    } 

     /**
     * Método GET para obtener el permiso para consultar inscripción a jornadas censales en la plataforma (D2)
     *
     * @return boolean Estado del permiso para consultar inscripción jornadas censales en la plataforma
     */
    public function getPermisoConsultarInscripcion() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso16 de la tabla Roles.
        return $this->permisos['permiso16'];
    } 

     /**
     * Método GET para obtener el permiso para actualizar inscripción a jornadas censales en la plataforma (D3)
     *
     * @return boolean Estado del permiso para actualizar inscripción jornadas censales en la plataforma
     */
    public function getPermisoActualizarInscripcion() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso17 de la tabla Roles.
        return $this->permisos['permiso17'];
    }

     /**
     * Método GET para obtener el permiso para eliminar inscripción a jornadas censales en la plataforma (D4)
     *
     * @return boolean Estado del permiso para eliminar inscripción jornadas censales en la plataforma
     */
    public function getPermisoEliminarInscripcion() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso18 de la tabla Roles.
        return $this->permisos['permiso18'];
    }

     /**
     * Método GET para obtener el permiso para listar inscripciones a jornadas censales en la plataforma (D5.1)
     *
     * @return boolean Estado del permiso para listar inscripciones jornadas censales en la plataforma
     */
    public function getPermisoListarInscripciones() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso19 de la tabla Roles.
        return $this->permisos['permiso19'];
    }
    
     /**
     * Método GET para obtener el permiso para listar paerticipantes a jornadas censales en la plataforma (D5.2)
     *
     * @return boolean Estado del permiso para listar participantes jornadas censales en la plataforma
     */
    public function getPermisoListarParticipantes() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso20 de la tabla Roles.
        return $this->permisos['permiso20'];
    }       

     /**
     * Método GET para obtener el permiso para buscar inscripciones a jornadas censales en la plataforma (D6)
     *
     * @return boolean Estado del permiso para buscar inscripciones jornadas censales en la plataforma
     */
    public function getPermisoBuscarInscripciones() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso21 de la tabla Roles.
        return $this->permisos['permiso21'];
    }   

     /**
     * Método GET para obtener el permiso para buscar participantes a jornadas censales en la plataforma (D6)
     *
     * @return boolean Estado del permiso para buscar particpantes jornadas censales en la plataforma
     */
    public function getPermisoBuscarParticipantes() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso22 de la tabla Roles.
        return $this->permisos['permiso22'];
    }   

     /**
     * Método GET para obtener el permiso para confirmar asistencia participantes a jornadas censales en la plataforma (E0)
     *
     * @return boolean Estado del permiso para confirmar asistencia particpantes jornadas censales en la plataforma
     */
    public function getPermisoConfirmarAsistencia() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso23 de la tabla Roles.
        return $this->permisos['permiso23'];
    }

     /**
     * Método GET para obtener el permiso para registrar censos en la plataforma (E1)
     *
     * @return boolean Estado del permiso para registrar censos en la plataforma
     */
    public function getPermisoRegistrarCenso() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso24 de la tabla Roles.
        return $this->permisos['permiso24'];
    }
    
     /**
     * Método GET para obtener el permiso para consultar censos en la plataforma (E2)
     *
     * @return boolean Estado del permiso para consultar censos en la plataforma
     */
    public function getPermisoConsultarCenso() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso25 de la tabla Roles.
        return $this->permisos['permiso25'];
    }    

     /**
     * Método GET para obtener el permiso para actualizar censos en la plataforma (E3)
     *
     * @return boolean Estado del permiso para actualizar censos en la plataforma
     */
    public function getPermisoActualizarCenso() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso26 de la tabla Roles.
        return $this->permisos['permiso26'];
    }   
    
     /**
     * Método GET para obtener el permiso para eliminar censos en la plataforma (E4)
     *
     * @return boolean Estado del permiso para eliminar censos en la plataforma
     */
    public function getPermisoEliminarCenso() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso27 de la tabla Roles.
        return $this->permisos['permiso27'];
    }
    
     /**
     * Método GET para obtener el permiso para listar censos en la plataforma (E5)
     *
     * @return boolean Estado del permiso para listar censos en la plataforma
     */
    public function getPermisoListarCensos() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso28 de la tabla Roles.
        return $this->permisos['permiso28'];
    }   
    
     /**
     * Método GET para obtener el permiso para buscar censos en la plataforma (E6)
     *
     * @return boolean Estado del permiso para buscar censos en la plataforma
     */
    public function getPermisoBuscarCensos() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso29 de la tabla Roles.
        return $this->permisos['permiso29'];
    }
    
     /**
     * Método GET para obtener el permiso para registrar ave en la plataforma (F1)
     *
     * @return boolean Estado del permiso para registrar ave en la plataforma
     */
    public function getPermisoRegistrarAve() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso30 de la tabla Roles.
        return $this->permisos['permiso30'];
    }
    
     /**
     * Método GET para obtener el permiso para consultar ave en la plataforma (F2)
     *
     * @return boolean Estado del permiso para consultar ave en la plataforma
     */
    public function getPermisoConsultarAve() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso31 de la tabla Roles.
        return $this->permisos['permiso31'];
    }
    
     /**
     * Método GET para obtener el permiso para actualizar ave en la plataforma (F3)
     *
     * @return boolean Estado del permiso para actualizar ave en la plataforma
     */
    public function getPermisoActualizarAve() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso32 de la tabla Roles.
        return $this->permisos['permiso32'];
    }
    
     /**
     * Método GET para obtener el permiso para eliminar ave en la plataforma (F4)
     *
     * @return boolean Estado del permiso para eliminar ave en la plataforma
     */
    public function getPermisoEliminarAve() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso33 de la tabla Roles.
        return $this->permisos['permiso33'];
    }

     /**
     * Método GET para obtener el permiso para listar aves en la plataforma (F5)
     *
     * @return boolean Estado del permiso para listar aves en la plataforma
     */
    public function getPermisoListarAves() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso34 de la tabla Roles.
        return $this->permisos['permiso34'];
    }

     /**
     * Método GET para obtener el permiso para buscar aves en la plataforma (F6)
     *
     * @return boolean Estado del permiso para buscar aves en la plataforma
     */
    public function getPermisoBuscarAves() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso35 de la tabla Roles.
        return $this->permisos['permiso35'];
    }

     /**
     * Método GET para obtener el permiso para registrar observatorio en la plataforma (G1)
     *
     * @return boolean Estado del permiso para registrar observatorio en la plataforma
     */
    public function getPermisoRegistrarObservatorio() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso36 de la tabla Roles.
        return $this->permisos['permiso36'];
    }
    
     /**
     * Método GET para obtener el permiso para consultar observatorio en la plataforma (G2)
     *
     * @return boolean Estado del permiso para consultar observatorio en la plataforma
     */
    public function getPermisoConsultarObservatorio() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso37 de la tabla Roles.
        return $this->permisos['permiso37'];
    }
    
     /**
     * Método GET para obtener el permiso para actualizar observatorio en la plataforma (G3)
     *
     * @return boolean Estado del permiso para actualizar observatorio en la plataforma
     */
    public function getPermisoActualizarObservatorio() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso38 de la tabla Roles.
        return $this->permisos['permiso38'];
    }
    
     /**
     * Método GET para obtener el permiso para eliminar observatorio en la plataforma (G4)
     *
     * @return boolean Estado del permiso para eliminar observatorio en la plataforma
     */
    public function getPermisoEliminarObservatorio() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso39 de la tabla Roles.
        return $this->permisos['permiso39'];
    }

     /**
     * Método GET para obtener el permiso para listar observatorios en la plataforma (G5)
     *
     * @return boolean Estado del permiso para listar observatorios en la plataforma
     */
    public function getPermisoListarObservatorios() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso40 de la tabla Roles.
        return $this->permisos['permiso40'];
    }

     /**
     * Método GET para obtener el permiso para buscar observatorios en la plataforma (G6)
     *
     * @return boolean Estado del permiso para buscar observatorios en la plataforma
     */
    public function getPermisoBuscarObservatorio() {
        // Devuelvo del atributo permisos el estado correspondiente al campo permiso41 de la tabla Roles.
        return $this->permisos['permiso41'];
    }

    /**
     * Método para comprobar que un usuario tiene rol administrador para ejecutar un gestor.
     *
     * @return boolean Verdadero para permitir el acceso al gestor restringido al rol administrador
     *                 Falso para no permitir el acceso al gesor al resto de roles
     */
    public function hasPermisoAdministradorGestor(): bool {
        return $this->rol === 'administrador' ? true : false;
    }

    /**
     * Método para comprobar ue un usuario tiene permiso para acceder a modo restringido del gestor de censos
     *
     * @return boolean Verdadero para permitir el acceso al modo restringido del gestor de censos
     *                 Falso para prohibir el acceso al modo restringido del gestor de censos
     */
    public function hasPermisoGestorCensos(): bool {
        return $this->rol === 'voluntario' ? false : true;
    }


    /**
     * Método para verificar que el rol de un usuario es conocido por la plataforma
     *
     * @return boolean Verdadero si el rol del usuario es conocido por la plataforma
     *                 Falso si el rol del usuario es desconocido por la plataforma
     */
    public function hasRolDesconocidoPlataforma(): bool {
        return in_array($this->rol, Rol::listarRoles(), true);
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
        // Construyo la sentencia SQL para recuperar al rol del usuario de la base de datos     
        $sql="SELECT * from pdaw_roles where rol=:rol";
        // Ejecuto la sentencia SQL para recuperar al rol del usuario de la base de datos
        $res=Core::ejecutarSql($sql,[':rol'=>$rol]);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)===1)        
        {
            // Devuelvo al rol de usuario recuperado de la base de datos
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
        // Construyo la sentencia SQL para recuperar a los roles de usuario de la base de datos     
        $sql="SELECT rol from pdaw_roles";
        // Ejecuto la sentencia SQL para recuperar a los roles de usuario de la base de datos
        $res=Core::ejecutarSql($sql);
        // Si el resultado devuelto tras ejecución contiene un array de un elemento
        if (is_array($res) && count($res)>0)        
        {
            // Proceso los resultados para obtener los roles disponibles en la plataforma
            foreach ($res as $rol) {
                $roles[] = $rol['rol'];
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
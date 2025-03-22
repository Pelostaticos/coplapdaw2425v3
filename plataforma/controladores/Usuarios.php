<?php
/**
 * Clase del controlador para gestionar todas las acciones con usuarios de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los usuarios de la plataforma correplayas.
 *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

 // Defino el espacio de nombre para esta clase del controlador para usuarios
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\excepciones\AppException;
use correplayas\modelo\Usuario;
use correplayas\modelo\Persona;
use Smarty\Smarty;

/**
 * Clase del controlador Usuarios para gestión de todas sus acciones disponibles en plataforma
 */
class Usuarios {

    public function modificarPassword($passwordActual, $passwordNueva)
    {
        // $sql="UPDATE usuarios SET password=SHA2(CONCAT(:username,:newpassword),256) WHERE username=:username and password=SHA2(CONCAT(:username,:currentpassword),256)";
        // return DB::doSql($sql,[':usuario'=>$this->usuario,':currentpassword'=>$currentpassword,':newpassword'=>$newpassword]);        
    }
    

}

 ?>
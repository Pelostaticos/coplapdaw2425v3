<?php

/**
 * Clase del controlador para gestionar todas las acciones con jornadas de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con los jornadas de la plataforma correplayas.
 *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 */

 // Defino el espacio de nombre para esta clase del controlador para jornadas
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\excepciones\AppException;
use correplayas\modelo\Jornada;
use Smarty\Smarty;

/**
 * Clase del controlador Jornadas para gestión de todas sus acciones disponibles en plataforma
 */
class Jornadas {

    /**
     * Método por defecto que muestra la vista del gestor de jornadas de la plataforma y además gestiona
     * las vistas auxiliares de acciones solicitadas por administradores desde el listado de jornadas.
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     */    
    public static function default($smarty) {
        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Compruebo si el usuario logueado es administrador
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {
            // El usuario logueado es administrador. Entonces:
            // Compruebo si está establecida la accion en el supergobal POST.
            if (isset($_POST['accion'])) {
                // Está establecida la acción en el superglobal POST. Entonces:                
                // Recupero la acción solicitada desde el listado de usaurios
                $accion = $_POST['accion'];
                // Establezco la variable sesion con el identificador de la jornada seleccionado en el listado
                $_SESSION['listado'] = $_POST['idJornada'];
                // Gestiono la vista que debo mostrarle al administrador según la acción solicitada
                switch($accion) {
                    case "actualizar":
                        Jornadas::mostrarEdicionJornadaPlataforma($smarty);
                        break;
                    case "eliminar":
                        Jornadas::mostrarConfirmaciónBajaJornadaPlataforma($smarty);
                        break;
                    default:
                        Jornadas::consultarDetallesJornadaPlataforma($smarty);
                        break;
                }
            } else {
                // De lo contario, muestro las vista por defecto del gestor de jornadas. Por tanto:
                Jornadas::listarJornadasPlataforma($smarty);
                echo "He llegado aquí";
            }            
        } else {
            // De lo contario, el usuario logueado no tiene permisos para ejecutar este gestor
            // Por tanto, lanzo una excepción para notificar del error asl usuario
            throw new AppException("Su rol en la plataforma no le permite ejecutar el gestor de jornadas");
        }
    }

    // A) Método estáticos privados para gestioanr las vistas específicas solicitada desde el listado

    private static function listarJornadasPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Si el usuario logueado es administrador entonces:
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {

            // Genero el listado de jornadas  disponibles en la plataforma
            $datos = Jornada::listarJornadas();

            // Asigno las variables requeridas por la plantila del listado de jornadas
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de jornadas
            $smarty->display('jornadas/listado.tpl');      

        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para listar y filtrar jornadas
            throw new AppException($message = "Tu rol en la plataforma no te permite listar ni filtrar jornadas", 
                $urlAceptar="/plataforma/backoffice.php");
        }        

    }

    private static function consultarDetallesJornadaPlataforma($smarty) {
        echo "He llegado a consultar detalles de una jornada...";
    }

    private static function mostrarEdicionJornadaPlataforma($smarty) {

    }

    private static function mostrarConfirmaciónBajaJornadaPlataforma($smarty) {

    }

    // B) Métodos estáticos públicos para procesar los datos de las vistas específicas

    // NOTA: El filtrado o busqueda de jornadas lo dejo para el final para decidir campos y algoritmo

    // C) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados

}

?>
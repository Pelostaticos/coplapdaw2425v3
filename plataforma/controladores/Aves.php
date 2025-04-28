<?php

/**
 * Clase del controlador para gestionar todas las acciones con aves de la plataforma.
 * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
 * Nombre del proyecto: Plataforma Correplayas
 * Tutor PDAW: Jośe Antonio Morales Álvarez.
 * 
 * Contiene todas las funciones y métodos para gestionar todas las acciones relacionads
 * con las aves de la plataforma correplayas.
 * 
  *
 * @category "Controladores"
 * @package  Correplayas
 * @author   Sergio García Butrón
 * @version  1.0
 *
 * OBSERVACIONES: Desarrollo descartado por falta de tiempo para cumplir con plazos de entrega * 
 */

 // Defino el espacio de nombre para esta clase del controlador para aves
namespace correplayas\controladores;

// Defino los espacios de mombres que voy a utilizar en esta clase
use correplayas\controladores\ErrorController;
use correplayas\excepciones\AppException;
use correplayas\modelo\Ave;
use Smarty\Smarty;

/**
 * Clase del controlador Aves para gestión de todas sus acciones disponibles en plataforma
 */
class Aves {

    /**
     * Método estático por defecto para mostrar vistas del gestor de aves de la plataforma
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
                // Recupero la acción solicitada desde el listado de aves
                $accion = $_POST['accion'];
                // Establezco la variable sesion con el identificador del aves seleccionado en el listado
                $_SESSION['listado'] = $_POST['codigo'];                
                // Gestiono la vista que debo mostrarle al administrador según la acción solicitada
                switch($accion) {
                    case "actualizar":
                        // Muestro la vista específica de edición de un ave de la plataforma
                        // Aves Observatorios::mostrarEdicionObservatorioPlataforma($smarty);
                        break;
                    case "eliminar":
                        // Muestro la vista específica con el mensaje de confirmación de baja de un ave de la plataforma
                        // Aves Observatorios::mostrarConfirmaciónBajaObservatorioPlataforma($smarty);
                        break;
                    default:
                        // Establezco la variable de sesión volver al gestor de aves tras consultar
                        // los detalles de un ave disponible en la plataforma
                        $_SESSION['volver'] = $_SERVER['REQUEST_URI'];
                        // Muestro la vista general con los detalles del ave de la plataforma deseado
                        // Aves Observatorios::consultarDetallesObservatorioPlataforma($smarty);
                        break;                    
                }                
            } else {
                // De lo contario, muestro las vista por defecto del gestor de aves. Por tanto:
                Aves::listarAvesPlataforma($smarty);
            }  
        } else {
            // De lo contario, el usuario logueado no tiene permisos para ejecutar este gestor
            // Por tanto, lanzo una excepción para notificar del error asl usuario
            throw new AppException("Su rol en la plataforma no le permite ejecutar el gestor de aves");
        }

    }

    // A) Método estáticos privados para gestioanr las vistas específicas solicitada desde el listado

    /**
     * Método estático auxiliar para mostrar la vista con el listado de aves disponibles en la plataforma
     *
     * @param Smarty $smarty Objeto que contiene al motor de plantillas Smarty
     * @return void No devuelve valor alguno
     * @throws AppException Excepción cuando existe problemas de pemrisos del usuario
     */
    private static function listarAvesPlataforma($smarty) {

        // Obtengo al usuario de la sesión del navegacion
        $usuario = $_SESSION['usuario'];

        // Recupero los permisos del usuario logueado desde su sesión
        $permisosUsuario = $_SESSION['permisos'];

        // Si el usuario logueado es administrador entonces:
        if ($permisosUsuario->hasPermisoAdministradorGestor()) {

            // Genero el listado de aves  disponibles en la plataforma
            $datos = Ave::listarAves();

            // Asigno las variables requeridas por la plantila del listado de aves
            $smarty->assign('usuario', $usuario->getUsuario());
            $smarty->assign('permisosUsuario', $permisosUsuario);
            $smarty->assign('filas', $datos);
            $smarty->assign('anyo', date('Y'));
            // Muestro la plantilla del listado de aves
            $smarty->display('aves/listado.tpl');   
        } else {
            // Lanzo una excepción para notificar al usuario que no tiene permisos para listar y filtrar observatorios
            throw new AppException(message: "Tu rol en la plataforma no te permite listar ni filtrar aves", 
                urlAceptar: "/plataforma/backoffice.php");
        }
    }

    // B) Métodos estáticos públicos para procesar los datos de las vistas específicas
    
    
    // C) Métodos estáticos públicos para vistas generales y su procesamiento de datos asociados    

}
/**
 * @fileoverview ajaxquery.js
 * Funciones de intercambio asincronos de datos en la plataforma correplayas en lado cliente.
 *
 * @version 1.0
 * @author Sergio García Butrón
 * @date 03-04-2025
 *
 */

// A) Funciones de carga dinámica de elementos select en formularios.
// A.0) Función para realizar peticiones AJAX al backend de la plataforma correplayas
function realizarPeticionesAjax(comando) {

    // 0º) Inicio la petición AJAX al backend de la plataforma correplayas
    fetch('backoffice.php?comando=ajax:query:core', {
        method: 'POST',
        body: JSON.stringify({ ajaxquery: comando }),
        headers: { 'Content-Type': 'application/json' }
    })
        // 1º) Manejo la respuesta del servidor de la plataforma correplayas
        .then(respuesta => respuesta.json())
        // 2º) Recupero los datos enviados por el servidor tras ejecutar la promesa anterior
        .then(datos => {
            switch (comando) {
                // Cargo dinámicamente los selectores disponibles en la vista de edición de usuarios.
                case "usuarios:actualizar":
                    break;
                // Por defecto: Cargo dinámicamente los selectores disponibles en la vista de registro de usuario.
                default:
                    cargarSelectRegistroUsuarios(datos);
                    break;
            }
        })
        // 3º) Capturo cualquier posible excepción que pueda surgir durante la petición AJAX.
        .catch(error => {
            // Notifico al usuario el error en la petición Ajax realizada.
            alert('Error en petición Ajax: ', error);
        }); 

}
// A.1) Función para cargar dinámicamente los elementos select del formualrio de registro de usuarios
function cargarSelectRegistroUsuarios(datos) {

    // 1º) Obtengo el elemento select "localidades" del formulario de registro de usuarios
    const selectLocalidades = document.getElementById('localidades');

    // 1º) Limpio las opciones existente en el selector "localidades" ontenido
    selectLocalidades.innerHTML = '';

    // 2º) Cargo las localidades en el selector de formulario obtenido
    datos.forEach(opcion => {
        const option = document.createElement('option');
        option.value = opcion.valor;
        option.textContent = opcion.nombre;
        select.appendChild(option);
    });

}


// B) Funcionaes de actualización dinámica de datos por clic en elemento select.


// C) Manejadores de eventos control dináimico de datos en formualrios.
// C.0) Array asociativos con los formularios disponibles en la plataforma y sus comandos de peticion Ajax.
const peticionesSelectAjax = {'signup':'usuarios:registro', 'edicion':'usuarios:actualizar'};
// C.1) Añado el manipulador de evento para controlar que el contenido del DOM se ha cargado.
document.addEventListener('DOMContentLoaded', function() { 
    // Obtengo todos los formularios disponible en la página actual ya cargada..
    const formularios = document.querySelectorAll('form');
    // Recupero cada uno de los selectores presentes en la página cargada:
    formularios.forEach(formulario => {  
        // Compruebo si el selector actual tiene el identificador deseado.
        if (peticionesSelectAjax.hasOwnProperty(formulario.id)) { 
            // Realizo la petición AJAX
            realizarPeticionesAjax(peticionesSelectAjax[formulario.id]);
        }
    });
});

// D) Manejadores de eventos control clics en elementos select en formualrios.

// <<<--- Código de referencia para adaptarlo a la nueva funcionalidad:


  // D.1) Cargo el manipulador de evento para cargar dinámicamente los selectores en el/lo formulario(s) presente en la página actual.
  
//   selectores.forEach(seelctor => {
//     // Compruebo si alguno de los formularios presentes en la página actual tiene selector.
//     if (validadoresFormularios.hasOwnProperty(selector.id)) {
//       // Añado el manipulador del evento load para el formulario presente en la página web
//       document.getElementById(formulario.id).addEventListener('DOMContentLoaded', validadoresFormularios[formulario.id]);
//     }
//   });  

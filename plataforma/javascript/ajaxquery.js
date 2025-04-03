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
            // Aquí añado el código para 
            console.info(datos.mensaje);
        })
        // 3º) Capturo cualquier posible excepción que pueda surgir durante la petición AJAX.
        .catch(error => {
            console.error('Error al cargar productos:', error);
        }); 

}
// A.1) Función para cargar dinámicamente los elementos select del formualrio de registro de usuarios
function cargarSelectRegistroUsuarios(event, datos) {

    // 1º) Obtengo el elemento select "localidades" del formulario de registro de usuarios
    const selectLocalidades = document.getElementById('localidaes');

    // 1º) Limpio las opciones existente en el selector "localidades" ontenido
    selectLocalidades.innerHTML = '';

    // 2º) Cargo las localidades en el selector de formulario obtenido
    datos.forEach(opcion => {
        const option = document.createElement('option');
        option.value = opcion.valor;
        option.textContent = opcion.nombre;
        select.appendChild(option);
    })

}


// B) Funcionaes de actualización dinámica de datos por clic en elemento select.


// C) Manejadores de eventos control dináimico de datos en formualrios.


// D) Manejadores de eventos control clics en elementos select en formualrios.

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
    fetch('/plataforma/backoffice.php?comando=ajax:query:core', {
        method: 'POST',
        body: JSON.stringify({ ajaxquery: comando }),
        headers: { 'Content-Type': 'application/json' }
    })
        // 1º) Manejo la respuesta del servidor de la plataforma correplayas
        .then(respuesta => respuesta.json())
        // 2º) Recupero los datos enviados por el servidor tras ejecutar la promesa anterior
        .then(datos => {
            // Compruebo que no se haya error en el backend tars petición Ajax
            if (datos.error) {
                // Se han encontrado error en el backend por petición Ajax. Entonces:
                // Lo notifico al usuario en el frontend
                alert(datos.error);
            } else {
                // Proceso las respuesta obtenida desde el backend
                switch (comando) {
                    // Cargo dinámicamente los selectores disponibles en la vista de edición de usuarios.
                    case "usuarios:actualizar":
                        cargarSelectEdicionUsuarios(datos);
                        break;
                    // Cargo dinámicamente los selectores disponibles en la vista de registro de nueva jornada
                    case "jornadas:registrar":
                        cargarSelectRegistroJornadas(datos);
                        break;
                    case "jornadas:actualizar":
                        cargarSelectEdicionJornadas(datos);
                        break;
                    case "observatorios:registrar":
                        cargarSelectRegistroObservatorios(datos);
                        break;
                    case "observatorios:actualizar":
                        cargarSelectEdicionObservatorios(datos);
                        break;                        
                    // Por defecto: Cargo dinámicamente los selectores disponibles en la vista de registro de usuario.
                    default:
                        cargarSelectRegistroUsuarios(datos);
                        break;
                }    
            }
        })
        // 3º) Capturo cualquier posible excepción a nivel de red que pueda surgir durante la petición AJAX.
        .catch(error => {
            // Notifico al usuario el error en la petición Ajax realizada.
            console.error('Error en petición Ajax: ' + error);
            alert('Error en petición Ajax: ', error);
        }); 

}
// A.1) Función para cargar dinámicamente los elementos select del formualrio de registro de usuarios
function cargarSelectRegistroUsuarios(datos) {

    // Intento cargar dinámicamente los elementos select del formulario de registro de usuarios
    try {
        // 0º) Obtengo el elemento select "localidades" del formulario de registro de usuarios
        const selectLocalidades = document.getElementById('frm-localidad');

        // 1º) Limpio las opciones existente en el selector "localidades" ontenido
        selectLocalidades.innerHTML = '';

        // 2º) Cargo las localidades en el selector de formulario obtenido
        datos.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            selectLocalidades.appendChild(option);
        });
    } catch (error) {
        // Manejo las posibles excepciones que puedan ocurrir durante el proceso
        console.error(error);
    }

}

// A.2) Función para cargar dinámicamente los elementos select del formulario de edición de usuarios
function cargarSelectEdicionUsuarios(datos) {

    // Intento cargar dinámicamente los elementos select del formulario de edición de usuarios
    try {
        // 0º) Obtengo los selectores del formulario de edición de usuarios
        const selectLocalidad = document.getElementById('frm-localidad');
        const selectRol = document.getElementById('frm-rol');

        // 1º) Obtengo los valores actuales de los selectores del formulario de edición de usuarios
        const localidadActual = selectLocalidad.querySelector('option[selected]');
        const rolActual = selectRol.querySelector('option[selected]');

        // 2º) Limpio los selectores del formulario de edición de usuarios
        selectLocalidad.innerHTML = '';
        selectRol.innerHTML = '';

        // 3º) Cargo las localidades en el selector correspondiente del formualrio
        datos.localidad.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            if (opcion.valor === localidadActual.value) {option.selected=true;}
            selectLocalidad.appendChild(option);
        });    

        // 4º) Cargo los roles en el selector correspondiente del formulario
        datos.rol.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            if (opcion.valor === rolActual.value) {option.selected=true;}
            selectRol.appendChild(option);
        });     
    } catch (error) {
        console.error(error);
    }
}

// A.3) Función para cargar dinámicamente los selectores de la vista de registro de nueva jornada
function cargarSelectRegistroJornadas(datos) {
    // Intento cargar dinámicamente los elementos select del formulario de registro de jornada
    try {
        // 0º) Obtengo el elemento select "observatorio" del formulario de registro de jornada
        const selectObservatorios = document.getElementById('frm-observatorio');

        // 1º) Limpio las opciones existente en el selector "observatorio" obtenido
        selectObservatorios.innerHTML = '';

        // 2º) Cargo los observatorios en el selector de formulario obtenido
        datos.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            selectObservatorios.appendChild(option);
        });        

    } catch(error) {
        // Muestro por consola el error producido al cargar selectores en la vista deseada
        console.error(error);
    }
}

// A.4) Función para cargar dinámicamente los selectores de la vista de edición de jornada
function cargarSelectEdicionJornadas(datos) {
    // Intento cargar dinámicamente los elementos select del formulario de edición de jornada
    try {
        // 0º) Obtengo el elemento select "observatorio" del formulario de edicion de jornada
        const selectObservatorios = document.getElementById('frm-observatorio');

        // 1º) Obtengo los valores actuales de los selectores del formulario de edición de usuarios
        const observatorioActual = selectObservatorios.querySelector('option[selected]');

        // 2º) Limpio las opciones existente en el selector "observatorio" ontenido
        selectObservatorios.innerHTML = '';

        // 3º) Cargo las localidades en el selector correspondiente del formualrio
        datos.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            if (opcion.valor === observatorioActual.value) {option.selected=true;}
            selectObservatorios.appendChild(option);
        });       

    } catch(error) {
        // Muestro por consola el error producido al cargar seelctores en la vista deseada
        console.error(error);
    }
}

// A.5) Función para cargar dinámicamente los selectores de la vista de registro de observatorios
function cargarSelectRegistroObservatorios(datos) {
    // Intento cargar dinámicamente los elementos select del formulario de registro de observatorios
    try {
        // 0º) Obtengo el elemento select "localidad" del formulario de registro de observatorio
        const selectLocalidad = document.getElementById('frm-localidad');

        // 1º) Limpio las opciones existente en el selector "localidad" obtenido
        selectLocalidad.innerHTML = '';

        // 2º) Cargo las localidades en el selector de formulario obtenido
        datos.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            selectLocalidad.appendChild(option);
        });  
    } catch(error) {
        // Muestro por consola el error producido al cargar selectores en la vista deseada
        console.error(error);
    }
}

// A.6) Función para cargar dinámicamente los selectores de la vista de edicion de observatorios
function cargarSelectEdicionObservatorios(datos) {
    // Intento cargar dinámicamente los elementos select del formulario de edicion de observatorios
    try {
        // 0º) Obtengo el elemento select "localidad" del formulario de edicion de observatorios
        const selectLocalidades = document.getElementById('frm-localidad');

        // 1º) Obtengo los valores actuales de los selectores del formulario de edición de observatorios
        const localidadActual = selectLocalidades.querySelector('option[selected]');

        // 2º) Limpio las opciones existente en el selector "localidad" obtenido
        selectLocalidades.innerHTML = '';

        // 3º) Cargo las localidades en el selector correspondiente del formulario
        datos.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            if (opcion.valor === localidadActual.value) {option.selected=true;}
            selectLocalidades.appendChild(option);
        });   
    } catch(error) {
        // Muestro por consola el error producido al cargar selectores en la vista deseada
        console.error(error);
    }
}

// B) Funcionaes de actualización dinámica de datos por clic en elemento select.
// RECUERDA: Descartado por falta de tiempo para cumplir fecha de entrega del Proyecto DAW

// C) Manejadores de eventos control dináimico de datos en formualrios.
// C.0) Intentp manejar los eventos de control dinámico de datos en formularios
try {
    // C.1) Array asociativos con los formularios disponibles en la plataforma y sus comandos de peticion Ajax.
    const peticionesSelectAjax = {'signup':'usuarios:registro', 'edicion-usuario':'usuarios:actualizar',
        'registro-jornada': 'jornadas:registrar', 'registro-observatorio': 'observatorios:registrar',
        'edicion-observatorios': 'observatorios:actualizar'};
    // C.2) Añado el manipulador de evento para controlar que el contenido del DOM se ha cargado.
    document.addEventListener('DOMContentLoaded', function() { 
        // Obtengo todos los formularios disponible en la página actual ya cargada..
        const formularios = document.querySelectorAll('form');
        // Recupero cada uno de los selectores presentes en la página cargada:
        formularios.forEach(formulario => {  
            // Compruebo si el selector actual tiene el identificador deseado.
            if (peticionesSelectAjax.hasOwnProperty(formulario.id)) { 
                console.info("Se está haciendo una petición Ajax procedente de " + formulario.id);
                // Realizo la petición AJAX
                realizarPeticionesAjax(peticionesSelectAjax[formulario.id]);
            }
        });
    });    
} catch (error) {
    // Manejo las posibles excepciones que se produzcan durante el manejos de eventos de control dinámico
    // de datos en formularios de la plataforma.
    console.error(error);
}

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

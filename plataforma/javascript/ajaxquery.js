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
function realizarPeticionesAjax(comando, parametro="") {

    // 0.0º) Preparo la petición AJAX a realizar al backend de la plataforma correplayas
    // Compruebo si la paetición AJAX contiene parámetros de seleccion
    if (parametro.trim()) {
        // La petición AJAX contiene parámetros. Entonces
        // Envio el comando y los parámetros de seleccion de la petiición
        peticion = { ajaxquery: comando, seleccion: parametro }
    } else {
        // De lo contario, la petición AJAX sólo contiene el comando
        peticion = { ajaxquery: comando }
    }

    // 0.1º) Inicio la petición AJAX al backend de la plataforma correplayas
    fetch('/plataforma/backoffice.php?comando=ajax:query:core', {
        method: 'POST',
        body: JSON.stringify(peticion),
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
                    case "aves:registrar":
                        cargarSelectRegistroAves(datos);
                        break;
                    case "aves:registrar:orden":
                        cargarOrdenRegistroEdicionAves(datos);
                        break;
                    case "censos:añadir":
                        cargarSelectAñadirRegistroCensal(datos);
                        break;
                    case "censos:editar":
                        cargarSelectEditarRegistroCensal(datos);
                        break;
                    case "censos:añadir:familiaorden":
                        cargarFamiliaOrdenEditarRegistroCensal(datos);
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

// A.7) Función para cargar dinámicamente los selectores de la vista de registro de aves
function cargarSelectRegistroAves(datos) {
    // Intento cargar dinámicamente los elementos select del formulario de registro de aves
    try {
        // 0º) Obtengo el elemento select "familia" del formulario de registro de aves
        const selectFamilia = document.getElementById('frm-familia');

        // 1º) Limpio las opciones existente en el selector "familia" obtenido
        selectFamilia.innerHTML = '';

        // 2º) Cargo las familias en el selector de formulario obtenido
        datos.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            selectFamilia.appendChild(option);
        });  
        
        // 3º) Fuerzo la carga dinámica inicial del campo orden asociado al selector familias
        realizarPeticionesAjax("aves:registrar:orden", selectFamilia.value)

    } catch(error) {
        // Muestro por consola el error producido al cargar selectores en la vista deseada
        console.error(error);
    }
}

// A.8) Función para cargar dinámicamente los selectores de la vista del censo de aves
function cargarSelectAñadirRegistroCensal(datos) {
    // Intento cargar dinámicamente los elementos select del formulario para añadir un registro censal
    try {
        // 0º) Obtengo el elemento select "especie" del formulario de registro de aves
        const selectEspecie = document.getElementById('frm-especie');

        // 1º) Limpio las opciones existente en el selector "especie" obtenido
        selectEspecie.innerHTML = '';

        // 2º) Cargo las especies en el selector de formulario obtenido
        datos.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            selectEspecie.appendChild(option);
        });  
        
        // 3º) Fuerzo la carga dinámica inicial de los campos Familia y Orden asociado al selector especie
        realizarPeticionesAjax("censos:añadir:familiaorden", selectEspecie.value)

    } catch(error) {
        // Muestro por consola el error producido al cargar selectores en la vista deseada
        console.error(error);
    }    
}

// A.9) Función para cargar dinámicamente los selectores de la vista edición del censo de aves
function cargarSelectEditarRegistroCensal(datos) {
    // Intento cargar dinámicamente los elementos select del formulario para editar un registro censal
    try {
        // 0º) Obtengo el elemento select "localidad" del formulario de edicion de observatorios
        const selectEspecie= document.getElementById('frm-especie');

        // 1º) Obtengo los valores actuales de los selectores del formulario de edición de observatorios
        const especieActual = selectEspecie.querySelector('option[selected]');

        // 2º) Limpio las opciones existente en el selector "localidad" obtenido
        selectEspecie.innerHTML = '';

        // 3º) Cargo las localidades en el selector correspondiente del formulario
        datos.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.valor;
            option.textContent = opcion.nombre;
            if (opcion.valor === especieActual.value) {option.selected=true;}
            selectEspecie.appendChild(option);
        });
        
        // 4º) Fuerzo la carga dinámica inicial de los campos Familia y Orden asociado al selector especie
        realizarPeticionesAjax("censos:añadir:familiaorden", selectEspecie.value)

    } catch(error) {
        // Muestro por consola el error producido al cargar selectores en la vista deseada
        console.error(error);
    }    
}

// B) Funcionaes de actualización dinámica de datos por clic en elemento select.
// B.1) Funcion para cargar dinamicamente el valor del campo orden al seleccionar una fanilia en el registro/edicion de aves
function cargarOrdenRegistroEdicionAves(datos) {
    // Intento cargar dinámicamente el valor del campo orden del formulario de registro de observatorios
    try { 
        // 0º) Obtengo el elemento input "orden" del formulario de registro de aves
        const inputOrden = document.getElementById('frm-orden');
        // 1º) Asingo el valor del orden asociado a la famailia elegida en el selector familias
        inputOrden.value = datos['valor'];
    }  catch(error) {
        // Muestro por consola el error producido al cargar campo orden del selector familias en la vista deseada
        console.error(error);
    }
}

// B.2)  Funcion para cargar dinamicamente el valor de los campos familia-orden al seleccionar una especie 
// dentro de la vista edición de un registro censal
function cargarFamiliaOrdenEditarRegistroCensal(datos) {
    // Intento cargar dinámicamente el valor de los campo familia-orden del formulario para editar registros censales
    try { 
        // 0º) Obtengo el elemento input "familia" del formulario para editar registros censales
        const campoFamilia = document.getElementById('frm-familia');
        // 1º) Obtengo el elemento input "orden" del formulario de registro de aves
        const campoOrden = document.getElementById('frm-orden');
        // 2º) Asingo el valor de familia y orden asociado a la especie elegida en el selector especies
        campoFamilia.innerHTML = '<span>Familia</span>:&nbsp;' + datos['familia'];
        campoOrden.innerHTML = '<span>Orden</span>:&nbsp;' + datos['orden'];
    }  catch(error) {
        // Muestro por consola el error producido al cargar campos familia-orden del selector especies en la vista deseada
        console.error(error);
    }
}

// C) Manejadores de eventos control dináimico de datos en formualrios.
// C.0) Intentp manejar los eventos de control dinámico de datos en formularios
try {
    // C.1) Array asociativos con los formularios disponibles en la plataforma y sus comandos de peticion Ajax.
    const peticionesSelectAjax = {'signup':'usuarios:registro', 'edicion-usuario':'usuarios:actualizar',
        'registro-jornada': 'jornadas:registrar', 'registro-observatorio': 'observatorios:registrar',
        'edicion-observatorios': 'observatorios:actualizar', 'registro-ave': 'aves:registrar',
        'añadir-registro-censal': 'censos:añadir', 'edicion-registro-censal': 'censos:editar'};
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
// D.0) Intento manejar los clic en los selectores para solicitar carga dinámica de valores asociados
try {
    // D.1) Array asociativo con los selectores disponibles en la plataforma y su petición AJax tras clic en ellos
    const peticionesAjaxClicSelectores = {'frm-familia': 'aves:registrar:orden', 'frm-especie': 'censos:añadir:familiaorden'};
    // D.2) Obtengo todos los selectores disponibles en formularios de la página actual
    const selectores = document.querySelectorAll('select');
    // D.3) Cargo el manipulador de evento para enviar petición Ajax al hacer clic en un determinado selector de un formulario.
    selectores.forEach(selector => {
        // Compruebo si el selector actual requiere petición Ajax al seleccionar un valor del mismo
        if (peticionesAjaxClicSelectores.hasOwnProperty(selector.id)) {
            // Añado el manipulador del evento submit para el formulario presente en la página web
            document.getElementById(selector.id).addEventListener('change', function(event) {
                // Muestro el mensaje por consola de que un elementor selector está haciendo una petición Ajax
                console.info("Se está haciendo una petición Ajax procedente de " + selector.id + " para el parametro " + this.value);
                // Realizo la petición Ajax asociada a la selección de un valor en un selector de un formulario
                realizarPeticionesAjax(peticionesAjaxClicSelectores[selector.id], this.value);
            });
        }
    });      
} catch (error) {
    // Manejo las posibles excepciones que se produzcan durante el manejos de eventos de clics en selectores
    // de datos en formularios de la plataforma para carga dinámica de valores asociados.
    console.error(error);
}

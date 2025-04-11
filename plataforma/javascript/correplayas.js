/**
 * @fileoverview correplayas.js
 * Funciones de validación de formularios y menú responsive
 *
 * @version 1.0
 * @author Sergio García Butrón
 * @date 10-03-2025
 *
 */

// A) Control del menú responsive para dispositivos móviles
try {
  const menuIcono = document.querySelector('.menu-icono');
  const menu = document.querySelector('.menu');
  
  menuIcono.addEventListener('click', () => {
    menu.classList.toggle('show');
    if (menuIcono.textContent === 'menu') {
      menuIcono.textContent = 'close';    
    } else {
      menuIcono.textContent = 'menu';
    }
  });  
} catch (error) {
  console.info("Aquí no hay menú que controlar el responsive...");
}

//B) Manipulador de eventos para cuando la página carga completamente
document.body.addEventListener('load', function() {
  //B.1) Intento limpiar el formulario de contacto
  try {
    document.getElementById('contactenos').reset();
  } catch (error) {
    console.info("Aquí no hay formulario de contacto que limpiar");
  }
  //B.2) Intento limpiar el formulario de inicio de sesion
  try {
    document.getElementById('login').reset();
  } catch (error) {
    console.info("Aquí no hay formulario de inicio de sesión que limpiar");
  }
  //B.3 Intento limpiar el formulario de registro de usuario
  try {
    document.getElementById('signup').reset();
  } catch (error) {
    console.info("Aquí no hay formulario de registro de usuario que limpiar");
  }  
});

// C) Funciones de validación de formulario de la aplicación web.
// C.0) Función para validar un DNI español.
function validarDNI(dni) {
  // Eliminar espacios y convertir a mayúsculas
  dni = dni.toUpperCase().replace(/\s/g, '');

  // Verificar formato
  if (!/^\d{8}[A-Z]$/.test(dni)) {
    return false;
  }

  // Extraer número y letra
  const numero = dni.substring(0, 8);
  const letra = dni.substring(8);

  // Calcular letra esperada
  const letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
  const letraEsperada = letras.charAt(numero % 23);

  // Comparar letra calculada con letra del DNI
  return letra === letraEsperada;
}
// C.1) Función para validar el formulario de inicio de sesion.
function validarLogin(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let nombreUsuario = document.getElementById('frm-usuario').value;
  let password = document.getElementById('frm-password').value;

  // Creo un array para almacenar los errores de validación detectados
  let errores = [];

  // Validación para Nombre de usuario
  if (!nombreUsuario.trim()) {
    errores.push('Por favor, introduce tu nombre de usuario.');
  }

  // Validación para Contraseña del usuario
  if (!password.trim()) {
    errores.push('Por favor, introduce tu contraeña de acceso.');
  }

  // Si se detectan error detengo el envio del formulario y los notifico al usuario
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }
}
// C.2) Funcíon para validar el formulario de contacto.
function validarContactenos(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let nombreApellidos = document.getElementById('frm-nombre').value;
  let email = document.getElementById('frm-email').value;
  let telefono = document.getElementById('frm-telefono').value;
  let mensaje = document.getElementById('frm-mensaje').value;

  // Creo un array para almacenar los errores de validación detectados
  let errores = [];

  // Validación de Nombre y Apellidos
  if (!nombreApellidos.trim()) {
    errores.push('Por favor, introduce tu nombre y apellidos.');
  }

  // Validación de Correo Electrónico
  let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    errores.push('Por favor, introduce un correo electrónico válido.');
  }

  // Validación de Número de Teléfono
  let telefonoRegex = /^\d{9}$/;
  if (!telefonoRegex.test(telefono)) {
    errores.push('Por favor, introduce un número de teléfono válido (9 dígitos).');
  }

  // Si existen errores detengo el envio del formualrio y se los notifico al usuario
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }
}
// C.3) Funcíon para validar el formulario de registro de usuario.
function validarSignup(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let nombreUsuario = document.getElementById('frm-usuario').value;
  let password = document.getElementById('frm-password').value;  
  let dni = document.getElementById('frm-dni').value;
  let nombre = document.getElementById('frm-nombre').value;
  let apellido1 = document.getElementById('frm-apellido1').value;
  let apellido2 = document.getElementById('frm-apellido2').value;
  let email = document.getElementById('frm-email').value;
  let localidad = document.getElementById('frm-localidad').value;

  // Creo un array para almacenar los errores de validación detectados
  let errores = [];

  // Validación para Nombre de usuario
  if (!nombreUsuario.trim()) {
    errores.push('Por favor, introduce tu nombre de usuario.');
  }

  // Validación para Contraseña del usuario
  if (!password.trim()) {
    errores.push('Por favor, introduce tu nombre de usuario.');
  }

    // Validación de seguridad para nueva contraseña para el perfil de usuario
    let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/;
    if (!passwordRegex.test(password)) {
      errores.push('Por favor, la contraseña debe tener al menos 8 caracteres y contener al menos una letra minúscula, una letra mayúscula, un dígito y un carácter especial.');
    }

  // Validación del DNI de la persona usuaria
  if (!validarDNI(dni)) {
    errores.push('Por favor, introduce tu DNI correctamente.');
  }

  // Validación del nombre de la persona usuaria
  if (!nombre.trim()) {
    errores.push('Por favor, introduce tu nombre.');
  }

  // Validación del primer apellido de la persona usuaria
  if (!apellido1.trim()) {
    errores.push('Por favor, introduce tu primer apellido.');
  }

  // Validación del segundo apellido de la persona usuaria
  if (!apellido2.trim()) {
    errores.push('Por favor, introduce tu primer apellido.');
  }

  // Validación de Correo Electrónico
  let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    errores.push('Por favor, introduce un correo electrónico válido.');
  }

  // Validación de la localidad de la persona usuaria
  if (!localidad.trim()) {
    errores.push('Por favor, introduce tu localidad.');
  }

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }
}

// C.4) Funcion para validar el formulario de edición de usuarios.
function validarEdicionUsuarios(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let codigoPostal = document.getElementById('frm-codpostal').value;
  let email = document.getElementById('frm-email').value;
  let telefono = document.getElementById('frm-telefono').value;
  
  // Creo un array para almacenar los errores de validación detectados
  let errores = [];  

  // Validación para Código postal del usuario
  let codigoPostalRegex = /^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/;
  if (codigoPostal.length > 0 && !codigoPostalRegex.test(codigoPostal)) {
    errores.push('Por favor, introduce un código postal correcto.');
  }

  // Validación para Código postal del usuario
  let telefonoRegex = /^(?:(?:(?:00|\+)34|34)[\s\-]?(?:[6789]\d{2}[\s\-]?\d{2}[\s\-]?\d{2}[\s\-]?\d{2}))$/;
  if (telefono.length > 0 && !telefonoRegex.test(telefono)) {
    errores.push('Por favor, introduce un número de teléfono válido.');
  }

  // Validación de Correo Electrónico
  let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    errores.push('Por favor, introduce un correo electrónico válido.');
  }

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }

}

// C.5) Funcion para validar el formulario de edición de usuarios.
function validarCambioPassword(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let nuevoPassword = document.getElementById('frm-nuevo-password').value;
  let repetirPassword = document.getElementById('frm-repetir-password').value;
  
  // Creo un array para almacenar los errores de validación detectados
  let errores = [];  

  // Validación que la nueva contraseña y su repetida para el perfil de usaurio coincidan
  if (nuevoPassword !== repetirPassword) {
    errores.push('Por favor, introduzca las contraseñas de nuevo porque no coinciden!!');
  }

  // Validación de seguridad para nueva contraseña para el perfil de usuario
  let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/;
  if (!passwordRegex.test(nuevoPassword)) {
    errores.push('Por favor, la contraseña debe tener al menos 8 caracteres y contener al menos una letra minúscula, una letra mayúscula, un dígito y un carácter especial.');
  }

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }  

}

// C.6 Función para validar el formulario de registro de una nueva jornada en la plataforma
function validarRegistroJornada(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let titulo = document.getElementById('frm-titulo').value;
  let fecha = document.getElementById('frm-fecha').value;
  let horaInicio = document.getElementById('frm-hora-inicio').value;
  let horaFin = document.getElementById('frm-hora-fin').value;
  let informacion = document.getElementById('frm-informacion').value;
  let observatorio = document.getElementById('frm-observatorio').value;
  
  // Creo un array para almacenar los errores de validación detectados
  let errores = [];  

  // Validación para el titulo de la jornada
  if (!titulo.trim()) {
    errores.push('Por favor, introduce un titulo para la nueva jornada.');
  }

  // Validación para fecha y horas asociadas e la jornada
  const fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
  const horaRegex = /^([01]\d|2[0-3]):([0-5]\d)(:([0-5]\d))?$/;
  // --->> El campo fecha está vacio o no cumple el formato
  if (!fecha.trim() || !fechaRegex.test(fecha)) {
    errores.push('Por favor, elige una fecha correcta.');
  }
  // --->> El campo hora de inicio está vacio o no cumple el formato
  if (!horaInicio.trim() || !horaRegex.test(horaInicio)) {
    errores.push('Por favor, introduzca una hora de inicio correcta.');
  }
  // --->> El campo hora de fin está vacio o no cumple el formato
  if (!horaFin.trim() || !horaRegex.test(horaFin)) {
    errores.push('Por favor, introduzca una hora de fin correcta.');
  }
  // --->> Aquí creo objetos de fechas para realizar comparaciones
  const fechaInicio = new Date(`${fecha}T${horaInicio}`);
  const fechaFin = new Date(`${fecha}T${horaFin}`);
  // --->> El campo fecha fin no puede ser anterior a la fecha de inicio
  if (fechaFin < fechaInicio) {
    errores.push('La fecha de fin es anterior a la fecha de inicio. Por favor, corrijalo!');
  }
  // --->> La duración de la jornada es negativa
  if (fechaFin.getTime() === fechaInicio.getTime()) {
    errores.push('La fecha y hora de inicio y fin no pueden ser iguales. Por favor, corrijalo!');
  }

  // Inicializar información con el valor por defecto
  if (!informacion.trim()) {
    document.getElementById('frm-informacion').value = "Ninguna";
  }  

  // Validación para Nombre de usuario
  if (!observatorio.trim()) {
    errores.push('Por favor, elige un observatorio del desplegable.');
  }

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }

}

// C.7 Función para validar el formulario de edicion de una jornada en la plataforma
function validarEdicionJornada(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let estado = document.getElementById('frm-estado').value;
  let fecha = document.getElementById('frm-fecha').value;
  let horaInicio = document.getElementById('frm-hora-inicio').value;
  let horaFin = document.getElementById('frm-hora-fin').value;
  let informacion = document.getElementById('frm-informacion').value;
  
  
  // Creo un array para almacenar los errores de validación detectados
  let errores = [];  

  // Validación para estado de la jornada
  if (!estado.trim()) {
    errores.push('Por favor, establezca un estado a la jornada.');
  }

  // Validación para fecha y horas asociadas e la jornada
  const fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
  const horaRegex = /^([01]\d|2[0-3]):([0-5]\d)(:([0-5]\d))?$/;
  // --->> El campo fecha está vacio o no cumple el formato
  if (!fecha.trim() || !fechaRegex.test(fecha)) {
    errores.push('Por favor, elige una fecha correcta.');
  }
  // --->> El campo hora de inicio está vacio o no cumple el formato
  if (!horaInicio.trim() || !horaRegex.test(horaInicio)) {
    errores.push('Por favor, introduzca una hora de inicio correcta.');
  }
  // --->> El campo hora de fin está vacio o no cumple el formato
  if (!horaFin.trim() || !horaRegex.test(horaFin)) {
    errores.push('Por favor, introduzca una hora de fin correcta.');
  }
  // --->> Aquí creo objetos de fechas para realizar comparaciones
  const fechaInicio = new Date(`${fecha}T${horaInicio}`);
  const fechaFin = new Date(`${fecha}T${horaFin}`);
  // --->> El campo fecha fin no puede ser anterior a la fecha de inicio
  if (fechaFin < fechaInicio) {
    errores.push('La fecha de fin es anterior a la fecha de inicio. Por favor, corrijalo!');
  }
  // --->> La duración de la jornada es negativa
  if (fechaFin.getTime() === fechaInicio.getTime()) {
    errores.push('La fecha y hora de inicio y fin no pueden ser iguales. Por favor, corrijalo!');
  }

  // Inicializar información con el valor por defecto
  if (!informacion.trim()) {
    document.getElementById('frm-informacion').value = "Ninguna";
  }  

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }

}

// D) Manipulación de eventos para las validaciones de formularios.
// D.0) Array asociativos con los formularios disponibles en la plataforma y sus validadores.
const validadoresFormularios = {'contactenos': validarContactenos, 'login': validarLogin
  , 'signup':validarSignup, 'edicion-usuario': validarEdicionUsuarios, 'password': validarCambioPassword
  , 'registro-jornada': validarRegistroJornada, 'edicion-jornada': validarEdicionJornada};
// D.1) Cargo el manipulador de evento para válidar el(los) formulario(s) presente en la página actual.
const formularios = document.querySelectorAll('form');
formularios.forEach(formulario => {
  console.info(formulario.id);
  // Compruebo si alguno de los formularios presentes en la página actual tiene validador.
  if (validadoresFormularios.hasOwnProperty(formulario.id)) {
    console.info("Has encontrado al formulario en la página... " + formulario.id)
    // Añado el manipulador del evento submit para el formulario presente en la página web
   /document.getElementById(formulario.id).addEventListener('submit', validadoresFormularios[formulario.id]);
  }
});  



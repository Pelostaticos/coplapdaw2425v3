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

  // Validación del nombre de la persona usuaria
  if (!localidad.trim()) {
    errores.push('Por favor, introduce tu localidad.');
  }

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }
}

// D) Intento cargar los manejadores de eventos de cada formulario
// D.0) Manipulador de evento para validar del formulario de contacto previo a su envio.
try {
  document.getElementById('contactenos').addEventListener('submit', validarContactenos);
} catch (error) {
  console.info("Aquí no existe formulario de contacto...");
}
// D.1) Manipulador de evento para validar del formulario de inicio de sesión.
try {
  document.getElementById('login').addEventListener('submit', validarLogin);
} catch (error) {
  console.info("Aquí no existe formulario de inicio de sesión...");
}
// D.2) Manipulador de evento para validar del formulario de registro de usuario.
try {
  document.getElementById('signup').addEventListener('submit', validarSignup);  
} catch (error) {  
  console.info("Aquí no existe formulario de registro de usuario...");
}




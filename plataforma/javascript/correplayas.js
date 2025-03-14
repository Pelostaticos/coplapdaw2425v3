/**
 * @fileoverview correplayas.js
 * Funciones de validación de formularios y menú responsive
 *
 * @version 1.0
 * @author Sergio García Butrón
 * @date 10-03-2025
 *
 */

// Voy a intentar cargar los manejadores de eventos del formulario de contactp
try {
  //A) Manipulador de eventos para cuando la página carga completamente
  document.body.addEventListener('load', function() {
    document.getElementById('contactenos').reset();
  });

// B) Manipulador de evento para validar del formulario de contacto previo a su envio.
document.getElementById('contactenos').addEventListener('submit', function(event) {
    let nombreApellidos = document.getElementById('frm-nombre').value;
    let email = document.getElementById('frm-email').value;
    let telefono = document.getElementById('frm-telefono').value;
    let mensaje = document.getElementById('frm-mensaje').value;
  
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
   
    // Mostrar errores o enviar el formulario
    if (errores.length > 0) {
      event.preventDefault();
      alert(errores.join('\n'));
    } else {              
      alert('Formulario enviado correctamente');
    }
  });
} catch (error) {
  console.error("Ocurrió un error:", error.message);
}


// C) Control del menú responsive para dispositivos móviles
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
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
  if (codigoPostal.length > 0 && codigoPostal.trim() !== '-' && !codigoPostalRegex.test(codigoPostal)) {
    errores.push('Por favor, introduce un código postal correcto.');
  }

  // Validación para Código postal del usuario
  let telefonoRegex = /^(?:(?:(?:00|\+)34|34)[\s\-]?(?:[6789]\d{2}[\s\-]?\d{2}[\s\-]?\d{2}[\s\-]?\d{2}))$/;
  if (telefono.length > 0 && telefono.trim() !== '-' && !telefonoRegex.test(telefono)) {
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

// C.8) Función para validar el formulario de inscripción a una jornada en la plataforma
function validarInscripcionJornada(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let observacion = document.getElementById('frm-observacion').value;

  // Inicializar información con el valor por defecto
  if (!observacion.trim()) {
    document.getElementById('frm-observacion').value = "Ninguna";
  }  

}

// C.9) Función para validar el formulario de registro de un observatorio en la plataforma
function validarRegistroObservatorio(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let nombre = document.getElementById('frm-nombre').value;
  let direccion = document.getElementById('frm-direccion').value;
  let localidad = document.getElementById('frm-localidad').value;
  let gps = document.getElementById('frm-gps').value;
  let url = document.getElementById('frm-url').value;
  let historia = document.getElementById('frm-historia').value;
    
  // Creo un array para almacenar los errores de validación detectados
  let errores = [];

  // Validación para nombre del observatorio
  if (!nombre.trim()) {
    errores.push('Por favor, establezca el nombre del observatorio.');
  }

  // Validación para dirección del observatorio
  if (!direccion.trim()) {
    errores.push('Por favor, establezca la dirección del observatorio.');
  }  

  // Validación para localidad del observatorio
  if (!localidad.trim()) {
    errores.push('Por favor, establezca la localidad del observatorio.');
  } 

  // Validación de URL con ubicación GPS del observatorio en un mapa
  const UrlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
  if (!gps.trim() || !UrlRegex.test(gps)) {
    errores.push('Por favor, establezca una URL de ubicación del observatorio correcta!!.');
  }

  // Validación de URL con ubicación GPS del observatorio en un mapa
  if (!url.trim() || !UrlRegex.test(url)) {
    errores.push('Por favor, establezca una URL de información adicional del observatorio correcta!!.');
  }  

  // Inicializar historia con el valor por defecto
  if (!historia.trim()) {
    document.getElementById('frm-historia').value = "Ninguna";
  }    

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }

}

// C.10) Función para validar el formulario de registro de un observatorio en la plataforma
function validarRegistroAve(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let especie = document.getElementById('frm-especie').value;
  let familia = document.getElementById('frm-familia').value;
  let orden = document.getElementById('frm-orden').value;
  let abreviatura = document.getElementById('frm-codigo').value;
  let comun = document.getElementById('frm-comun').value;
  let ingles = document.getElementById('frm-ingles').value;
  let url = document.getElementById('frm-url').value;
 
    
  // Creo un array para almacenar los errores de validación detectados
  let errores = [];

  // Validación para especie del ave
  if (!especie.trim()) {
    errores.push('Por favor, establezca la especie del ave.');
  }

  // Validación para familia del ave
  if (!familia.trim()) {
    errores.push('Por favor, establezca la familia del ave.');
  }

  // Validación para orden del ave
  if (!orden.trim()) {
    errores.push('Por favor, establezca el orden del ave.');
  }  

  // Validación para abreviatura del ave
  if (!abreviatura.trim()) {
    errores.push('Por favor, establezca la abreviatura del ave.');
  }

  // Validación para nombre común del ave
  if (!comun.trim()) {
    errores.push('Por favor, establezca el nombre común del ave.');
  }
  
  // Validación para nombre inglés del ave
  if (!ingles.trim()) {
    errores.push('Por favor, establezca el nombre en inglés del ave.');
  }

  // Validación de URL con información adicional del ave
  const UrlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
  if (!url.trim() || !UrlRegex.test(url)) {
    errores.push('Por favor, establezca una URL con información adicional del ave correcta!!!');
  }

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }

}

// C.12) Función para validar el formulario para añadir un registro censal en la plataforma
function validarEdicionAve(event) {

  // Obtengo los datos introducidos en los campos del formulario  
  let comun = document.getElementById('frm-comun').value;
  let ingles = document.getElementById('frm-ingles').value;
  let url = document.getElementById('frm-url').value;
    
  // Creo un array para almacenar los errores de validación detectados
  let errores = [];  

  // Validación para nombre común del ave
  if (!comun.trim()) {
    errores.push('Por favor, establezca el nombre común del ave.');
  }
  
  // Validación para nombre inglés del ave
  if (!ingles.trim()) {
    errores.push('Por favor, establezca el nombre en inglés del ave.');
  }

  // Validación de URL con información adicional del ave
  const UrlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
  if (!url.trim() || !UrlRegex.test(url)) {
    errores.push('Por favor, establezca una URL con información adicional del ave correcta!!!');
  }

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }

}

// C.12) Función para validar el formulario para añadir un registro censal en la plataforma
function validarAñadirActualizarRegistroCensal(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let especieAve=document.getElementById('frm-especie').value;
  let horaregistroCensal=document.getElementById('frm-hora').value;
  let cantidadAves=document.getElementById('frm-cantidad').value;
  let nubosidad=document.getElementById('frm-nubosidad').value;
  let visibilidad=document.getElementById('frm-visibilidad').value;
  let dirViento=document.getElementById('frm-dirviento').value;
  let velViento=document.getElementById('frm-velviento').value;
  let procedencia=document.getElementById('frm-procedencia').value;
  let destino=document.getElementById('frm-destino').value;
  let altVuelo=document.getElementById('frm-altvuelo').value;
  let formaVuelo=document.getElementById('frm-formavuelo').value;
  let distCosta=document.getElementById('frm-distcosta').value;
  let comentario=document.getElementById('frm-comentarios').value;

  // Defino los códigos censales para las diferentes variables del registro censal
  const codigosNubosidad=['Ninguno', 'Desconocido', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100'];
  const codigosVisibilidad=['0', '1', '2', '3', '4', '5'];
  const codigosDirViento=['SIN', 'N', 'NE', 'E', 'SE', 'S', 'SO', 'O', 'NO', 'VAR', 'DES'];
  const codigosVelViento=["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];
  const codigosProcedenciaDestino=["N", "NE", "E", "SE", "S", "SO", "O", "NO", "DES"];
  const codigosAlturaVuelo=["0", "1", "2", "3", "4", "5", "6"];
  const codigosFormacionVuelo=["LINHOR", "LINVER", "VSI", "VAS", "AMO", "OTR"];
  const codigosDistanciaCosta=["DBO", "BO", "LMA", "FR", "CAN", "MED", "HOR"];

  // Creo un array para almacenar los errores de validación detectados
  let errores = [];

  // Valido que la especie del ave no esté vacía y tenga formato alfabético
  const esAlfabeticoInglesEspañol=/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/;
  if (!especieAve.trim() || !esAlfabeticoInglesEspañol.test(especieAve)) {
    errores.push('Por favor, establezca una especie de ave correcta!!!');
  }

  // Valido que la hora del resgitro censal tiene el formato correcto
  const esHora24=/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/;
  if (!horaregistroCensal.trim() || !esHora24.test(horaregistroCensal)) {
    errores.push('Por favor, establezca una hora de registro censal correcta!!! (HH:MM:SS para 24 horas)')
  }

  // Valido que la cantidad de aves observadas en el registro censal es númerico
  const esNumerico=/^[0-9]+$/;
  if (!cantidadAves.trim() || !esNumerico.test(cantidadAves)) {
    errores.push('Por favor, establezca una cantidad de ave entera positiva no igual a cero!!!');    
  }

  // Valido que la nubosidad asociada al resgitro censal tiene los códigos correctos
  if (!nubosidad.trim() || !codigosNubosidad.includes(nubosidad)) {
    errores.push('Por favor, establezca un código de nubosidad correcto!!!');        
  }

  // Valido que la visibilidad asociada al resgitro censal tiene los códigos correctos
  if (!visibilidad.trim() || !codigosVisibilidad.includes(visibilidad)) {
    errores.push('Por favor, establezca un código de visibilidad correcto!!!');        
  }  

  // Valido que la dirección del viento asociada al resgitro censal tiene los códigos correctos
  if (!dirViento.trim() || !codigosDirViento.includes(dirViento)) {
    errores.push('Por favor, establezca un código de dirección del viento correcto!!!');        
  }   
  
  // Valido que la velocidad del viento asociada al resgitro censal tiene los códigos correctos
  if (!velViento.trim() || !codigosVelViento.includes(velViento)) {
    errores.push('Por favor, establezca un código de velocidad del viento correcto!!!');        
  } 

  // Valido que la dirección de procedencia del ave asociada al resgitro censal tiene los códigos correctos
  if (!procedencia.trim() || !codigosProcedenciaDestino.includes(procedencia)) {
    errores.push('Por favor, establezca un código de dirección de procedencia del ave correcto!!!');        
  }  

  // Valido que la dirección de destino del ave asociada al resgitro censal tiene los códigos correctos
  if (!destino.trim() || !codigosProcedenciaDestino.includes(destino)) {
    errores.push('Por favor, establezca un código de dirección de destino del ave correcto!!!');        
  }  
  
  // Valido que la altura de vuelo del ave asociada al resgitro censal tiene los códigos correctos
  if (!altVuelo.trim() || !codigosAlturaVuelo.includes(altVuelo)) {
    errores.push('Por favor, establezca un código de altura de vuelo del ave correcto!!!');        
  }
  
  // Valido que la formacion de vuelo del ave asociada al resgitro censal tiene los códigos correctos
  if (!formaVuelo.trim() || !codigosFormacionVuelo.includes(formaVuelo)) {
    errores.push('Por favor, establezca un código de formacion de vuelo del ave correcto!!!');        
  }   

  // Valido que la distancia a costa del ave asociada al resgitro censal tiene los códigos correctos
  if (!distCosta.trim() || !codigosDistanciaCosta.includes(distCosta)) {
    errores.push('Por favor, establezca un código de distancia a costa del ave correcto!!!');        
  } 

  // Inicializar comentario con el valor por defecto
  if (!comentario.trim()) {
    document.getElementById('frm-comentario').value = "Ninguno";
  }  

  // Si se detectan error detengo el envio del formulario y se los notifico al usuario.
  if (errores.length > 0) {
    event.preventDefault();
    alert(errores.join('\n'));
  }

}

// C.13) Validar el formualrio de alta de un nuevo usuario en plataforma modo administrador
function validarAltaNuevoUsuarioPlataforma(event) {

  // Obtengo los datos introducidos en los campos del formulario
  let nombreUsuario = document.getElementById('frm-usuario').value;
  let password = document.getElementById('frm-password').value;  
  let dni = document.getElementById('frm-dni').value;
  let nombre = document.getElementById('frm-nombre').value;
  let apellido1 = document.getElementById('frm-apellido1').value;
  let apellido2 = document.getElementById('frm-apellido2').value;
  let email = document.getElementById('frm-email').value;
  let localidad = document.getElementById('frm-localidad').value;
  let rol = document.getElementById('frm-rol').value;

  // Defino los roles admitidos por la plataforma
  const rolesAdminitidos = ['administrador', 'coordinador', 'voluntario'];

  // Creo un array para almacenar los errores de validación detectados
  let errores = [];

  // Validación para Nombre de usuario
  if (!nombreUsuario.trim()) {
    errores.push('Por favor, introduce tu nombre de usuario.');
  }

  // Validación para Contraseña del usuario
  if (!password.trim()) {
    errores.push('Por favor, una contraseña de usuario.');
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
    errores.push('Por favor, introduce tu segundo apellido.');
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

  // Validación del rol del usuario en la plataforma
  if (!rol.trim() || !rolesAdminitidos.includes(rol)) {
    errores.push('Por favor, eliga un rol de usuario admitido por la plataforma.');
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
  , 'registro-jornada': validarRegistroJornada, 'edicion-jornada': validarEdicionJornada
  , 'inscripcion-jornada': validarInscripcionJornada, 'registro-observatorio': validarRegistroObservatorio
  , 'edicion-observatorios': validarRegistroObservatorio, 'registro-ave': validarRegistroAve
  , 'edicion-aves': validarEdicionAve,'añadir-registro-censal': validarAñadirActualizarRegistroCensal
  , 'edicion-registro-censal': validarAñadirActualizarRegistroCensal
  , 'dar-alta-usuario': validarAltaNuevoUsuarioPlataforma};
// D.1) Cargo el manipulador de evento para válidar el(los) formulario(s) presente en la página actual.
const formularios = document.querySelectorAll('form');
formularios.forEach(formulario => {
  // Compruebo si alguno de los formularios presentes en la página actual tiene validador.
  if (validadoresFormularios.hasOwnProperty(formulario.id)) {
    console.info("Has encontrado al formulario en la página... " + formulario.id)
    // Añado el manipulador del evento submit para el formulario presente en la página web
   /document.getElementById(formulario.id).addEventListener('submit', validadoresFormularios[formulario.id]);
  }
});  



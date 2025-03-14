{* Pantilla Smarty para página inicio del backoffice de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
*}

{include file="comunes/notificaciones.tpl" titulo="Cierre de sesion"
    usuario=$usuario
    anyo=$anyo
    tipo="warning"
    mensaje="Has solicitado cerrar tu sesión de usuario en la plataforma"
    pregunta="¿Quieres salir de la plataforma?"
    cancelar="/plataforma/backoffice.php"
    aceptar="/index.php"
}

{* Pantilla Smarty para vista notificaciones del backoffice de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
*
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*   >> tipo: El tipo de notificación que se le presenta al usuario.
*   >> mensaje: Aquello que se le quiere notificar al usuario.
*   >> pregunta: Cuando a un usuario se le solicita la confirmación de una acción.
*   >> aceptar: URL a la que se le redirige al usuario en caso de aceptar la acción.
*   >> cancelar: URL a la que se le redirige al usuario en caso de cancelar la acción. (opcional)
*
*}

{include file="comunes/header.tpl" titulo="Notificaciones backoffice" usuario="Pelostaticos"}
    <!-- Contenidos de la página de backoffice de la plataforma correplayas -->
    <main id="inicio">
        <!-- Sección para hablar de la plataforma correplayas -->
         <section id="notificaciones">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <h1 class="titulo">Notificaciones del Backoffice</h1>
                <p>{$usuario}, este es tu centro de notificaciones donde mantenerte al tanto de todo lo importante en tiempo real. Aquí, recibirás alertas instantáneas sobre sucesos relevantes del programa, advertencias para que no te pierdas nada y, en caso de que ocurra, información clara sobre cualquier error.</p>
                <span class="iconos-notificacion">{$tipo}</span>                
                <h3 class="cta">¡¡¡Oooohhh!!! ¿Qué ha sucedido?</h3>
                <p>{$mensaje}</p>
                <h3 class="cta">{$pregunta}</h3>
                <div class="botonera">
                    <a class="boton" href="{$cancelar}">Cancelar</a>
                    <a class="boton" href="{$aceptar}">Aceptar</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
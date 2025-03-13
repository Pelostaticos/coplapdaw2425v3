{* Pantilla Smarty para página inicio del backoffice de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
*}

{include file="comunes/header.tpl" titulo="Notificaciones backoffice" usuario=$usuario}
    <!-- Contenidos de la página de backoffice de la plataforma correplayas -->
    <main id="inicio">
        <!-- Sección para hablar de la plataforma correplayas -->
         <section>
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article id="notificaciones">
                <h1 class="titulo">Notificaciones del Backoffice</h1>
                <p>{$usuario}, este es tu centro de notificaciones donde mantenerte al tanto de todo lo importante en tiempo real. Aquí, recibirás alertas instantáneas sobre sucesos relevantes del programa, advertencias para que no te pierdas nada y, en caso de que ocurra, información clara sobre cualquier error.</p>
                <span class="iconos-notificacion">warning</span>
                <h3 class="cta">Antes de proceder necesitamos que confirmes tu acción</h3>
                <p class="mensaje-notificacion">Has solicitado cerrar tu sesión de usuario en la plataforma</p>
                <h3 class="cta">¿Quieres salir de la plataforma?</h3>
                <div class="botonera-notificacion">
                    <a class="boton-notificacion" href="/plataforma/backoffice.php">Cancelar</a>
                    <a class="boton-notificacion" href="/index.php">Aceptar</a>
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}
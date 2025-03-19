{* Pantilla Smarty para página inicio del backoffice de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Inicio del Backoffice" usuario=$usuario}
    <!-- Contenidos de la página de backoffice de la plataforma correplayas -->
    <main id="inicio">
        <!-- Sección para hablar de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <h1 class="titulo">¡Bienvenidos a nuestra plataforma!</h1>                
                <p>Nos alegra tenerte aquí {$usuario}, listo para seguir contribuyendo a nuestro proyecto de ciencia ciudadana. Tu labor como voluntario es esencial para el éxito de esta iniciativa, ya que nos permite recopilar datos valiosos sobre la biodiversidad de nuestra región.</p>
                <img src="/plataforma/imagenes/correplayas.jpg" alt="Foto del correlimos común con triactilo al fondo" />
                <p>Con tu valiosa contribución, monitoreamos especies, detectamos amenazas y tomamos decisiones para la conservación. Cada observación y censo que realizas es vital. Juntos, ciencia y ciudadanía, construimos un futuro sostenible.</p>
                <h3 class="cta">¿Cómo poddemos ayudarte?</h3>
                <div class="botonera">                    
                    <a class="boton" href="/plataforma/tutorial.pdf" target="_blank">Ayuda plataforma</a>
                    <a class="boton" href="/plataforma/backoffice.php?comando=core:email:vista">Tengo una duda</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
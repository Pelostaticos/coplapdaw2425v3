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

{include file="comunes/header.tpl" titulo="Contáctanos" usuario=$usuario}
<main>
    </section>
    <!-- Seccion para contactar con administradores de la plataforma -->
    <section id="formulario">
        <!-- Artículo que contiene el formulario para contactarnos -->
        <article>
            <!-- Información introductoria al formualrio de contacto -->
            <h1 class="titulo">Contáctenos</h1>
            <h2 class="subtitulo">¿En qué podemos ayudarte?</h2>
            <p>Hola! Sabemos que como voluntario comprometido, a veces surgen dudas o necesitas información adicional. Este formulario de contacto es tu canal directo para comunicarte con nosotros. Ya sea que tengas preguntas sobre tus observaciones, sugerencias para mejorar la plataforma o simplemente quieras compartir tus experiencias, estamos aquí para escucharte.</p>
            <!-- Formulario de contacto de la plataforma -->
            <!-- REVISARLO Y DEJARLO CONFIGURADO PARA HTML5  -->
            <form id="contactenos" method="post" action="/plataforma/backoffice.php?comando=core:email">
                <label for="frm-email">Correo electrónico:</label>
                <input type="email" name="frm-email" id="frm-email" placeholder="Dejanós tu correo..." require>
                <label for="frm-nombre">Nombre y apellidos:</label>
                <input type="text" name="frm-nombre" id="frm-nombre" placeholder="Dejanós tu nombre..." require>
                <label for="frm-telefono">Teléfono de contacto:</label>
                <input type="phone" name="frm-telefono" id="frm-telefono" placeholder="Dejanós tu teleféno..." require>                    
                <label for="frm-asunto">Asunto:</label>
                <input name="frm-asunto" id="frm-asunto" placeholder="Dejanós tu asunto de contactarnos..." require></input>                
                <label for="frm-mensaje">Mensajes:</label>
                <textarea name="frm-mensaje" id="frm-mensaje" rows="3" placeholder="Dejanós tu consulta (Opcional)"></textarea>
                <inpuy type="hidden" id="frm-origen" name="frm-origen" value="backoffice">
                <button type="submit" class="boton-enviar">Enviar</button>
            </form>
            <!-- Invitación a unirse a la plataforma -->
            <h2 id="participa" class="subtitulo">¡Gracias por tu valiosa participación!</h2>
            <p>Tu participación es fundamental para el éxito de nuestro proyecto de ciencia ciudadana, y queremos asegurarnos de que tengas todas las herramientas y el apoyo que necesitas. Completa el formulario con tu consulta y nos pondremos en contacto contigo lo antes posible. ¡Gracias por tu dedicación!</p>
        </article>       
    </section>
</main>
{include file="comunes/footer.tpl" anyo="{$anyo}"}

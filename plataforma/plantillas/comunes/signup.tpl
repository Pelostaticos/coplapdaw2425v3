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
    
    {include file="comunes/header.tpl" titulo="Registro de usuario" usuario=$usuario}
    <main>
        <!-- Seccion para formulario de inicio de sesión en el backoffice de la plataforma -->
        <section id="formulario">
            <!-- Artículo que contiene el formulario para contactarnos -->
             <article>
                <!-- Información introductoria al formualrio de contacto -->
                <h1 class="titulo">Registro de usuario</h1>
                <p>Parece que has llegado a la página de registro de usuario. Si no eres nuevo aquí, te invitamos a que inicies de sesión para participar en nuestra comunidad. Si ya tienes una cuenta, por favor verifica tus datos de acceso. Si tienes algún problema, no dudes en contactarnos.</p>
                <!-- Formulario de contacto de la plataforma -->
                <h2 class="cta">Rellena el formulario con tus datos</h2>
                <form id="signup" class="contenido-core" method="post" action="/plataforma/backoffice.php?comando=core:signup:procesa">                    
                    <div class="campos-formulario">
                        <label for="frm-dni">Documento de identidad:</label>
                        <input type="text" name="frm-dni" id="frm-dni" placeholder="Escribe tu DNI.." require>    
                        <label for="frm-nombre">Tu Nombre:</label>
                        <input type="text" name="frm-nombre" id="frm-nombre" placeholder="Escribe tu nombre..." require>                        
                    </div>                        
                    <div class="campos-formulario">
                        <label for="frm-apellido1">Tu primer apellido:</label>
                        <input type="text" name="frm-apellido1" id="frm-apellido1" placeholder="Escribe tu primer apellido..." require>
                        <label for="frm-apellido2">Tu segundo apellido:</label>
                        <input type="text" name="frm-apellido2" id="frm-apellido2" placeholder="Escribe tu primer apellido..." require>    
                    </div>
                    <div class="campos-formulario">
                        <label for="frm-email">Tu correo electrónico:</label>
                        <input type="email" name="frm-email" id="frm-email" placeholder="Escribe tu correo electrónico..." require>
                        <label for="frm-localidad">Tu localidad:</label>
                        <select id="frm-localidad" name="frm-localidad"></select>
                    </div>
                    <div class="campos-formulario">
                        <label for="frm-usuario">Usuario:</label>
                        <input type="text" name="frm-usuario" id="frm-usuario" placeholder="Escribe tu nombre de usuario..." require>
                        <label for="frm-pasword">Contraseña:</label>
                        <input type="password" name="frm-password" id="frm-password" placeholder="Escribe tu contraseña..." require>
                    </div>                    
                    <button type="submit" class="boton-enviar">Unirme a la plataforma</button>
                </form>
                <!-- Invitación a unirse a la plataforma -->
                <h3 class="cta">¿Te has perdido?</h3>
                <p class="mensaje-notificacion">Si has llegado a esta página de registro de usuario por error, no te preocupes, entendemos que a veces puede suceder. Queremos asegurarnos de que encuentres el camino correcto, así que aquí tienes algunas opciones para continuar:</p>
                <div class="botonera-notificacion">
                    <a class="boton-notificacion" href="/index.php">Volver inicio</a>
                    <a class="boton-notificacion" href="/plataforma/backoffice.php?comando=core:login:vista">Quiero acceder</a>
                </div>
            </article>       
         </section>        
    </main>
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
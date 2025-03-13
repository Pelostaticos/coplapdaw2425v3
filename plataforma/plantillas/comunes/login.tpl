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
    
    {include file="comunes/header.tpl" titulo="Inicio de sesión" usuario=$usuario}
    <main>
        <!-- Seccion para formulario de inicio de sesión en el backoffice de la plataforma -->
        <section id="formulario">
            <!-- Artículo que contiene el formulario para contactarnos -->
             <article>
                <!-- Información introductoria al formualrio de contacto -->
                <h1 class="titulo">Inicio de sesión</h1>
                <p>Parece que has llegado a la página de inicio de sesión. Si eres nuevo aquí, te invitamos a registrarte para unirte a nuestra comunidad. Si ya tienes una cuenta, por favor verifica tus datos de acceso. Si tienes algún problema, no dudes en contactarnos.</p>
                <!-- Formulario de contacto de la plataforma -->
                <!-- REVISARLO Y DEJARLO CONFIGURADO PARA HTML5  -->
                <form id="login" method="post" action="/plataforma/backoffice.php?comando=core:login">
                    <label for="frm-usuario">Nombre de usuario:</label>
                    <input type="text" name="frm-usuario" id="frm-usuario" placeholder="Escribe tu nombre de usuario..." require>
                    <label for="frm-pasword">Contraseña:</label>
                    <input type="password" name="frm-password" id="frm-password" placeholder="Escribe tu contraseña..." require>
                    <button type="submit" class="boton-enviar">Iniciar sesión</button>
                </form>
                <!-- Invitación a unirse a la plataforma -->
                <h3 class="cta">¿Te has perdido?</h3>
                <p class="mensaje-notificacion">Si has llegado a esta página de inicio de sesión por error, no te preocupes, entendemos que a veces puede suceder. Queremos asegurarnos de que encuentres el camino correcto, así que aquí tienes algunas opciones para continuar:</p>
                <div class="botonera-notificacion">
                    <a class="boton-notificacion" href="/index.php">Volver inicio</a>
                    <a class="boton-notificacion" href="/plataforma/backoffice.php?comando=core:signup:vista">Quiero registrarme</a>
                </div>
            </article>       
         </section>        
    </main>
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
{* Plantilla Smarty para vista de registro de un nuevo observatorio de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> hoy: fecha del día presente.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Registro de observatorio" usuario=$usuario}
    <!-- Contenidos de la página para el registro de nuevo observatorio de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Observatorios de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
            <article>
                <!-- Encabezado del gestor de observatorio -->
                <h1 class="titulo-accion-gestor">Registro de observatorio</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-observatorios.png" alt="encabezado gestor observatorio"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Observatorios</p>
                    </div>            
                </div>                
                <!-- Información del gestor de observatorio  -->
                <form id="registro-observatorio" method="post" action="/plataforma/backoffice.php?comando=observatorios:registrar:procesa">
                    <div class="contenido-gestor">                        
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-nombre"><spasn>Observatorio</span>:&nbsp;</label>
                                <input type="text" name="frm-nombre" id="frm-nombre" placeholder="Nombre del observatorio..." required>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-direccion"><span>Dirección</span>:&nbsp;</label>
                                <input name="frm-direccion" id="frm-direccion" type="text" placeholder="Dirección del observatorio..." required>
                                <label for="frm-localidad"><span>Localidad</span>:&nbsp;</label>
                                <select id="frm-localidad" name="frm-localidad" required></select>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-gps"><span>GPS</span>:&nbsp;</label>
                                <input type="text" name="frm-gps" id="frm-gps" placeholder="URL de ubicación en mapa..." required>
                                <label for="frm-url"><span>URL</span>:&nbsp;</label>
                                <input type="text" name="frm-url" id="frm-url" placeholder="URL de información adicional..." required>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-historia"><span>Historia</span>:&nbsp;</label>
                                <textarea name="frm-historia" id="frm-historia" rows="3" maxleng="200" placeholder="Escribe aquí su historía (Max: 200 caracteres; Opcional)..."></textarea>
                            </p>
                        </div>
                    </div>
                    <!-- Acciones permitidas por el gestor de observatorios -->
                    <div class="botonera">
                        <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=observatorios:default" title="Volver al atrás">Volver</a>
                        <button type="submit" class="boton-accion-gestor" title="Crear observatorio">Crear</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                   
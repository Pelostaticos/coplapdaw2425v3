{* Plantilla Smarty para vista de edición de un observatorio de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> perfil: Datos para generar los detalles del observatorio.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Edición de observatorio" usuario=$usuario}
    <!-- Contenidos de la página para la edición de un observatorio de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Observatorios de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
            <article>
                <!-- Encabezado del gestor de observatorios -->
                <h1 class="titulo-accion-gestor">Edición de observatorio</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-observatorios.png" alt="encabezado gestor observatorios"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Observatorios</p>
                    </div>            
                </div>                
                <!-- Información del gestor de observatorios  -->
                <form id="edicion-observatorios" method="post" action="/plataforma/backoffice.php?comando=observatorios:actualizar:procesa">
                    <input name="frm-codigo" id="frm-codigo" type="hidden" value="{$perfil.codigo}">
                    <input name="frm-imagen" id="frm-imagen" type="hidden" value="{$perfil.imagen}">
                    <div class="contenido-gestor">                        
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-nombre"><span>Observatorio</span>:&nbsp;</label>
                                <input type="text" name="frm-nombre" id="frm-nombre" value="{$perfil.nombre}" required>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-direccion"><span>Dirección</span>:&nbsp;</label>
                                <input name="frm-direccion" id="frm-direccion" type="text" value="{$perfil.direccion}" required>
                                <label for="frm-localidad"><span>Localidad</span>:&nbsp;</label>
                                <select id="frm-localidad" name="frm-localidad" required>
                                    <option value="{$perfil.localidad}" selected>{$perfil.localidad}</option>
                                </select>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-gps"><span>GPS</span>:&nbsp;</label>
                                <input type="text" name="frm-gps" id="frm-gps" value="{$perfil.gps}" required>
                                <label for="frm-url"><span>URL</span>:&nbsp;</label>
                                <input type="text" name="frm-url" id="frm-url" value="{$perfil.url}" required>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-historia"><span>Historia</span>:&nbsp;</label>
                                <textarea name="frm-historia" id="frm-historia" rows="3" maxleng="200" >{$perfil.historia}</textarea>
                            </p>
                        </div>
                    </div>
                    <!-- Acciones permitidas por el gestor de observatorios -->
                    <div class="botonera">
                        <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=observatorios:default" title="Volver atrás">Volver</a>
                        <button type="submit" class="boton-accion-gestor" title="Aplicar cambios en observatorio">Aplicar</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                   
{* Plantilla Smarty para vista de edición de una jornada de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> perfil: Datos para generar los detalles de la jornada.
*   >> estadosPerfil: Array asociativo con todos los estados posibles de una jornada en la plataforma
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Edición de jornada" usuario=$usuario}
    <!-- Contenidos de la página para la edición de una jornada de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Jornadas de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
            <article>
                <!-- Encabezado del gestor de jornadas -->
                <h1 class="titulo-accion-gestor">Edición de jornada</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-jornadas.png" alt="encabezado gestor jornadas"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Jornadas</p>
                    </div>            
                </div>                
                <!-- Información del gestor de jornadas  -->
                <form id="edicion-jornada" method="post" action="/plataforma/backoffice.php?comando=jornadas:actualizar:procesa">
                    <input name="frm-idjornada" id="frm-idjornada" type="hidden" value="{$perfil.idJornada}">
                    <div class="contenido-gestor">                        
                        <div class="campos-gestor">
                            <p class="largo"><span>Titulo</span>:&nbsp;{$perfil.titulo}</p>
                            <p class="largo">
                                <label for="frm-estado"><span>Estado</span>:&nbsp;</label>
                                <select name="frm-estado">
                                    {foreach $estados as $nombre => $valor}
                                        <option value="{$valor}" {if $perfil.estado === $nombre}selected{/if}>{$nombre}</option>
                                    {/foreach}
                                </select>  
                            </p>
                            <p class="corto"><span>Asistencia</span>:&nbsp;{$perfil.asistencia}</p>           
                        </div>
                        <div class="campos-gestor">
                            <p class="extralargo"><span>Observatorio</span>:&nbsp;{$perfil.nombreObservatorio}</p>
                        </div>                        
                        <div class="campos-gestor">
                            <p class="corto"><span>Fecha</span>:&nbsp;{$perfil.fecha|date_format:"%d-%m-%Y"}</p>
                            <input name="frm-fecha" id="frm-fecha" type="hidden" value="{$perfil.fecha}">
                            <p class="largo">
                                <label for="frm-hora-inicio"><span>Hora de inicio</span>:&nbsp;</label>
                                <input name="frm-hora-inicio" id="frm-hora-inicio" type="time" min="08:00:00" max="13:00:00" step="15" value="{$perfil.horaInicio}">
                            </p>
                            <p class="largo">
                                <label for="frm-hora-fin"><span>Hora de fin</span>:&nbsp;</label>
                                <input name="frm-hora-fin" id="frm-hora-fin" type="time" min="08:00:00" max="13:00:00" step="15" value="{$perfil.horaFin}">
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-informacion"><span>Información</span>:&nbsp;</label>
                                <textarea name="frm-informacion" id="frm-informacion" rows="3" maxleng="200">{$perfil.informacion}</textarea>
                            </p>
                        </div>
                    </div>
                    <!-- Acciones permitidas por el gestor de jornadas -->
                    <div class="botonera">
                        <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=jornadas:default" title="Volver atrás">Volver</a>
                        <button type="submit" class="boton-accion-gestor" title="Aplicar cambios en jornada">Aplicar</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                   
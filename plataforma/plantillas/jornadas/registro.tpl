{* Plantilla Smarty para vista de registro de una nueva jornada de la plataforma correplayas
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

{include file="comunes/header.tpl" titulo="Registro de jornada" usuario=$usuario}
    <!-- Contenidos de la página para el registro de nueva jornada de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Jornadas de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
            <article>
                <!-- Encabezado del gestor de jornadas -->
                <h1 class="titulo-accion-gestor">Registro de jornada</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-jornadas.png" alt="encabezado gestor jornadas"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Jornadas</p>
                    </div>            
                </div>                
                <!-- Información del gestor de jornadas  -->
                <form id="registro-jornada" method="post" action="/plataforma/backoffice.php?comando=jornadas:registrar:procesa">
                    <div class="contenido-gestor">                        
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-titulo"><span>Titulo</span>:&nbsp;</label>
                                <input type="text" name="frm-titulo" id="frm-titulo" placeholder="Titulo de la jornada..." required>
                                <label for="frm-observatorio"><span>Observatorio</span>:&nbsp;</label>
                                <select name="frm-observatorio" id="frm-observatorio" required></select>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                            <label for="frm-fecha"><span>Fecha</span>:&nbsp;</label>
                            <input name="frm-fecha" id="frm-fecha" type="date" min="{$hoy}" value="{$hoy}" required>
                            <label for="frm-hora-inicio"><span>Hora de inicio</span>:&nbsp;</label>
                            <input name="frm-hora-inicio" id="frm-hora-inicio" type="time" min="08:00:00" max="13:00:00" step="15" value="08:00:00" required>
                            <label for="frm-hora-fin"><span>Hora de fin</span>:&nbsp;</label>
                            <input name="frm-hora-fin" id="frm-hora-fin" type="time" min="08:00:00" max="13:00:00" step="15" value="08:00:00" required>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                            <label for="frm-informacion"><span>Información</span>:&nbsp;</label>
                            <textarea name="frm-informacion" id="frm-informacion" rows="3" maxleng="200" placeholder="Escribe aquí información adicional (Max: 200 caracteres; Opcional)..."></textarea>
                            </p>
                        </div>
                    </div>
                    <!-- Acciones permitidas por el gestor de jornadas -->
                    <div class="botonera">
                        <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=jornadas:default" title="Volver al atrás">Volver</a>
                        <button type="submit" class="boton-accion-gestor" title="Crear jornada">Crear</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                   
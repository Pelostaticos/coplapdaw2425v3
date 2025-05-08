{* Plantilla Smarty para vista de inscripción a una jornada de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> perfil: Datos para generar los detalles de la jornada.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Inscripción a jornada" usuario=$usuario}
    <!-- Contenidos de la página para la inscripción a una jornada de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Participantes de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
            <article>
                <!-- Encabezado del gestor de participantes -->
                <h1 class="titulo-accion-gestor">Inscripción a jornada</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-jornadas.png" alt="encabezado gestor jornadas"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Participantes</p>
                    </div>            
                </div>                
                <!-- Información del gestor de participantes  -->
                <form id="inscripcion-jornada" method="post" action="/plataforma/backoffice.php?comando=participantes:inscribirse:procesa">
                    <input name="frm-idjornada" id="frm-idjornada" type="hidden" value="{$perfil.idJornada}">
                    <input name="frm-usuario" id="frm-usuario" type="hidden" value="{$perfil.usuario}">
                    <input name="frm-inscripcion" id="frm-inscripcion" type="hidden" value="{$perfil.inscripcion}">
                    <input name="frm-asiste" id="frm-asiste" type="hidden" value="{$perfil.asiste}">
                    <div class="contenido-gestor">                        
                        <div class="campos-gestor">
                            <p class="extraextralargo"><span>Participante</span>:&nbsp;{$perfil.participante}</p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extralargo"><span>Titulo</span>:&nbsp;{$perfil.titulo}</p>
                            <p class="extralargo"><span>Horario</span>:&nbsp;{$perfil.horario}</p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo"><span>Lugar</span>:&nbsp;{$perfil.lugar}</p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                            <label for="frm-observacion"><span>Observaciones</span>:&nbsp;</label>
                            <textarea name="frm-observacion" id="frm-observacion" rows="3" maxleng="200" placeholder="Escribe aquí información adicional a tu participación (Max: 200 caracteres; Opcional)..."></textarea>
                            </p>
                        </div>
                    </div>
                    <!-- Acciones permitidas por el gestor de jornadas -->
                    <div class="botonera">
                        <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=participantes:default" title="Volver al atrás">Volver</a>
                        <button type="submit" class="boton-accion-gestor" title="Inscribirme a la jornada">Inscribirme</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}          
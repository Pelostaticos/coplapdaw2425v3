{* Plantilla Smarty para vista de cancelación de un censo de aves de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> perfil: Información básica sobre la jornada censal en curso
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Cancelación censo de aves" usuario=$usuario}
    <!-- Contenidos de la página para la vista de cancelación del censo de aves en la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Censos de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de Censos -->
                <h1 class="titulo-accion-gestor">Cancelación censo de aves</h1>
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-censos.png" alt="encabezado gestor censos"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Censos</p>
                    </div>            
                </div>
                <!-- A) Información del gestor de censos: Participantes y detalles básicos jornadas censal  a cancelar -->
                <div class="contenido-gestor">
                    <div class="campos-gestor">
                        <p class="extraextralargo"><span>Participantes</span>:&nbsp;{$perfil.participantes}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="extralargo"><span>Titulo</span>:&nbsp;{$perfil.titulo}</p>
                        <p class="extralargo"><span>Horario</span>:&nbsp;{$perfil.horario}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="extraextraextralargo"><span>Lugar</span>:&nbsp;{$perfil.lugar}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="extraextralargo"><span>Observaciones</span>:&nbsp;{$perfil.observaciones}</p>
                    </div>                
                </div>
                <!-- B) Información del gestor de censos: Motivos de la cancelación  -->
                <div class="contenido-gestor">
                    <!-- Formulario para exponer los motivos de cancelación de la jornada censal -->
                    <form name="cancelarCensoAves" id="cancelarCensoAves" method="post" action="/plataforma/backoffice.php?comando=censos:default">
                        <input type="hidden" name="idJornada" value="{$perfil.idJornada}">
                        <h2 class="subtitulo-contenido-gestor">Confirmación de cancelación censo aves</h2>
                        <p class="texto-contenido-gestor">Para poder cancelar la jornada censal, le pedimos que explique detalladamente las razones de su decisión 
                        en el siguiente formulario. Esta información es importante para la gestión y seguimiento de las jornadas. Si has llegado por error haz clic en rechazar. ¡Muchas gracias por participar!</p>
                        <div class="campos-gestor">
                            <p class="muyextraextraextralargo">
                                <label for="frm-motivos"><span>Motivos de cancelación</span>:&nbsp;</label>
                                <textarea name="frm-motivos" id="frm-motivos" rows="3" maxleng="200" placeholder="Escribe aquí los motivos de cancelación (Max: 200 caracteres)..." required></textarea>
                            </p>
                        </div>                        
                    </form>
                </div>                  
                <!-- Acciones permitidas por el gestor de censos -->
                <h3 class="cta">¿Estás seguro que quieres cancelar este censo?</h3>
                <div class="botonera">                    
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=censos:default" title="Rechazar cancelación censos aves">Rechazar</a>
                    <button class="boton-accion-gestor" form="cancelarCensoAves" type="submit" name="accion" value="cancelacion:confirmo" title="Confirmar cancelación censos aves">Confirmar</button>
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                                       
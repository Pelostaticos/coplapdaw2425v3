{* Plantilla Smarty para vista mostrar los detalles de una inscripción de un usuario de la plataforma
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

{include file="comunes/header.tpl" titulo="Detalles de inscripción" usuario=$usuario}
    <!-- Contenidos de la página para mostrar los detalles de una inscripción de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Participantes de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
            <article>
                <!-- Encabezado del gestor de participantes -->
                <h1 class="titulo-accion-gestor">Detalles de inscripción</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-jornadas.png" alt="encabezado gestor jornadas"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Participantes</p>
                    </div>            
                </div>                
                <!-- Información del gestor de participantes  -->
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
                        <p class="extraextralargo"><span>Observacion</span>:&nbsp;{$perfil.observacion}</p>
                    </div>
                </div>
                <!-- Acciones permitidas por el gestor de jornadas -->
                <form method="post" action="/plataforma/backoffice.php?comando=participantes:default">
                    <div class="botonera">
                        <button type="submit" class="boton-accion-gestor" name="accion" value="historico" title="Volver al histórico de participación">Volver atrás</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}          
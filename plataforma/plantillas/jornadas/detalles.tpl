{* Plantilla Smarty para vista de los detalles de una jornada de la plataforma correplayas
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
*   >> volver: URL a la que se le redirige al usuario al pulsar sobre el botón volver.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Detalles de jornada" usuario=$usuario}
    <!-- Contenidos de la página para el detalle de jornadas de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Jornadas de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de jornadas -->
                <h1 class="titulo-accion-gestor">Detalles de jornada</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-jornadas.png" alt="encabezado gestor jornadas"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Jornadas</p>
                    </div>            
                </div>                
                <!-- Información del gestor de jornadas  -->
                <div class="contenido-gestor">
                    <div class="campos-gestor">
                        <p class="largo"><span>Titulo</span>:&nbsp;{$perfil.titulo}</p>
                        <p class="corto"><span>Estado</span>:&nbsp;{$perfil.estado}</p>
                        <p class="corto"><span>Asistencia</span>:&nbsp;{$perfil.asistencia}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="extralargo"><span>Observatorio</span>:&nbsp;{$perfil.observatorio} ({$perfil.localidad})</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="corto"><span>Fecha</span>:&nbsp;{$perfil.fecha|date_format:"%d-%m-%Y"}</p>
                        <p class="largo"><span>Hora de inicio</span>:&nbsp;{$perfil.horaInicio}</p>
                        <p class="largo"><span>Hora de fin</span>:&nbsp;{$perfil.horaFin}</p>
                    </div>                     
                    <div class="campos-gestor">
                        {if $perfil.informacion === "-" || empty($perfil.informacion)}
                            <p class="extraextralargo"><span>Informacion</span>:&nbsp;Sin datos</p>
                        {else}
                            <p class="extraextralargo"><span>Informacion</span>:&nbsp;{$perfil.informacion}</p>
                        {/if}
                    </div>                 
                </div>
                <!-- Acciones permitidas por el gestor de jornadas -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="{$volver}" title="Volver al atrás">Volver</a>
                </div>
              </article>
          </section>
      </main> 
      {include file="comunes/footer.tpl" anyo="{$anyo}"}          
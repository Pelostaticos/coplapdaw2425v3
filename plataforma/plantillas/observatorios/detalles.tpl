{* Plantilla Smarty para vista de los detalles de un observatorio de la plataforma correplayas
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
*   >> volver: URL a la que se le redirige al usuario al pulsar sobre el botón volver.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Detalles de observatorio" usuario=$usuario}
    <!-- Contenidos de la página para el detalle del observatorio de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Observatorios de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de observatorios -->
                <h1 class="titulo-accion-gestor">Detalles de observatorios</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/imagenes/gestor-observatorios.png" alt="encabezado gestor observatorios"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Observatorios</p>
                    </div>            
                </div>                
                <!-- Información del gestor de observatorios  -->
                <div class="contenido-gestor">
                    <div class="campos-gestor">
                        <p class="extralargo"><span>Observatorio</span>:&nbsp;{$perfil.observatorio}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="extralargo"><span>Dirección</span>:&nbsp;{$perfil.direccion}</p>
                        <p class="largo"><span>Localidad</span>:&nbsp;{$perfil.localidad}</p>
                    </div>                    
                    <div class="campos-gestor">
                        {if $perfil.historia === "-" || empty($perfil.historia)}
                            <p class="extraextralargo"><span>Historia</span>:&nbsp;Sin datos</p>
                        {else}
                            <p class="extraextralargo"><span>Historia</span>:&nbsp;{$perfil.historia}</p>
                        {/if}
                    </div>                 
                </div>
                <!-- Acciones permitidas por el gestor de observatorios -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="{$volver}" title="Volver al atrás">Volver</a>
                    <a class="boton-accion-gestor" href="{$perfil.gps}" target="_blank" title="Ubicación en el mapa">GPS</a>
                    <a class="boton-accion-gestor" href="{$perfil.url}" target="_blank"title="Información adicional observatorio">Más Info</a>
                </div>
              </article>
          </section>
      </main> 
      {include file="comunes/footer.tpl" anyo="{$anyo}"}          
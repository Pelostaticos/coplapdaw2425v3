{* Plantilla Smarty para vista de los detalles de un ave de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> perfil: Datos para generar los detalles del ave.
*   >> volver: URL a la que se le redirige al usuario al pulsar sobre el botón volver.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Detalles de ave" usuario=$usuario}
    <!-- Contenidos de la página para el detalle del ave de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Aves de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de aves -->
                <h1 class="titulo-accion-gestor">Detalles de aves</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-aves.png" alt="encabezado gestor aves"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Aves</p>
                    </div>            
                </div>                
                <!-- Información del gestor de aves  -->
                <div class="contenido-gestor">
                    <div class="campos-gestor">
                        <p class="corto"><span>Código</span>:&nbsp;{$perfil.abreviatura}</p>
                        <p class="extralargo"><span>Especie</span>:&nbsp;{$perfil.especie}</p>                        
                    </div>
                    <div class="campos-gestor">
                        <p class="extralargo"><span>Familia</span>:&nbsp;{$perfil.familia}</p>
                        <p class="extralargo"><span>Orden</span>:&nbsp;{$perfil.orden}</p>
                    </div>                    
                    <div class="campos-gestor">
                        <p class="extralargo"><span>Nombre común</span>:&nbsp;{$perfil.comun}</p>
                        <p class="extralargo"><span>Nombre inglés</span>:&nbsp;{$perfil.ingles}</p>
                    </div>
                    <div class="campos-gestor">
                        {if $perfil.descripcion === "-" || empty($perfil.descripcion)}
                            <p class="muyextraextraextralargo"><span>Descripcion familia</span>:&nbsp;Sin datos</p>
                        {else}
                            <p class="muyextraextraextralargo"><span>Descripcion familia</span>:&nbsp;{$perfil.descripcion}</p>
                        {/if}
                    </div>                                       
                </div>
                <!-- Acciones permitidas por el gestor de ave -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="{$volver}" title="Volver al atrás">Volver</a>
                    <a class="boton-accion-gestor" href="{$perfil.url}" target="_blank"title="Información adicional ave">Más Info</a>
                </div>
              </article>
          </section>
      </main> 
      {include file="comunes/footer.tpl" anyo="{$anyo}"}          
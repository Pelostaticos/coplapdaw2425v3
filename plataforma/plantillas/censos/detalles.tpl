{* Plantilla Smarty para vista del censo de aves de la plataforma correplayas - añadir censos
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

{include file="comunes/header.tpl" titulo="Censo de aves" usuario=$usuario}
    <!-- Contenidos de la página para la vista del censo de aves en la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Censos de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de Censos -->
                <h1 class="titulo-accion-gestor">Censo de aves</h1>
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-censos.png" alt="encabezado gestor censos"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Censos</p>
                    </div>            
                </div>
                <!-- A) Información del gestor de censos.  -->
                <div class="contenido-gestor">
                    <!-- Encabezado del formulario para la edición de registros censales de la jornada -->
                    <h2 class="subtitulo-contenido-gestor">Detalles del registro censal</h2>
                    <p class="texto-contenido-gestor">Esta vista te muestra todos los detalles de un registro. ¡Muchas gracias por participar!</p>
                    <!-- Campos del formulario para añadir registros censales de la jornada -->
                    <div class="campos-gestor">
                        <p class="corto"><span>Hora</span>:&nbsp;{$perfil.hora}</p>
                        <p class="largo"><span>Especie</span>:&nbsp;{$perfil.especie}</p>
                        <p class="largo"><span>Familia</span>:&nbsp;{$perfil.familia}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="largo"><span>Orden</span>:&nbsp;{$perfil.orden}</p>
                        <p class="largo"><span>Cantidad</span>:&nbsp;{$perfil.cantidad}</p>
                    </div> 
                    <div class="campos-gestor">
                        <p class="largo"><span>Nubosidad</span>:&nbsp;{$perfil.nubosidad}</p>
                        <p class="largo"><span>Visibilidad</span>:&nbsp;{$perfil.visibilidad}</p>
                        <p class="largo"><span>Dirección viento</span>:&nbsp;{$perfil.dirviento}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="largo"><span>Velocidad viento</span>:&nbsp;{$perfil.velviento}</p>
                        <p class="corto"><span>Procedencia</span>:&nbsp;{$perfil.procedencia}</p>
                        <p class="corto"><span>Destino</span>:&nbsp;{$perfil.destino}</p>
                        <p class="largo"><span>Altura vuelo</span>:&nbsp;{$perfil.altvuelo}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="extralargo"><span>Formación de vuelo</span>:&nbsp;{$perfil.formavuelo}</p>
                        <p class="extralargo"><span>Distancia a costa</span>:&nbsp;{$perfil.distcosta}</p>
                    </div>
                    <div class="campos-gestor">
                        <p class="extraextraextralargo"><span>Comentario</span>:&nbsp;{$perfil.comentario}</p>
                    </div>                                          
                </div>                  
                <!-- Acciones permitidas por el gestor de censos -->
                <form name="volverCensoAves" id="volverCensoAves" method="post" action="/plataforma/backoffice.php?comando=censos:default"></form>
                <div class="botonera">                
                    <button class="boton-accion-gestor" form="volverCensoAves" type="submit" name="accion" value="censo:volver" title="Volver al censo">Volver</button>
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}     
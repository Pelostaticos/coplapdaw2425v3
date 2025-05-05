{* Plantilla Smarty para vista del listado de jornadas abiertas al censo de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> filas: Conjunto de datos para generar el listado.
*   >> hoy: Fecha del día presente para la información al usuario.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Jornadas censales" usuario=$usuario}
    <!-- Contenidos de la página para el listado de jornadas para el censo de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Censos de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de Censos -->
                <h1 class="titulo-accion-gestor">Jornadas censales</h1>
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-censos.png" alt="encabezado gestor censos"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Censos</p>
                    </div>            
                </div>                
                <!-- Información del gestor de censos  -->
                <div class="contenido-gestor">
                    <!-- Encabezado del listado con los registros censales de la jornada -->
                    <h2 class="subtitulo-contenido-gestor">Listado de jornada(s) disponibles hoy para el censo de aves</h2>
                    <p class="texto-contenido-gestor">Se presentan las jornadas habilitadas para el censo de aves en la fecha actual, del [{$hoy}]. 
                    Por favor, seleccione su jornada asignada para acceder a la información o registrar su participación. Además como responsable
                    dispone de las acciones esenciales para llevarla a cabo, que disfrutes. ¡Muchas gracias por participar!</p>                               
                    <!-- Tabla que representa al listado de jornadas para el censo -->
                    <table id="listado-gestor">
                        <!-- Cabecera del listado de jornadas para el censo -->
                        <thead>
                            <th>Titulo</th>
                            <th>Observatorio</th>
                            <th>Localidad</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </thead>
                        <!-- Contenido del listado de jornadas para el censo -->
                        <tbody>
                            {if $filas|@count === 0}
                                <tr>
                                    <td colspan="5">Lo sentimos!!! No hay jornadas disponibles para censar</td>
                                </tr>
                            {else}                        
                                {foreach $filas as $fila}
                                    <!-- Fila con los datos de cada jornada para el censo  -->
                                    <tr>
                                        <!-- Celdas con datos de cada jornada para el censo -->
                                        <td>{$fila.jornada->getTituloJornada()}</td>
                                        <td>{$fila.observatorio}</td>
                                        <td>{$fila.localidad}</td>
                                        <td>{$fila.jornada->getFechaJornada()|date_format:"%d-%m-%Y"}</td>
                                        <!-- Celda con acciones permitidas para cada jornada para el censo  -->
                                        <td>
                                            <form method="post" action="/plataforma/backoffice.php?comando=censos:default">
                                                <input type="hidden" name="idJornada" value="{$fila.jornada->getIdJornada()}">
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="listado:detalles" title="Mostrar detalles jornada censal"><span class="iconos-acciones-listados">search</span></button>
                                                {if $fila.jornada->tieneJornadaParticipantes()}
                                                    {if $fila.jornada->esJornadaIniciada()}
                                                        <button class="boton-accion-listado-gestor" type="submit" name="accion" value="listado:continuar:censo" title="Continuar censo de aves"><span class="iconos-acciones-listados">not_started</span></button>
                                                    {else}
                                                        <button class="boton-accion-listado-gestor" type="submit" name="accion" value="listado:iniciar:censo" title="Iniciar censo de aves"><span class="iconos-acciones-listados">play_circle</span></button>
                                                    {/if}
                                                {/if}
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="listado:cancelar:censo" title="Cancelar censo de aves"><span class="iconos-acciones-listados">cancel</span></button>
                                            </form>
                                        </td>
                                    </tr>
                                {/foreach}
                            {/if}
                        </tbody>
                     </table>
                </div>
                <!-- Acciones permitidas por el gestor de censos -->
                <div class="botonera">
                    <form name="volverJornadasCensales" id="volverJornadasCensales" method="post" action="/plataforma/backoffice.php?comando=censos:default">
                        <button form="volverJornadasCensales" type="submit" class="boton-accion-gestor" name="accion" value="listado:salir" title="Volver al histórico de censos">Volver</button>
                    </form>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
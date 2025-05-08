{* Plantilla Smarty para vista del listado de jornadas abiertas a inscripción de la plataforma correplayas
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
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Jornadas para inscripción" usuario=$usuario}
    <!-- Contenidos de la página para el listado de jornadas para inscripción de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Participantes de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de Participantes -->
                <h1 class="titulo-accion-gestor">Jornadas para inscripción</h1>
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-participantes.png" alt="encabezado gestor participantes"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Participantes</p>
                    </div>            
                </div>                
                <!-- Información del gestor de particpantes  -->
                <div class="contenido-gestor">
                    <!-- Bóton para la acción de mostrar el histórico de participación en la plataforma -->
                    <div class="botonera-superior-listados">
                        <form method="post" action="/plataforma/backoffice.php?comando=participantes:default">
                            <button class="boton-accion-gestor" type="submit" name="accion" value="historico" title="Abre el histótico de participación del usuario">Ver Historicos</button>
                            {if $permisosUsuario->hasPermisoAdministradrGestor()}
                                <button class="boton-accion-gestor" type="submit" name="accion" value="adminparticipa:entrar" title="Abre el modo participantes">Ver Participantes</button>
                            {/if}
                        </form>
                    </div>                    
                    <!-- Tabla que representa al listado de jornadas para inscripción -->
                    <table id="listado-gestor">
                        <!-- Cabecera del listado de jornadas para inscripción -->
                        <thead>
                            <th>Titulo</th>
                            <th>Observatorio</th>
                            <th>Localidad</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </thead>
                        <!-- Contenido del listado de jornadas para inscripción -->
                        <tbody>
                            {if $filas|@count === 0}
                                <tr>
                                    <td colspan="5">Lo sentimos!!! No hay jornadas disponibles a inscripción</td>
                                </tr>
                            {else}                        
                                {foreach $filas as $fila}
                                    <!-- Fila con los datos de cada jornada de inscripción  -->
                                    <tr>
                                        <!-- Celdas con datos de cada jornada de inscripción -->
                                        <td>{$fila.titulo}</td>
                                        <td>{$fila.observatorio}</td>
                                        <td>{$fila.localidad}</td>
                                        <td>{$fila.fecha|date_format:"%d-%m-%Y"}</td>
                                        <!-- Celda con acciones permitidas para cada jornada de inscripción  -->
                                        <td>
                                            <form method="post" action="/plataforma/backoffice.php?comando=participantes:default">
                                                <input type="hidden" name="idJornada" value="{$fila.idJornada}">
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="detalles" title="Mostrar detalles jornada a inscribirse"><span class="iconos-acciones-listados">search</span></button>
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="inscribirse" title="Inscribirse a la jornada"><span class="iconos-acciones-listados">person_add</span></button>                                                
                                            </form>
                                        </td>
                                    </tr>
                                {/foreach}
                            {/if}
                        </tbody>
                     </table>
                </div>
                <!-- Acciones permitidas por el gestor de participantes -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php" title="Volver al inicio">Volver</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
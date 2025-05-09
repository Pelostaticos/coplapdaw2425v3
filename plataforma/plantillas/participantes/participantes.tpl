{* Plantilla Smarty para vista del listado participantes de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> modoListadoUsuarios: Bandera control del formato del listado de la plantilla
*       |-> Verdadero: El listado muestra su configración para listar usuarios
*       \-> Falso: El listado muestra su configuración para listar participantes
*   >> filas: Conjunto de datos para generar el listado.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Listado participantes" usuario=$usuario}
    <!-- Contenidos de la página para el listado de jornadas para inscripción de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Participantes de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de Participantes -->
                <h1 class="titulo-accion-gestor">Listado participantes</h1>
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-participantes.png" alt="encabezado gestor participantes"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Participantes</p>
                    </div>            
                </div>                
                <!-- Información del gestor de particpantes  -->
                <div class="contenido-gestor">
                    <!-- Encabezado del listado los usuarios participantes de la plataforma -->
                    {if $modoListadoParticipantes}
                        <h2 class="subtitulo-contenido-gestor">Listado de usuarios participantes/h2>
                        <p class="texto-contenido-gestor">A continuación, se muestra el listado de usuarios confirmados como participantes
                        en las jornadas censales de la plataforma. Utilice esta vista para administrar los detalles de su inscripción, su 
                        estado de asistencia y cualquier acción específica relacionada con su participación activa en los censos. ¡Muchas gracias por participar!</p>                               
                    {else}
                        <h2 class="subtitulo-contenido-gestor">Listado de usuarios plataforma</h2>
                        <p class="texto-contenido-gestor">A continuación, se muestra el listado de usuarios actualmente registrados en la plataforma. 
                        Utilice esta vista para administrar los detalles de su inscripción, su estado de asistencia y cualquier acción específica 
                        relacionada con su participación activa en los censos. ¡Muchas gracias por participar!</p>                      
                    {/if}
                    <!-- Bóton para la acción de mostrar el histórico de participación en la plataforma -->
                    <div class="botonera-superior-listados">
                        <!-- Formulario para busqueda y orden en el histórico de participación de un usuario  -->
                        <form id="modo-listado" name="modo-listado" method="post" action="/plataforma/backoffice.php?comando=participantes:default">
                            <button type="submit" name="modoListado" value="false" class="boton-accion-gestor">Participantes</button>
                            <button type="submit" name="modoListado" value="true" class="boton-accion-gestor">Usuarios</button>
                        </form>                    
                    </div>
                    <!-- Tabla que representa al listado de jornadas para inscripción -->
                    <table id="listado-gestor">
                        <!-- Cabecera del listado de jornadas para inscripción -->
                        {if $modoListadoUsuarios}
                            <thead>
                                <th>Usuario</th>
                                <th>Localidad</th>
                                <th>Rol</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </thead>
                        {else}
                            <thead>
                                <th>Usuario</th>
                                <th>Localidad</th>
                                <th>Inscripciones</th>
                                <th>Ultima participación</th>
                                <th>Acciones</th>                            
                            </thead>
                        {/if}
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
                                        <td>{$fila.usuario}</td>
                                        <td>{$fila.localidad}</td>
                                        <td>{$fila.extra1}</td>
                                        <td>{$fila.extra2}</td>
                                        <!-- Celda con acciones permitidas para cada jornada de inscripción  -->
                                        <td>
                                            <form method="post" action="/plataforma/backoffice.php?comando=participantes:default">
                                                <input type="hidden" name="hashParticipante" value="{$fila.hashParticipante}">
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="adminparticipa:detalles" title="Mostrar detalles participante"><span class="iconos-acciones-listados">search</span></button>
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="adminparticipa:historico" title="Mostrar historico participante"><span class="iconos-acciones-listados">event</span></button>                                                
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="adminparticipa:inscribirse" title="Inscribir al participante"><span class="iconos-acciones-listados">person_add</span></button>
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
                    <form name="volverParticipantes" id="volverParticipantes" method="post" action="/plataforma/backoffice.php?comando=participantes:default">
                        <button form="volverParticipantes" type="submit" class="boton-accion-gestor" name="accion" value="adminparticipa:volver" title="Volver a jornadas inscripción">Volver</button>
                    </form>
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                

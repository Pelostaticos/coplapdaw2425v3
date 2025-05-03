{* Plantilla Smarty para vista del censo de aves de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> censable: Bandera que controla la visibilidad de acciones al usuario cuando una jornada es censable
*   >> perfil: Información básica sobre la jornada censal en curso
*   >> filas: Conjunto de datos para generar el listado.
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
                <!-- A) Información del gestor de censos: Participantes y detalles básicos jornadas censal  -->
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
                <!-- B) Información del gestor de censos: Listado de registros censales de la jornada  -->
                <div class="contenido-gestor">
                    <!-- Encabezado del listado con los registros censales de la jornada -->
                    <h2 class="subtitulo-contenido-gestor">Registros censales de la jornada</h2>
                    <p class="texto-contenido-gestor">Se pone a disposición el listado detallado de los registros censales pertenecientes a la 
                    jornada del [{$perfil.fecha}]. La información contenida en este listado es exhaustiva y representa la totalidad de los registros 
                    para este periodo. Además se le presentan las acciones permitidas para su rol dentro de la plataforma.</p>
                    <!-- Si la jornada es censable muestro la botonera superior del listado de registros censales -->
                    {if $censable}
                        <!-- Bóton para la acción de mostrar el listado de registros censales de la jornada en la plataforma -->
                        <div class="botonera-superior-listados">
                            <form method="post" action="/plataforma/backoffice.php?comando=censos:default">
                                <button class="boton-accion-gestor" type="submit" name="accion" value="censo:registrar" title="Añade registro censal del ave">Añadir censo</button>
                                <button class="boton-accion-gestor" type="submit" name="accion" value="censo:asistencia" title="Confirmar asistencia jornada censal">Asistencia</button>
                            </form>
                        </div>
                    {/if}                  
                    <!-- Tabla que representa al listado de registros censales de la jornada en la plataforma -->
                    <table id="listado-gestor">
                        <!-- Cabecera del listado de registros censales de la jornada en la plataforma -->
                        <thead>
                            <th>Codigo</th>
                            <th>Hora</th>                            
                            <th>Nombre común</th>
                            <th>Especie</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </thead>
                        <!-- Contenido del listado de registros censales de la jornada en la plataforma -->
                        <tbody>
                            {if $filas|@count === 0}
                                <tr>
                                    <td colspan="5">Lo sentimos!!! No hay registros censales disponibles</td>
                                </tr>
                            {else}                        
                                {foreach $filas as $fila}
                                    <!-- Fila con los datos de cada registro censal  -->
                                    <tr>
                                        <!-- Celdas con datos de cada registro censal -->
                                        <td>{$fila.codigo}</td>
                                        <td>{$fila.hora}</td>
                                        <td>{$fila.comun}</td>
                                        <td>{$fila.especie}</td>
                                        <td>{$fila.cantidad}</td>
                                        <!-- Celda con acciones permitidas para cada registro  -->
                                        <td>
                                            <form method="post" action="/plataforma/backoffice.php?comando=censos:default">
                                                <input type="hidden" name="idJornada" value="{$fila.idJornada}">
                                                <input type="hidden" name="especie" value="{$fila.especie}">
                                                <input type="hidden" name="hora" value="{$fila.hora}">
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="censo:detalles" title="Mostrar detalles jornada censal"><span class="iconos-acciones-listados">search</span></button>
                                                {if $censable}
                                                    <button class="boton-accion-listado-gestor" type="submit" name="accion" value="censo:edicion" title="Actualizar registro censal"><span class="iconos-acciones-listados">edit</span></button>
                                                    <button class="boton-accion-listado-gestor" type="submit" name="accion" value="censo:borrado" title="Eliminar registro censal"><span class="iconos-acciones-listados">delete</span></button>
                                                {/if}
                                            </form>
                                        </td>
                                    </tr>
                                {/foreach}
                            {/if}
                        </tbody>
                     </table>
                </div>                  
                <!-- Acciones permitidas por el gestor de censos -->
                <form name="volverCensoAves" id="volverCensoAves" method="post" action="/plataforma/backoffice.php?comando=censos:default"></form>
                <div class="botonera">                
                    {if $censable}
                        <button class="boton-accion-gestor" form="volverCensoAves" type="submit" name="accion" value="censo:salir" title="Salir del censo">Salir</button>
                        <button class="boton-accion-gestor" form="volverCensoAves" type="submit" name="accion" value="censo:finalizar" title="Finalizar el censo">Finalizar</button>
                    {else}
                        <button class="boton-accion-gestor" form="volverCensoAves" type="submit" name="accion" value="censo:salir" title="Salir del censo">Salir</button>
                    {/if}                    
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                
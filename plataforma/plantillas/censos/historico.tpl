{* Plantilla Smarty para vista del histórico de censos de la plataforma correplayas
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
*   >> filas: Conjunto de datos para generar el listado.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Histórico de censos" usuario=$usuario}
    <!-- Contenidos de la página para el histórico de censos de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Censos de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de Censos -->
                <h1 class="titulo-accion-gestor">Histórico de censos</h1>
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/imagenes/gestor-censos.png" alt="encabezado gestor censos"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Censos</p>
                    </div>            
                </div>                
                <!-- Información del gestor de censos  -->
                <div class="contenido-gestor">
                    <!-- Formulario para busqueda y orden en el histórico de participación de un usuario  -->
                    <form id="busqueda-gestor" name="busqueda-gestor" method="post" action="/plataforma/backoffice.php?comando=censos:filtrar">
                        <p class="corto">
                            <label for="frm-busqueda">Busqueda</label>:&nbsp;
                            <input type="text" id="frm-busqueda" name="frm-busqueda" placeholder="Busqueda de censos...">
                        </p>
                        <p class="medio">
                            <label for="frm-ordenarpor">Ordenar por</label>:&nbsp;
                            <select id="frm-ordenarpor" name="frm-ordenarpor">
                                <option value="">ninguno</option>
                                <option value="comun">comun</option>                                    
                                <option value="ingles">ingles</option>
                                <option value="especie">especie</option>
                                <option value="familia">familia</option>
                                <option value="observatorio">observatorio</option>
                                <option value="localidad">localidad</option>
                            </select>
                        </p>
                        <p class="corto">
                            <label for="frm-orden">Orden</label>:&nbsp;
                            <select id="frm-orden" name="frm-orden">
                                <option value="">ninguno</option>
                                <option value="ASC">ascendente</option>                                    
                                <option value="DESC">descendente</option>
                            </select>
                        </p>
                        <p class="corto"><button type="submit" class="boton-accion-gestor">Buscar</button></p>
                        <small><span>RECUERDA</span>:&nbsp;Puedes hacer búsqueda de censos por el nombre común del ave, nombre en inglés del ave, especie, familia, observatorio, localidad, fecha, 
                        rango de fechas. El formato para fecha única es DD-MM-YYYY, mientras que el formato para el rango de fechas es DD-MM-YYYY a DD-MM-YYYYY. Para
                        filtrar por realizada debes usar el término realizada:si o realizada:no.</small>
                    </form>
                    <!-- Compruebo si el usuario logueado tiene permiso de acceso al modo restringido del gestor de censos -->
                    {if ($permisosUsuario->hasPermisoGestorCensos())}
                        <!-- Bóton para la acción de mostrar el histórico de censos en la plataforma -->
                        <div class="botonera-superior-listados">
                            <form method="post" action="/plataforma/backoffice.php?comando=censos:default">
                                <button class="boton-accion-gestor" type="submit" name="accion" value="historico:censar" title="Abre el listado de jornadas censales">Censar aves</button>
                            </form>
                        </div>
                    {{/if}}                                      
                    <!-- Tabla que representa al histórico de censos -->
                    <table id="listado-gestor">
                        <!-- Cabecera del histórico de censos -->
                        <thead>
                            <th>Titulo</th>
                            <th>Observatorio</th>
                            <th>Fecha</th>
                            <th>Registros</th>
                            <th>Censadas</th>
                            <th>Acciones</th>
                        </thead>
                        <!-- Contenido del histórico de censos -->
                        <tbody>
                            {if $filas|@count === 0}
                                <tr>
                                    <td colspan="5">Lo sentimos!!! No hay histórico de censos que mostrarle!!!</td>
                                </tr>
                            {else}                        
                                {foreach $filas as $fila}
                                    <!-- Fila con los datos de cada inscripción del histórico de censos  -->
                                    <tr>
                                        <!-- Celdas con datos de cada inscripción del histórico de censos -->
                                        <td>{$fila.jornada->getTituloJornada()}</td>
                                        <td>{$fila.observatorio}</td>
                                        <td>{$fila.jornada->getFechaJornada()|date_format:"%d-%m-%Y"}</td>
                                        <td>{$fila.registros}</td>
                                        <td>{$fila.censadas}</td>
                                        <!-- Celda con acciones permitidas para cada jornada del histórico de censos  -->
                                        <td>
                                            <form method="post" action="/plataforma/backoffice.php?comando=censos:default">
                                                <input type="hidden" name="idJornada" value="{$fila.jornada->getIdJornada()}">
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="historico:detalles" title="Mostrar detalles de un censo"><span class="iconos-acciones-listados">search</span></button>
                                                {if $fila.jornada->esJornadaCensable($permisosUsuario)}
                                                    <button class="boton-accion-listado-gestor" type="submit" name="accion" value="historico:edicion" title="Editar censo de aves"><span class="iconos-acciones-listados">edit</span></button>                                                    
                                                    {if $fila.jornada->esJornadaIniciada()}
                                                        <button class="boton-accion-listado-gestor" type="submit" name="accion" value="historico:cierre" title="Finalizar censo de aves"><span class="iconos-acciones-listados">stop_circle</span></button>
                                                        <button class="boton-accion-listado-gestor" type="submit" name="accion" value="historico:cancelar" title="Cancelar censo de aves"><span class="iconos-acciones-listados">cancel</span></button>                                                        
                                                    {/if}                                                    
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
                <div class="botonera">
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php" title="Vuelve al inicio del backoffice">Salir</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
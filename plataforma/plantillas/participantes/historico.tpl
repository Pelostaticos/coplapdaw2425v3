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

{include file="comunes/header.tpl" titulo="Histórico de participación" usuario=$usuario}
    <!-- Contenidos de la página para el listado de jornadas para inscripción de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Participantes de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de Participantes -->
                <h1 class="titulo-accion-gestor">Histórico de participación</h1>
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-participantes.png" alt="encabezado gestor participantes"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Participantes</p>
                    </div>            
                </div>                
                <!-- Información del gestor de particpantes  -->
                <div class="contenido-gestor">
                    <!-- Formulario para busqueda y orden en el listado de jornadas  -->
                    <form id="busqueda-gestor" name="busqueda-gestor" method="post" action="/plataforma/backoffice.php?comando=jornadas:filtrar">
                        <p class="corto">
                            <label for="frm-busqueda">Busqueda</label>:&nbsp;
                            <input type="text" id="frm-busqueda" name="frm-busqueda" placeholder="Busqueda de inscripciones...">
                        </p>
                        <p class="medio">
                            <label for="frm-ordenarpor">Ordenar por</label>:&nbsp;
                            <select id="frm-ordenarpor" name="frm-ordenarpor">
                                <option value="">ninguno</option>
                                <option value="titulo">titulo</option>                                    
                                <option value="observatorio">observatorio</option>
                                <option value="estado">estado</option>                                    
                                <option value="fecha">fecha</option>                                    
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
                    </form>                                   
                    <!-- Tabla que representa al listado de jornadas para inscripción -->
                    <table id="listado-gestor">
                        <!-- Cabecera del listado de jornadas para inscripción -->
                        <thead>
                            <th>Titulo</th>
                            <th>Inscrito</th>
                            <th>Programada</th>
                            <th>Realizada</th>
                            <th>Acciones</th>
                        </thead>
                        <!-- Contenido del listado de jornadas para inscripción -->
                        <tbody>
                            {if $filas|@count === 0}
                                <tr>
                                    <td colspan="5">Lo sentimos!!! No hay histórico de participación que mostrarle!!!</td>
                                </tr>
                            {else}                        
                                {foreach $filas as $fila}
                                    <!-- Fila con los datos de cada jornada de inscripción  -->
                                    <tr>
                                        <!-- Celdas con datos de cada jornada de inscripción -->
                                        <td>{$fila.titulo}</td>
                                        <td>{$fila.inscrito}</td>
                                        <td>{$fila.programada}</td>
                                        <td>{$fila.realizada}</td>
                                        <!-- Celda con acciones permitidas para cada jornada de inscripción  -->
                                        <td>
                                            <form method="post" action="/plataforma/backoffice.php?comando=participantes:default">
                                                <input type="hidden" name="idJornada" value="{$fila.idJornada}">
                                                <button class="boton-accion-listado-gestor" type="submit" name="accion" value="detalles" title="Mostrar detalles de participación"><span class="iconos-acciones-listados">search</span></button>
                                                {if $fila.realizada === 'NO'}
                                                    <button class="boton-accion-listado-gestor" type="submit" name="accion" value="actualizar" title="Actualizar inscripción"><span class="iconos-acciones-listados">edit</span></button>
                                                    <button class="boton-accion-listado-gestor" type="submit" name="accion" value="eliminar" title="Eliminar inscripción"><span class="iconos-acciones-listados">delete</span></button>                                                    
                                                {/if}
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
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=participantes:default" title="Volver al inicio">Volver</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
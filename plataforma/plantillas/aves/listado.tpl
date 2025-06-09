{* Plantilla Smarty para vista del listado de aves de la plataforma correplayas
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

{include file="comunes/header.tpl" titulo="Listado de aves" usuario=$usuario}
    <!-- Contenidos de la página para el listado de aves de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Aves de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de aves -->
                <h1 class="titulo-accion-gestor">Listado de aves</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/imagenes/gestor-aves.png" alt="encabezado gestor aves"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Aves</p>
                    </div>            
                </div>                
                <!-- Información del gestor de aves  -->
                <div class="contenido-gestor">
                    <!-- Formulario para busqueda y orden en el listado de aves  -->
                    <form id="busqueda-gestor" name="busqueda-gestor" method="post" action="/plataforma/backoffice.php?comando=aves:filtrar">
                        <p class="corto">
                            <label for="frm-busqueda">Busqueda</label>:&nbsp;
                            <input type="text" id="frm-busqueda" name="frm-busqueda" placeholder="Busqueda de aves...">
                        </p>
                        <p class="medio">
                            <label for="frm-ordenarpor">Ordenar por</label>:&nbsp;
                            <select id="frm-ordenarpor" name="frm-ordenarpor">
                                <option value="">ninguno</option>
                                <option value="especie">especie</option>                                    
                                <option value="familia">familia</option>
                                <option value="comun">comun</option>
                                <option value="ingles">ingles</option>
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
                        <small><span>RECUERDA</span>:&nbsp;Puedes hacer búsqueda de aves por especie, familia, nombre común y nombre ingles.</small>
                    </form>                    
                    <!-- Bóton para la acción de registrar una nueva ave en la plataforma -->
                    <div class="botonera-superior-listados">
                        <a class="boton-accion-superior" href="/plataforma/backoffice.php?comando=aves:registrar:vista" title="Añadir una nueva ave a la plataforma">Añadir ave</a>                    
                    </div>                    
                    <!-- Tabla que representa al listado de aves -->
                     <table id="listado-gestor">
                        <!-- Cabecera del listado de aves -->
                        <thead>
                            <th>Especie</th>
                            <th id="familia">Familia</th>
                            <th id="comun">Nombre común</th>
                            <th>Acciones</th>
                        </thead>
                        <!-- Contenido del listado de aves -->
                        <tbody>
                            {if $filas|@count === 0}
                                <tr>
                                    <td colspan="4">Lo sentimos!!! No hay aves disponibles para listar</td>
                                </tr>
                            {else} 
                                {foreach $filas as $fila}
                                <!-- Fila con los datos de cada ave  -->
                                <tr>
                                    <!-- Celdas con datos de cada ave -->
                                    <td>{$fila.especie}</td>
                                    <td class="visibilidad">{$fila.familia}</td>
                                    <td class="visibilidad">{$fila.comun}</td>
                                    <!-- Celda con acciones permitidas para cada ave  -->
                                    <td>
                                        <form method="post" action="/plataforma/backoffice.php?comando=aves:default">
                                            <input type="hidden" name="especie" value="{$fila.especie}">
                                            <button class="boton-accion-listado-gestor" type="submit" name="accion" value="consultar" title="Mostrar detalles"><span class="iconos-acciones-listados">search</span></button>
                                            <button class="boton-accion-listado-gestor" type="submit" name="accion" value="actualizar" title="Actualizar ave"><span class="iconos-acciones-listados">edit</span></button>
                                            <button class="boton-accion-listado-gestor" type="submit" name="accion" value="eliminar" title="Eliminar ave"><span class="iconos-acciones-listados">delete</span></button>
                                        </form>
                                    </td>
                                </tr>
                                {/foreach}
                            {/if}
                        </tbody>
                     </table>
                </div>
                <!-- Acciones permitidas por el gestor de aves -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php" title="Volver al inicio">Volver</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
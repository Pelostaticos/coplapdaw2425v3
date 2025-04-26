{* Plantilla Smarty para vista del listado de observatorios de la plataforma correplayas
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

{include file="comunes/header.tpl" titulo="Listado de observatorios" usuario=$usuario}
    <!-- Contenidos de la página para el listado de observatorios de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Observatorios de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de observatorios -->
                <h1 class="titulo-accion-gestor">Listado de observatorios</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-observatorios.png" alt="encabezado gestor observatorios"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Observatorios</p>
                    </div>            
                </div>                
                <!-- Información del gestor de observatorios  -->
                <div class="contenido-gestor">
                    <!-- Formulario para busqueda y orden en el listado de observatorios  -->
                    <form id="busqueda-gestor" name="busqueda-gestor" method="post" action="/plataforma/backoffice.php?comando=observatorios:filtrar">
                        <p class="corto">
                            <label for="frm-busqueda">Busqueda</label>:&nbsp;
                            <input type="text" id="frm-busqueda" name="frm-busqueda" placeholder="Busqueda de jornadas...">
                        </p>
                        <p class="medio">
                            <label for="frm-ordenarpor">Ordenar por</label>:&nbsp;
                            <select id="frm-ordenarpor" name="frm-ordenarpor">
                                <option value="">ninguno</option>
                                <option value="nombre">nombre</option>                                    
                                <option value="direccion">direccion</option>
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
                        <small><span>RECUERDA</span>:&nbsp;Puedes hacer búsqueda de observatorios por su nombre, dirección y localidad.</small>
                    </form>                    
                    <!-- Bóton para la acción de registrar uno nuevo observatorio en la plataforma -->
                    <div class="botonera-superior-listados">
                        <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=observatorio:registrar:vista" title="Añadir un nuevo observatorio a la plataforma">Añadir observatorio</a>                    
                    </div>                    
                    <!-- Tabla que representa al listado de observatorios -->
                     <table id="listado-gestor">
                        <!-- Cabecera del listado de observatorios -->
                        <thead>
                            <th>Observatorio</th>
                            <th id="direccion">Direccion</th>
                            <th id="localidad">Localidad</th>
                            <th>Acciones</th>
                        </thead>
                        <!-- Contenido del listado de observatorios -->
                        <tbody>
                            {foreach $filas as $fila}
                            <!-- Fila con los datos de cada observatorio  -->
                            <tr>
                                <!-- Celdas con datos de cada observatorio -->
                                <td>{$fila.nombre}</td>
                                <td class="visibilidad">{$fila.direccion}</td>
                                <td class="visibilidad">{$fila.localidad}</td>
                                <!-- Celda con acciones permitidas para cada observatorio  -->
                                <td>
                                    <form method="post" action="/plataforma/backoffice.php?comando=observatorios:default">
                                        <input type="hidden" name="codigo" value="{$fila.codigo}">
                                        <button class="boton-accion-listado-gestor" type="submit" name="accion" value="consultar" title="Mostrar detalles"><span class="iconos-acciones-listados">search</span></button>
                                        <button class="boton-accion-listado-gestor" type="submit" name="accion" value="actualizar" title="Actualizar observatorio"><span class="iconos-acciones-listados">edit</span></button>
                                        <button class="boton-accion-listado-gestor" type="submit" name="accion" value="eliminar" title="Eliminar observatorio"><span class="iconos-acciones-listados">delete</span></button>
                                    </form>
                                </td>
                            </tr>
                            {/foreach}
                        </tbody>
                     </table>
                </div>
                <!-- Acciones permitidas por el gestor de observatorioss -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php" title="Volver al inicio">Volver</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
{* Pantilla Smarty para página inicio del backoffice de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Listado de usuarios" usuario=$usuario}
    <!-- Contenidos de la página para el listado de usuarios de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Usuarios de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de usuarios -->
                <h1 class="titulo-accion-gestor">Listado de usuarios</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-usuarios.png" alt="encabezado gestor usuarios"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Usuarios</p>
                    </div>            
                </div>                
                <!-- Información del gestor de usuarios  -->
                <div class="contenido-gestor">
                    <!-- Formulario para busqueda y orden en el listado de usuarios  -->
                    <form id="busqueda-gestor" name="busqueda-gestor" method="post" action="/plataforma/backoffice.php?comando=usuarios:filtrar">
                        <p class="corto">
                            <label for="frm-busqueda">Busqueda</label>:&nbsp;
                            <input type="text" id="frm-busqueda" name="frm-busqueda" placeholder="Busqueda de usuarios...">
                        </p>
                        <p class="medio">
                            <label for="frm-ordenarpor">Ordenar por</label>:&nbsp;
                            <select id="frm-ordenarpor" name="frm-ordenarpor">
                                <option value="" selected>ninguno</option>
                                <option value="estado">estado</option>                                    
                                <option value="nombre">nombre</option>
                                <option value="rol">rol</option>                                    
                                <option value="usuario">usuario</option>                                    
                            </select>
                        </p>
                        <p class="corto">
                            <label for="frm-orden">Orden</label>:&nbsp;
                            <select id="frm-orden" name="frm-orden">
                                <option value="" selected>ninguno</option>
                                <option value="ASC">ascendente</option>                                    
                                <option value="DESC">descendente</option>
                            </select>
                        </p>
                        <p class="corto"><button type="submit" class="boton-accion-gestor">Buscar</button></p>                                             
                    </form>
                    <!-- Tabla que representa al listado de usuarios -->
                     <table id="listado-gestor">
                        <!-- Cabecera del listado de usuarios -->
                        <thead>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Rol</th>
                            <th>Acciones disponibles</th>
                        </thead>
                        <!-- Contenido del listado de usuarios -->
                        <tbody>
                            {foreach $filas as $fila}
                            <!-- Fila con los datos de cada usuario  -->
                            <tr>
                                <!-- Celdas con datos de cada usuario -->
                                <td>{$fila.usuario}</td>
                                <td>{$fila.nombre}</td>
                                <td>{$fila.estado}</td>
                                <td>{$fila.rol}</td>
                                <!-- Celda con acciones permitidas para cada usuario  -->
                                <td>
                                    <form method="post" action="/plataforma/backoffice.php?comando=usuarios:default">
                                        <input type="hidden" name="hashusuario" value="{$fila.hashusuario}">
                                        <button class="boton-accion-gestor" type="submit" name="accion" value="consultar"><span class="iconos-nav-backoffice">search</span></button>
                                        <button class="boton-accion-gestor" type="submit" name="accion" value="actualizar"><span class="iconos-nav-backoffice">edit</span></button>
                                        <button class="boton-accion-gestor" type="submit" name="accion" value="eliminar"><span class="iconos-nav-backoffice">delete</span></button>
                                        <button class="boton-accion-gestor" type="submit" name="accion" value="activar"><span class="iconos-nav-backoffice">check_box</span></button>
                                        <button class="boton-accion-gestor" type="submit" name="accion" value="desactivar"><span class="iconos-nav-backoffice">check_box_outline</span></button>
                                        <button class="boton-accion-gestor" type="submit" name="accion" value="password"><span class="iconos-nav-backoffice">vpn_key</span></button>
                                    </form>
                                </td>
                            </tr>
                            {/foreach}
                        </tbody>
                     </table>
                </div>
                <!-- Acciones permitidas por el gestor de usuario -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=usuarios:consultar" title="Mostrar mi perfil de usuario">Mi perfil</a>
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php" title="Volver al inicio">Volver</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
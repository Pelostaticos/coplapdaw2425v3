{* Pantilla Smarty para página de edición del perfil de usuario de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> perfil: Datos del perfil de usuario.
*   >> estadosPerfil: Array asociativos con todos los estado posibles de un perfil en la plataforma
*   >> rolesPlataforma: Array asociativo con todos los roles disponibles en la plataforma
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Edición del perfil" usuario=$usuario}
    <!-- Contenidos de la página de backoffice de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Usuarios de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de usuarios -->
                <h1 class="titulo-accion-gestor">Edición del perfil</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-usuarios.png" alt="encabezado gestor usuarios"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Usuarios</p>
                    </div>            
                </div>                
                <!-- Información del gestor de usuarios  -->
                <form id="edicion" method="post" action="/plataforma/backoffice.php?comando=usuarios:actualizar:procesa">
                    <div class="contenido-gestor">
                        <input type="hidden" name="frm-hashusuario" id="frm-hashusuario" value="{$perfil.codigo}">
                        <div class="campos-gestor">
                            <p class="corto"><span>Usuario</span>:&nbsp;{$perfil.usuario}</p>
                            <p class="largo"><span>Nombre</span>:&nbsp;{$perfil.nombre}</p>
                            <p class="corto"><span>{$perfil.tipo}</span>:&nbsp;{$perfil.documento}</p>
                        </div> 
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-dirección">Tu dirección:&nbsp;</label>
                                <input type="text" name="frm-direccion" id="frm-direccion" value="{$perfil.direccion}">        
                                <input type="text" name="frm-localidad" id="frm-localidad" value="{$perfil.localidad}">
                                <input type="text" name="frm-codpostal" id="frm-codpostal" value="{$perfil.codigoPostal}">
                            </p>
                        </div>                                         
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-email">Tu email:&nbsp;</label>
                                <input type="email" name="frm-email" id="frm-email" value="{$perfil.email}">                                
                            </p>
                            <p class="corto">
                                <label for="frm-telefono">Teléfono:&nbsp;</label>
                                <input type="phone" name="frm-telefono" id="frm-telefono" value="{$perfil.telefono}">
                            </p>
                        </div>
                        <div class="campos-gestor">
                            {if $permisos->hasPermisoAdministradorGestor()}
                            <!-- Selector para editar el estado del perfil de un usuario -->
                            <p class="corto">
                                <label for="frm-estado">Estado:&nbsp;</label>
                                <select name="frm-estado">
                                    {foreach $estados as $nombre => $valor}
                                        <option value="{$valor}" {if $perfil.estado === $nombre}selected{/if}>{$nombre}</option>
                                    {/foreach}
                                </select>                                                                
                            </p>
                            <!-- Selector para editar el estado del perfil de un usuario -->
                            <p class="corto">
                                <label for="frm-rol">Rol:&nbsp;</label>
                                <select name="frm-rol">
                                    {foreach $roles as $nombre => $valor}
                                        <option value="{$valor}" {if $perfil.rol === $nombre}selected{/if}>{$nombre}</option>
                                    {/foreach}
                                </select>
                            </p>                                        
                            {else}
                                <!-- Muestro la información del estado y rol sin posibilidad de edición -->
                                <p class="medio"><span>Estado</span>:&nbsp;{$perfil.estado}</p>
                                <p class="corto"><span>Rol</span>:&nbsp;{$perfil.rol}</p>
                            {/if}
                        </div>                    
                    </div>
                    <!-- Acciones permitidas por el gestor de usuario -->
                    <div class="botonera">
                        <a class="boton-accion-gestor" href="{$volver}" title="Volver al atrás">Volver</a>
                        <button type="submit" class="boton-accion-gestor" title="Aplicar cmabios">Aplicar</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
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
                <div class="contenido-gestor">
                    <div class="campos-gestor">
                        <p class="corto"><span>Usuario</span>:&nbsp;{$perfil.usuario}</p>
                        <p class="largo"><span>Nombre</span>:&nbsp;{$perfil.nombre}</p>
                        <p class="corto"><span>{$perfil.tipo}</span>:&nbsp;{$perfil.documento}</p>
                    </div> 
                    <div class="campos-gestor">
                        {if $perfil.direccion === "-"}
                            <p class="extralargo"><span>Dirección</span>:&nbsp;Sin datos</p>
                        {else}
                            <p class="extralargo"><span>Dirección</span>:&nbsp;{$perfil.direccion} - {$perfil.localidad} - CP:&nbsp;{$perfil.codigoPostal}</p>
                        {/if}
                    </div>                                         
                    <div class="campos-gestor">
                        <p class="extralargo"><span>Email</span>:&nbsp;{$perfil.email}</p>
                        {if $perfil.direccion === "-"}
                            <p class="corto"><span>Teléfono</span>:&nbsp;Sin datos</p>
                        {else}
                            <p class="corto"><span>Teléfono</span>:&nbsp;{$perfil.telefono}</p>
                        {/if}
                    </div>
                    <div class="campos-gestor">
                        <p class="medio"><span>Estado</span>:&nbsp;{$perfil.estado}</p>
                        <p class="corto"><span>Rol</span>:&nbsp;{$perfil.rol}</p>                        
                    </div>
                </div>
                <!-- Acciones permitidas por el gestor de usuario -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="{$volver}" title="Volver al atrás">Volver</a>
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=usuarios:actualizar:procesa" title="Aplicar cmabios">Aplicar</a>
                </div>
            </article>
        </section>
    </main> 
    {include file="comunes/footer.tpl" anyo="{$anyo}"}
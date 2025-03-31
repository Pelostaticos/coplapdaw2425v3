{* Pantilla Smarty para página de cambio de password del perfil de usuario de la plataforma correplayas
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
*   >> volver: URL a la que see redirige al usuario cuando pincha en botón volver
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Cambio password del perfil" usuario=$usuario}
    <!-- Contenidos de la página de backoffice de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Usuarios de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de usuarios -->
                <h1 class="titulo-accion-gestor">Cambio password del perfil</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-usuarios.png" alt="encabezado gestor usuarios"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Usuarios</p>
                    </div>            
                </div>                
                <!-- Información del gestor de usuarios  -->
                <form id="password" method="post" action="/plataforma/backoffice.php?comando=usuarios:contraseña:procesa">
                    <div class="contenido-gestor">
                        <input type="hidden" name="frm-hashusuario" id="frm-hashusuario" value="{$perfil.codigo}">
                        <div class="campos-gestor">
                            <p class="corto"><span>Usuario</span>:&nbsp;{$perfil.usuario}</p>
                            <p class="medio"><span>Estado</span>:&nbsp;{$perfil.estado}</p>
                            <p class="corto"><span>Rol</span>:&nbsp;{$perfil.rol}</p>
                        </div> 
                        <div class="campos-gestor">
                            <p class="medio">
                                <label for="frm-nuevo-password">Nuevo password:&nbsp;</label>
                                <input type="password" name="frm-nuevo-password" id="frm-nuevo-passwordl" placeholder="Inserte nuevo password...">
                            </p>
                            <p class="medio">
                                <label for="frm-repetir-password">Repetir password:&nbsp;</label>
                                <input type="password" name="frm-repetir-password" id="frm-repetir-passwordl" placeholder="Repita el password...">
                            </p>
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
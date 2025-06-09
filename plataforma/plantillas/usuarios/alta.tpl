{* Pantilla Smarty para dar de alta a un usuario en la plataforma correplayas - modo administrador
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisosUsuario: Conjunto de permisos del usuario logueado.
*   >> filas: Conjunto de datos para generar el listado.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Alta de usuarios" usuario=$usuario}
    <!-- Contenidos de la página para el listado de usuarios de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Usuarios de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de usuarios -->
                <h1 class="titulo-accion-gestor">Alta de usuario</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/imagenes/gestor-usuarios.png" alt="encabezado gestor usuarios"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Usuarios</p>
                    </div>            
                </div>                
                <!-- Información del gestor de usuarios  -->
                <form id="dar-alta-usuario" method="post" action="/plataforma/backoffice.php?comando=usuarios:daralta:procesa">
                    <div class="contenido-gestor">                                                        
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-dni"><span>Documento de identidad</span>:&nbsp;</label>
                                <input type="text" name="frm-dni" id="frm-dni" placeholder="Escribe tu DNI.." require>
                            </p>
                            {if $permisosUsuario->hasPermisoAdministradorGestor()}
                                <p class="largo">
                                    <label for="frm-rol"><span>Rol del usuario</span>:&nbsp;</label>
                                    <select name="frm-rol" id="frm-rol"></select>
                                </p>
                            {else}
                                <input type="hidden" name="frm-rol" id="frm-rol" value="voluntario">
                            {/if}                            
                        </div>
                        <div class="campos-gestor">
                            <p class="largo">
                                <label for="frm-nombre"><span>Nombre</span>:&nbsp;</label>
                                <input type="text" name="frm-nombre" id="frm-nombre" placeholder="Escribe tu nombre..." require>
                            </p>
                            <p class="largo">
                                <label for="frm-apellido1"><span>1ºapellido</span>:&nbsp;</label>
                                <input type="text" name="frm-apellido1" id="frm-apellido1" placeholder="Escribe tu primer apellido..." require>
                            </p>
                            <p class="largo">
                                <label for="frm-apellido2"><span>2ºapellido</span>:&nbsp;</label>
                                <input type="text" name="frm-apellido2" id="frm-apellido2" placeholder="Escribe tu segundo apellido..." require>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-email"><span>Correo electrónico</span>:&nbsp;</label>
                                <input type="email" name="frm-email" id="frm-email" placeholder="Escribe tu correo electrónico..." require>
                            </p>
                            <p class="largo">
                                <label for="frm-localidad"><span>Localidad</span>:&nbsp;</label>
                                <select id="frm-localidad" name="frm-localidad"></select>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="largo">
                                <label for="frm-usuario"><span>Usuario</span>:&nbsp;</label>
                                <input type="text" name="frm-usuario" id="frm-usuario" placeholder="Escribe tu nombre de usuario..." require>
                            </p>
                            <p class="largo">
                                <label for="frm-pasword"><span>Contraseña</span>:&nbsp;</label>
                                <input type="password" name="frm-password" id="frm-password" placeholder="Escribe tu contraseña..." require>
                            </p>
                        </div>
                    </div>
                </form>
                <!-- Acciones permitidas por el gestor de usuario -->
                <div class="botonera">
                    <a class="boton-accion-gestor" href="/plataforma/backoffice.php" title="Volver al inicio">Volver</a>
                    <button class="boton-accion-gestor" form="dar-alta-usuario" type="submit" title="Crear al usuario">Crear usuario</button>                    
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                
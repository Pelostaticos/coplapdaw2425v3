{* Plantilla Smarty para vista de edición de un ave de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> perfil: Datos para generar los detalles del ave.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Edición de ave" usuario=$usuario}
    <!-- Contenidos de la página para la edición de un ave de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Aves de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
            <article>
                <!-- Encabezado del gestor de aves -->
                <h1 class="titulo-accion-gestor">Edición de ave</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/imagenes/gestor-aves.png" alt="encabezado gestor aves"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Aves</p>
                    </div>            
                </div>                
                <!-- Información del gestor de aves  -->
                <form id="edicion-aves" method="post" action="/plataforma/backoffice.php?comando=aves:actualizar:procesa">
                    <input name="frm-especie" id="frm-especie" type="hidden" value="{$perfil.especie}">
                    <input name="frm-imagen" id="frm-imagen" type="hidden" value="{$perfil.imagen}">
                    <div class="contenido-gestor">                        
                        <div class="campos-gestor">
                            <p class="corto"><span>Código</span>:&nbsp;{$perfil.abreviatura}</p>
                            <p class="extralargo"><span>Especie</span>:&nbsp;{$perfil.especie}</p>                        
                        </div>
                        <div class="campos-gestor">
                            <p class="extralargo"><span>Familia</span>:&nbsp;{$perfil.familia}</p>
                            <p class="extralargo"><span>Orden</span>:&nbsp;{$perfil.orden}</p>
                        </div>  
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-comun"><span>Nombre común</span>:&nbsp;</label>
                                <input type="text" name="frm-comun" id="frm-comun" value="{$perfil.comun}" required>
                            </p>                        
                            <p class="extralargo">
                                <label for="frm-ingles"><span>Nombre inglés</span>:&nbsp;</label>
                                <input type="text" name="frm-ingles" id="frm-ingles" value="{$perfil.ingles}" required>
                            </p> 
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-url"><span>URL</span>:&nbsp;</label>
                                <input type="text" name="frm-url" id="frm-url" value="{$perfil.url}" required>
                            </p>
                        </div>
                    </div>
                    <!-- Acciones permitidas por el gestor de aves -->
                    <div class="botonera">
                        <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=aves:default" title="Volver atrás">Volver</a>
                        <button type="submit" class="boton-accion-gestor" title="Aplicar cambios en aves">Aplicar</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                   
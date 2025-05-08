{* Plantilla Smarty para vista de registro de una nueva ave de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> hoy: fecha del día presente.
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Registro de aves" usuario=$usuario}
    <!-- Contenidos de la página para el registro de nueva ave de la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Aves de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
            <article>
                <!-- Encabezado del gestor de aves -->
                <h1 class="titulo-accion-gestor">Registro de aves</h1>                    
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-aves.png" alt="encabezado gestor aves"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Aves</p>
                    </div>            
                </div>                
                <!-- Información del gestor de aves  -->
                <form id="registro-ave" method="post" action="/plataforma/backoffice.php?comando=aves:registrar:procesa">
                    <div class="contenido-gestor">                        
                        <div class="campos-gestor">
                            <p class="medio">
                                <label for="frm-codigo"><span>Código</span>:&nbsp;</label>
                                <input type="text" name="frm-codigo" id="frm-codigo" placeholder="Código del ave..." required>
                            </p>
                            <p class="extralargo">
                                <label for="frm-especie"><span>Especie</span>:&nbsp;</label>
                                <input type="text" name="frm-especie" id="frm-especie" placeholder="Especie del ave..." required>
                            </p>                            
                        </div>
                        <div class="campos-gestor">
                            <small><span>RECUERDA</span>:&nbsp;El código del ave se forma con las tres primeras letras de cada palabra de la especie, todo junto y en mayúsculas.</small>
                        </div>
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-familia"><span>Familia</span>:&nbsp;</label>
                                <select name="frm-familia" id="frm-familia" required></select>
                            </p>
                            <p class="extralargo">
                                <label for="frm-orden"><span>Orden</span>:&nbsp;</label>
                                <input type="text" name="frm-orden" id="frm-orden" value="Desconocido" required>
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-comun"><span>Nombre común</span>:&nbsp;</label>
                                <input type="text" name="frm-comun" id="frm-comun" placeholder="Nombre común del ave..." required>
                            </p>                        
                            <p class="extralargo">
                                <label for="frm-ingles"><span>Nombre inglés</span>:&nbsp;</label>
                                <input type="text" name="frm-ingles" id="frm-ingles" placeholder="Nombre inglés del ave..." required>
                            </p> 
                        </div>
                        <div class="campos-gestor">
                            <p class="extraextralargo">
                                <label for="frm-url"><span>URL</span>:&nbsp;</label>
                                <input type="text" name="frm-url" id="frm-url" placeholder="URL con información adicional del ave..." required>
                            </p>
                        </div>
                    </div>
                    <!-- Acciones permitidas por el gestor de aves -->
                    <div class="botonera">
                        <a class="boton-accion-gestor" href="/plataforma/backoffice.php?comando=aves:default" title="Volver al atrás">Volver</a>
                        <button type="submit" class="boton-accion-gestor" title="Crear ave">Crear</button>
                    </div>
                </form>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                   
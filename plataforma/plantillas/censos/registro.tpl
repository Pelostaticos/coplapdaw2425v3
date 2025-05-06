{* Plantilla Smarty para vista del censo de aves de la plataforma correplayas - añadir censos
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> perfil: Información básica sobre la jornada censal en curso
*   >> anyo: Año en curso para copyright y copyleft del sitio web.
*
*}

{include file="comunes/header.tpl" titulo="Censo de aves" usuario=$usuario}
    <!-- Contenidos de la página para la vista del censo de aves en la plataforma correplayas -->
    <main id="inicio">        
        <!-- Sección para el gestor de Censos de la plataforma correplayas -->
         <section id="correplayas">
            <!-- Artículo que describe el proyecto de la plataforma correplayas -->
             <article>
                <!-- Encabezado del gestor de Censos -->
                <h1 class="titulo-accion-gestor">Censo de aves</h1>
                <div class="cabecera-gestor">
                    <img class="logo-gestor" src="/plataforma/imagenes/gestor-censos.png" alt="encabezado gestor censos"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Censos</p>
                    </div>            
                </div>
                <!-- A) Información del gestor de censos: Formulario para añadir un registro censal.  -->
                <form id="añadir-registro-censal" method="post" action="/plataforma/backoffice.php?comando=censos:registrar:procesa">
                    <input name="frm-idjornada" id="frm-idjornada" type="hidden" value="{$perfil.idJornada}">
                    <input name="frm-hora" id="frm-hora" type="hidden" value="{$perfil.hora}">
                    <div class="contenido-gestor">
                        <!-- Encabezado del formulario para añadir registros censales de la jornada -->
                        <h2 class="subtitulo-contenido-gestor">Añadir un nuevo registro censal</h2>
                        <p class="texto-contenido-gestor">A través de este formulario, podrá ingresar la información de un nuevo registro censal, proporcione
                        datos precisos y completos en cada campo. ¡Muchas gracias por participar!</p>
                        <!-- Campos del formulario para añadir registros censales de la jornada -->
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-especie">Especie:&nbsp;</label>
                                <select name="frm-especie" id="frm-especie" required></select>
                            </p>
                            <p class="corto"><span>Hora</span>:&nbsp;{$perfil.hora}</p>
                            <p class="medio">
                                <label for="frm-cantidad">Cantidad:&nbsp;</label>
                                <input type="text" name="frm-cantidad" id="frm-cantidad" placeholder="Cantidad aves observadas..." required>                                
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="largo">
                                <label for="frm-nubosidad">Nubosidad:&nbsp;</label>
                                <select name="frm-nubosidad" id="frm-nubosidad" required>
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="10">10% cubierto</option>
                                    <option value="20">20% cubierto</option>
                                    <option value="30">30% cubierto</option>
                                    <option value="40">40% cubierto</option>
                                    <option value="50">50% cubierto</option>
                                    <option value="60">60% cubierto</option>
                                    <option value="70">70% cubierto</option>
                                    <option value="80">80% cubierto</option>
                                    <option value="90">90% cubierto</option>
                                    <option value="100">100% cubierto</option>
                                    <option value="Desconocido">Desconocido</option>
                                </select>
                            </p>
                            <p class="largo">
                                <label for="frm-visibilidad">Visibilidad:&nbsp;</label>
                                <select name="frm-visibilidad" id="frm-visibilidad" required>                                    
                                    <option value="0">0-Niebla costera espesa</option>
                                    <option value="1">1-Brumas marinas</option>
                                    <option value="2">2-Ligeras calimas o brumas</option>
                                    <option value="3">3-Buena</option>
                                    <option value="4">4-Muy buena</option>
                                    <option value="5">5-Dificultosa por contraluces</option>
                                </select>                                
                            </p>
                            <p class="largo">
                                <label for="frm-dirviento">Dirección viento:&nbsp;</label>
                                <select name="frm-dirviento" id="frm-dirviento" required>                                    
                                    <option value="SIN">Sin viento</option>
                                    <option value="N">Norte</option>
                                    <option value="NE">Noreste</option>
                                    <option value="E">Este-</option>
                                    <option value="SE">Sureste</option>
                                    <option value="S">Sur</option>
                                    <option value="SO">Suroeste</option>
                                    <option value="O">Oeste</option>
                                    <option value="NO">Noroeste</option>
                                    <option value="VAR">Variable</option>
                                    <option value="DES">Desconocida</option>
                                </select>                                
                            </p>                            
                        </div>
                        <div class="campos-gestor">
                            <p class="largo">
                                <label for="frm-velviento">Velocidad viento:&nbsp;</label>
                                <select name="frm-velviento" id="frm-velviento" required>                                    
                                    <option value="0">0-Beaufort</option>
                                    <option value="1">1-Beaufort</option>
                                    <option value="2">2-Beaufort</option>
                                    <option value="3">3-Beaufort-</option>
                                    <option value="4">4-Beaufort</option>
                                    <option value="5">5-Beaufort</option>
                                    <option value="6">6-Beaufort</option>
                                    <option value="7">7-Beaufort</option>
                                    <option value="8">8-Beaufort</option>
                                    <option value="9">9-Beaufort</option>
                                    <option value="10">10-Beaufort</option>
                                </select>                                
                            </p>
                            <p class="corto">
                                <label for="frm-procedencia">Procedencia:&nbsp;</label>
                                <select name="frm-procedencia" id="frm-procedencia" required>                                    
                                    <option value="N">Norte</option>
                                    <option value="NE">Noreste</option>
                                    <option value="E">Este-</option>
                                    <option value="SE">Sureste</option>
                                    <option value="S">Sur</option>
                                    <option value="SO">Suroeste</option>
                                    <option value="O">Oeste</option>
                                    <option value="NO">Noroeste</option>
                                    <option value="DES">Desconocida</option>
                                </select>                                
                            </p>
                            <p class="corto">
                                <label for="frm-destino">Destino:&nbsp;</label>
                                <select name="frm-destino" id="frm-destino" required>                                    
                                    <option value="N">Norte</option>
                                    <option value="NE">Noreste</option>
                                    <option value="E">Este-</option>
                                    <option value="SE">Sureste</option>
                                    <option value="S">Sur</option>
                                    <option value="SO">Suroeste</option>
                                    <option value="O">Oeste</option>
                                    <option value="NO">Noroeste</option>
                                    <option value="DES">Desconocida</option>
                                </select>                                
                            </p>
                            <p class="largo">
                                <label for="frm-altvuelo">Altura vuelo:&nbsp;</label>
                                <select name="frm-altvuelo" id="frm-altvuelo" required>                                    
                                    <option value="0">0-(Posada en superficie)</option>
                                    <option value="1">1-(Vuelo rasante - 5 m)</option>
                                    <option value="2">2-(6-25 metros)</option>
                                    <option value="3">3-(26-50 metros)-</option>
                                    <option value="4">4-(51-75 metros)</option>
                                    <option value="5">5-(76-100 metros)</option>
                                    <option value="6">6-(+100 metros)</option>
                                </select>                                
                            </p>                                                                                                 
                        </div>
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-formavuelo">Formación vuelo:&nbsp;</label>
                                <select name="frm-formavuelo" id="frm-formavuelo" required>                                    
                                    <option value="LINHOR">LINHOR-Lineal Formacion Horizontal</option>
                                    <option value="LINVER">LINVER-Lineal Formacion Vertical</option>
                                    <option value="VSI">VSI-Formación en "V" simétrica</option>
                                    <option value="VAS">VAS-Formación en "V" asimétrica</option>
                                    <option value="AMO">AMO-Formación de vuelo amorfa</option>
                                    <option value="OTR">OTR-Cualquier otra o desconocida</option>
                                </select>                                
                            </p>
                            <p class="extralargo">
                                <label for="frm-distcosta">Distancia a costa:&nbsp;</label>
                                <select name="frm-distcosta" id="frm-distcosta" required>                                    
                                    <option value="DBO">LINHOR-Delante línea boyas o mar adentro</option>
                                    <option value="BO">BO-Linea de boyas</option>
                                    <option value="LMA">LMA-Línea de marea</option>
                                    <option value="FR">FR-Frente dunar, acantilado, tierra adentro</option>
                                    <option value="CAN">CAN-Cerca del cantil</option>
                                    <option value="MED">MED-Media distancia al horizonte</option>
                                    <option value="HOR">HOR-Cerca del horizzonte</option>
                                </select>                                
                            </p>                                                                               
                        </div>
                        <div class="campos-gestor">
                            <p class="muyextraextraextralargo">
                                <label for="frm-comentarios">Comentarios:&nbsp;</label>
                                <textarea name="frm-comentarios" id="frm-comentarios" rows="3" maxleng="200" placeholder="Deje comentarios adicionales a la observacion (Max: 200 caracteres)..." required></textarea>
                            </p>
                        </div>                                                 
                    </div>
                </form>
                <!-- Acciones permitidas por el gestor de censos -->
                <form name="volverCensoAves" id="volverCensoAves" method="post" action="/plataforma/backoffice.php?comando=censos:default"></form>
                <div class="botonera">                
                    <button class="boton-accion-gestor" form="volverCensoAves" type="submit" name="accion" value="censo:volver" title="Volver al censo">Volver</button>
                    <button class="boton-accion-gestor" form="volverCensoAves" type="submit" name="accion" value="censo:añadir" title="Añadir registro censal">Añadir</button>             
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                                
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
                <!-- A) Información del gestor de censos: Formulario para la edición de un registro censal.  -->
                <form id="edicion-registro-censal" method="post" action="/plataforma/backoffice.php?comando=censos:actualizar:procesa">
                    <input name="frm-idjornada" id="frm-idjornada" type="hidden" value="{$perfil.idJornada}">
                    <input name="frm-especie" id="frm-especie" type="hidden" value="{$perfil.especie}">
                    <input name="frm-hora" id="frm-hora" type="hidden" value="{$perfil.hora}">
                    <div class="contenido-gestor">
                        <!-- Encabezado del formulario para la edición de registros censales de la jornada -->
                        <h2 class="subtitulo-contenido-gestor">Edición de registro censal</h2>
                        <p class="texto-contenido-gestor">A través de este formulario, podrá editar la información de un registro censal, revise y proporcione
                        datos precisos y completos en cada campo. ¡Muchas gracias por participar!</p>
                        <!-- Campos del formulario para añadir registros censales de la jornada -->
                        <div class="campos-gestor">
                            <p class="corto"><span>Hora</span>:&nbsp;{$perfil.hora}</p>
                            <p class="extralargo"><span>Especie</span>:&nbsp;{$perfil.especie}</p>
                            <p id="frm-familia" class="largo"><span>Familia</span>:&nbsp;{$perfil.familia}</p>
                        </div>
                        <div class="campos-gestor">
                            <p id="frm-orden" class="largo"><span>Orden</span>:&nbsp;{$perfil.orden}</p>
                            <p class="corto">
                                <label for="frm-cantidad"><span>Cantidad</span>:&nbsp;</label>
                                <input type="text" name="frm-cantidad" id="frm-cantidad" value="{$perfil.cantidad}" required>                                
                            </p>
                        </div>
                        <div class="campos-gestor">
                            <p class="largo">
                                <label for="frm-nubosidad"><span>Nubosidad</span>:&nbsp;</label>
                                <select name="frm-nubosidad" id="frm-nubosidad" required>
                                    <option value="Ninguno" {if $perfil.nubosidad==='Ninguno'}selected{/if}>Ninguno</option>
                                    <option value="10" {if $perfil.nubosidad==='10'}selected{/if}>10% cubierto</option>
                                    <option value="20" {if $perfil.nubosidad==='20'}selected{/if}>20% cubierto</option>
                                    <option value="30" {if $perfil.nubosidad==='30'}selected{/if}>30% cubierto</option>
                                    <option value="40" {if $perfil.nubosidad==='40'}selected{/if}>40% cubierto</option>
                                    <option value="50" {if $perfil.nubosidad==='50'}selected{/if}>50% cubierto</option>
                                    <option value="60" {if $perfil.nubosidad==='60'}selected{/if}>60% cubierto</option>
                                    <option value="70" {if $perfil.nubosidad==='70'}selected{/if}>70% cubierto</option>
                                    <option value="80" {if $perfil.nubosidad==='80'}selected{/if}>80% cubierto</option>
                                    <option value="90" {if $perfil.nubosidad==='90'}selected{/if}>90% cubierto</option>
                                    <option value="100" {if $perfil.nubosidad==='100'}selected{/if}>100% cubierto</option>
                                    <option value="Desconocido" {if $perfil.nubosidad==='Desconocido'}selected{/if}>Desconocido</option>
                                </select>
                            </p>
                            <p class="largo">
                                <label for="frm-visibilidad"><span>Visibilidad</span>:&nbsp;</label>
                                <select name="frm-visibilidad" id="frm-visibilidad" required>                                    
                                    <option value="0" {if $perfil.visibilidad==='0'}selected{/if}>0-Niebla costera espesa</option>
                                    <option value="1" {if $perfil.visibilidad==='1'}selected{/if}>1-Brumas marinas</option>
                                    <option value="2" {if $perfil.visibilidad==='2'}selected{/if}>2-Ligeras calimas o brumas</option>
                                    <option value="3" {if $perfil.visibilidad==='3'}selected{/if}>3-Buena</option>
                                    <option value="4" {if $perfil.visibilidad==='4'}selected{/if}>4-Muy buena</option>
                                    <option value="5" {if $perfil.visibilidad==='5'}selected{/if}>5-Dificultosa por contraluces</option>
                                </select>                                
                            </p>
                            <p class="largo">
                                <label for="frm-dirviento"><span>Dirección viento</span>:&nbsp;</label>
                                <select name="frm-dirviento" id="frm-dirviento" required>                                    
                                    <option value="SIN" {if $perfil.dirviento==='SIN'}selected{/if}>Sin viento</option>
                                    <option value="N" {if $perfil.dirviento==='N'}selected{/if}>Norte</option>
                                    <option value="NE" {if $perfil.dirviento==='NE'}selected{/if}>Noreste</option>
                                    <option value="E" {if $perfil.dirviento==='E'}selected{/if}>Este-</option>
                                    <option value="SE" {if $perfil.dirviento==='SE'}selected{/if}>Sureste</option>
                                    <option value="S" {if $perfil.dirviento==='S'}selected{/if}>Sur</option>
                                    <option value="SO" {if $perfil.dirviento==='SO'}selected{/if}>Suroeste</option>
                                    <option value="O" {if $perfil.dirviento==='O'}selected{/if}>Oeste</option>
                                    <option value="NO" {if $perfil.dirviento==='NO'}selected{/if}>Noroeste</option>
                                    <option value="VAR" {if $perfil.dirviento==='VAR'}selected{/if}>Variable</option>
                                    <option value="DES" {if $perfil.dirviento==='DES'}selected{/if}>Desconocida</option>
                                </select>                                
                            </p>                            
                        </div>
                        <div class="campos-gestor">
                            <p class="largo">
                                <label for="frm-velviento"><span>Velocidad viento</span>:&nbsp;</label>
                                <select name="frm-velviento" id="frm-velviento" required>                                    
                                    <option value="0" {if $perfil.velviento==='0'}selected{/if}>0-Beaufort</option>
                                    <option value="1" {if $perfil.velviento==='1'}selected{/if}>1-Beaufort</option>
                                    <option value="2" {if $perfil.velviento==='2'}selected{/if}>2-Beaufort</option>
                                    <option value="3" {if $perfil.velviento==='3'}selected{/if}>3-Beaufort-</option>
                                    <option value="4" {if $perfil.velviento==='4'}selected{/if}>4-Beaufort</option>
                                    <option value="5" {if $perfil.velviento==='5'}selected{/if}>5-Beaufort</option>
                                    <option value="6" {if $perfil.velviento==='6'}selected{/if}>6-Beaufort</option>
                                    <option value="7" {if $perfil.velviento==='7'}selected{/if}>7-Beaufort</option>
                                    <option value="8" {if $perfil.velviento==='8'}selected{/if}>8-Beaufort</option>
                                    <option value="9" {if $perfil.velviento==='9'}selected{/if}>9-Beaufort</option>
                                    <option value="10" {if $perfil.velviento==='10'}selected{/if}>10-Beaufort</option>
                                </select>                                
                            </p>
                            <p class="corto">
                                <label for="frm-procedencia"><span>Procedencia</span>:&nbsp;</label>
                                <select name="frm-procedencia" id="frm-procedencia" required>                                    
                                    <option value="N" {if $perfil.procedencia==='N'}selected{/if}>Norte</option>
                                    <option value="NE"{if $perfil.procedencia==='NE'}selected{/if}>Noreste</option>
                                    <option value="E" {if $perfil.procedencia==='E'}selected{/if}>Este-</option>
                                    <option value="SE" {if $perfil.procedencia==='SE'}selected{/if}>Sureste</option>
                                    <option value="S" {if $perfil.procedencia==='S'}selected{/if}>Sur</option>
                                    <option value="SO" {if $perfil.procedencia==='SO'}selected{/if}>Suroeste</option>
                                    <option value="O" {if $perfil.procedencia==='O'}selected{/if}>Oeste</option>
                                    <option value="NO" {if $perfil.procedencia==='NO'}selected{/if}>Noroeste</option>
                                    <option value="DES" {if $perfil.procedencia==='DES'}selected{/if}>Desconocida</option>
                                </select>                                
                            </p>
                            <p class="corto">
                                <label for="frm-destino"><span>Destino</span>:&nbsp;</label>
                                <select name="frm-destino" id="frm-destino" required>                                    
                                    <option value="N" {if $perfil.destino==='N'}selected{/if}>Norte</option>
                                    <option value="NE"{if $perfil.destino==='NE'}selected{/if}>Noreste</option>
                                    <option value="E" {if $perfil.destino==='E'}selected{/if}>Este-</option>
                                    <option value="SE" {if $perfil.destino==='SE'}selected{/if}>Sureste</option>
                                    <option value="S" {if $perfil.destino==='S'}selected{/if}>Sur</option>
                                    <option value="SO" {if $perfil.destino==='SO'}selected{/if}>Suroeste</option>
                                    <option value="O" {if $perfil.destino==='O'}selected{/if}>Oeste</option>
                                    <option value="NO" {if $perfil.destino==='NO'}selected{/if}>Noroeste</option>
                                    <option value="DES" {if $perfil.destino==='DES'}selected{/if}>Desconocida</option>
                                </select>                                
                            </p>
                            <p class="largo">
                                <label for="frm-altvuelo"><span>Altura vuelo</span>:&nbsp;</label>
                                <select name="frm-altvuelo" id="frm-altvuelo" required>                                    
                                    <option value="0" {if $perfil.altvuelo==='0'}selected{/if}>0-(Posada en superficie)</option>
                                    <option value="1" {if $perfil.altvuelo==='1'}selected{/if}>1-(Vuelo rasante-5 metros)</option>
                                    <option value="2" {if $perfil.altvuelo==='2'}selected{/if}>2-(6-25 metros)</option>
                                    <option value="3" {if $perfil.altvuelo==='3'}selected{/if}>3-(26-50 metros)</option>
                                    <option value="4" {if $perfil.altvuelo==='4'}selected{/if}>4-(51-75 metros)</option>
                                    <option value="5" {if $perfil.altvuelo==='5'}selected{/if}>5-(76-100 metros)</option>
                                    <option value="6" {if $perfil.altvuelo==='6'}selected{/if}>6-(+100 metros)</option>
                                </select>                                
                            </p>                                                                                                 
                        </div>
                        <div class="campos-gestor">
                            <p class="extralargo">
                                <label for="frm-formavuelo"><span>Formación vuelo</span>:&nbsp;</label>
                                <select name="frm-formavuelo" id="frm-formavuelo" required>                                    
                                    <option value="LINHOR" {if $perfil.formavuelo==='LINHOR'}selected{/if}>LINHOR-Lineal Formacion Horizontal</option>
                                    <option value="LINVER" {if $perfil.formavuelo==='LINVER'}selected{/if}>LINVER-Lineal Formacion Vertical</option>
                                    <option value="VSI" {if $perfil.formavuelo==='VSI'}selected{/if}>VSI-Formación en "V" simétrica</option>
                                    <option value="VAS" {if $perfil.formavuelo==='VAS'}selected{/if}>VAS-Formación en "V" asimétrica</option>
                                    <option value="AMO" {if $perfil.formavuelo==='AMO'}selected{/if}>AMO-Formación de vuelo amorfa</option>
                                    <option value="OTR" {if $perfil.formavuelo==='OTR'}selected{/if}>OTR-Cualquier otra o desconocida</option>
                                </select>                                
                            </p>
                            <p class="extralargo">
                                <label for="frm-distcosta"><span>Distancia a costa</span>:&nbsp;</label>
                                <select name="frm-distcosta" id="frm-distcosta" required>                                    
                                    <option value="DBO" {if $perfil.distcosta==='DBO'}selected{/if}>LINHOR-Delante línea boyas o mar adentro</option>
                                    <option value="BO" {if $perfil.distcosta==='BO'}selected{/if}>BO-Linea de boyas</option>
                                    <option value="LMA" {if $perfil.distcosta==='LMA'}selected{/if}>LMA-Línea de marea</option>
                                    <option value="FR" {if $perfil.distcosta==='FR'}selected{/if}>FR-Frente dunar, acantilado, tierra adentro</option>
                                    <option value="CAN" {if $perfil.distcosta==='CAN'}selected{/if}>CAN-Cerca del cantil</option>
                                    <option value="MED" {if $perfil.distcosta==='MED'}selected{/if}>MED-Media distancia al horizonte</option>
                                    <option value="HOR" {if $perfil.distcosta==='HOR'}selected{/if}>HOR-Cerca del horizzonte</option>
                                </select>                                
                            </p>                                                                               
                        </div>
                        <div class="campos-gestor">
                            <p class="muyextraextraextralargo">
                                <label for="frm-comentarios"><span>Comentarios</span>:&nbsp;</label>
                                <textarea name="frm-comentarios" id="frm-comentarios" rows="3" maxleng="200" required>{$perfil.comentario}</textarea>
                            </p>
                        </div>                                                 
                    </div>
                </form>               
                <!-- Acciones permitidas por el gestor de censos -->
                <form name="volverCensoAves" id="volverCensoAves" method="post" action="/plataforma/backoffice.php?comando=censos:default"></form>
                <div class="botonera">                
                    <button class="boton-accion-gestor" form="volverCensoAves" type="submit" name="accion" value="censo:volver" title="Volver al censo">Volver</button>
                    <button class="boton-accion-gestor" form="edicion-registro-censal" type="submit" title="Actualizar registro censal">Actualizar</button>              
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}     
{* Plantilla Smarty para vista del censo de aves de la plataforma correplayas
* Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
* Nombre del proyecto: Plataforma Correplayas
* Tutor PDAW: Jośe Antonio Morales Álvarez.
* Autor: Sergio García Butrón 
* 
* Parámetros de plantilla:
*
*   >> usuario: Nombre del usuario logueado.
*   >> permisos: Conjunto de permisos del usuario logueado.
*   >> censable: Bandera que controla la visibilidad de acciones al usuario cuando una jornada es censable
*   >> validable: Bandera que controla si el censo mostrado es validable por el usuario o no
*   >> perfil: Información básica sobre la jornada censal en curso
*   >> filas: Conjunto de datos para generar el listado.
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
                    <img class="logo-gestor" src="/imagenes/gestor-censos.png" alt="encabezado gestor censos"/>
                    <div class="gestor">
                        <small>Gestor</small>
                        <p class="titulo-gestor">Censos</p>
                    </div>            
                </div>
                <!-- A) Información del gestor de censos: Participantes y detalles básicos jornadas censal  -->
                <div class="contenido-gestor">
                    <!-- Información introductoria al listado de participantes de la jornada censal -->
                    <h2 class="subtitulo-contenido-gestor">Confirmación de asistencia participantes</h2>
                    <p class="texto-contenido-gestor">Para llevar un registro preciso de la asistencia a la jornada censal del {$jornada->getFechaJornada()}
                    ({$jornada->getHoraInicioJornada()} - {$jornada->getHoraFinJornada()}), revise el siguiente listado y confirme la presencia de cada participante.
                    Asegúrese de marcar solo a aquellos que efectivamente asistieron. Luego pinche en aceptar para confirmar asistencia o si llego a esta ventana por
                    error puede hacer clic en cancelar para volver a la vista del censo de aves. ¡Muchas gracias por participar!</p>
                    <!-- Tabla que representa al listado de participantes al censo de aves -->
                    <table id="listado-gestor">
                        <!-- Cabecera del listado de participantes al censo de aves -->
                        <thead>
                            <th>Asiste</th>
                            <th>Usuario</th>
                            <th>Localidad</th>
                            <th>Inscrito</th>
                            <th>Observaciones</th>
                        </thead>
                         <!-- Contenido del listado de participantes al censo de aves -->
                        <tbody>
                            <!-- Formulario para confirmar la asistencia de usuarios participantes a jornada censal -->
                            <form name="confirmarAsistencia" id="confirmarAsistencia" method="post" action="/plataforma/backoffice.php?comando=censos:default">
                                <input type="hidden" name="idJornada" value="{$jornada->getIdJornada()}">
                                {if $filas|@count === 0}
                                    <tr>
                                        <td colspan="4">Lo sentimos!!! No hay participantes inscritos a esta jornada censal</td>
                                    </tr>
                                {else}                        
                                    {foreach $filas as $fila}
                                        <!-- Fila con los datos de cada paraticipante al censo de aves  -->
                                        <tr>
                                            <!-- Celdas con datos de cada participante  al censo de aves -->
                                            <td><input type="checkbox" id="{$fila.hashUsuario}" name="asistencia[]" value="{$fila.hashUsuario}" {if $fila.asiste}checked{/if}></td>
                                            <td>{$fila.usuario}</td>
                                            <td>{$fila.localidad}</td>
                                            <td>{$fila.inscrito|date_format:"%d-%m-%Y"}</td>
                                            <td>{$fila.observaciones}</td>
                                        </tr>
                                    {/foreach}
                                {/if}
                            </form>
                        </tbody>
                    </table>                                       
                </div>                  
                <!-- Acciones permitidas por el gestor de censos -->
                <form name="volverAsistencia" id="volverAsistencia" method="post" action="/plataforma/backoffice.php?comando=censos:default"></form>
                <div class="botonera">                
                    <button class="boton-accion-gestor" form="volverAsistencia" type="submit" name="accion" value="asistencia:cancelar" title="Cancelar confirmación asistencia">Cancelar</button>
                    <button class="boton-accion-gestor" form="confirmarAsistencia" type="submit" name="accion" value="asistencia:aceptar" title="Aceptar asistencia participantes">Aceptar</button>
                </div>
            </article>
        </section>
    </main> 
{include file="comunes/footer.tpl" anyo="{$anyo}"}                   
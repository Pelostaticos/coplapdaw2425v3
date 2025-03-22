{* Pantilla Smarty para cabecera común del backoffice de la plataforma correplayas
    * Proyecto DAW Cursos 2024/25 - I.E.S AGUADULCE
    * Nombre del proyecto: Plataforma Correplayas
    * Tutor PDAW: Jośe Antonio Morales Álvarez.
    * Autor: Sergio García Butrón 
*}

<!-- {$usuarioLogueado=isset($marty.session.usuario)} -->
 {$usuarioLogueado=isset($smarty.session.usuario)}

<!DOCTYPE html>
<html lang="sp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$titulo}</title>
    <link rel="stylesheet" href="/plataforma/estilos/backoffice.css">
    <link rel="icon" href="/plataforma/imagenes/correplayas.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <!-- Cabecera del sisito web -->
    <header>
        <!-- Logotipo y titulo del sitio web -->
        <a href="#inicio">
            <img src="/plataforma/imagenes/correplayas.png" alt="logotipo del portal web correplayas"/>
            <div class="sitioweb">
                <small>Plataforma</small>
                <p class="titulositioweb"><span>Corre</span>playas.es</p>
            </div>            
        </a>
        <!-- Zona de navegación -->
        <nav>
            {if $usuarioLogueado}
                <!-- Menú del sitio web -->
                <ul class="menu">
                    <!-- Entrada del menu para el acceso al gestor de usuarios -->
                    <li><a href="/plataforma/backoffice.php?comando=usuarios:default">Usuarios</a></li>
                    <!-- Entrada del menu para el acceso al gestor de jornadas -->
                    <li><a href="#">Jornadas</a></li>
                    <!-- Entrada de menu para el acceso al gestor de participantes -->
                    <li><a href="#">Participación</a></li>
                    <!-- Entrada del menu para el acceso al gestor de censos    -->
                    <li><a href="#">Censos</a></li>
                    <!-- Entrada del menú para el acceso al gestor de aves -->
                    <li><a href="#">Aves</a></li>
                    <!-- Entrada del menú para el acceso al gestor de observatorios -->
                    <li><a href="#">Observatorios</a></li>
                </ul>
                <!-- Hamburguesa del menú responsive -->
                <span class="menu-icono">menu</span>
                <!-- Separador entre botones y menú de navegación -->
                <span class="separador-nav"></span>
                <!-- Nombre del usuario logeado -->
                <a href="/plataforma/backoffice.php?comando=usuarios:consultar" class="boton-nav" title="Ver mi perfil de usuario"><span class="iconos-nav-backoffice">account_circle</span> {$usuario}</a>
                <!-- Botón de salida de la plataforma -->
                <a href="/plataforma/backoffice.php?comando=core:logout:vista" class="boton-nav" title="Salir de la plataforma"><span class="iconos-nav-backoffice">logout</span> Salir</a>
            {else}
                <h1 class="titulo-navegacion">Backoffice</h1>
            {/if}
        </nav>
    </header>

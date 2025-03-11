<?php

/**
 * [Descripción breve de la función, clase o archivo]
 *
 * [Descripción detallada, si es necesario, puede incluir ejemplos de uso]
 *
 * @category [Categoría del código, por ejemplo, "Database", "User", "API"]
 * @package  [Nombre del paquete o namespace]
 * @author   [Tu nombre o el nombre del equipo]
 * @license  [Tipo de licencia, por ejemplo, MIT, GPL, etc.]
 * @link     https://abdc.es/blog/documentos-externos-empresa-tipos/
 * @version  [Número de versión]
 * @since    [Versión en la que se introdujo el código]
 *
 * @param [Tipo] $[nombre] [Descripción del parámetro]
 * @param [Tipo] $[nombre] [Descripción del parámetro]
 * ...
 *
 * @return [Tipo] [Descripción del valor de retorno]
 *
 * @throws [Tipo de excepción] [Descripción de la excepción]
 * @throws [Tipo de excepción] [Descripción de la excepción]
 * ...
 *
 * @example
 * [Ejemplo de uso del código]
 *
 * @deprecated [Descripción de por qué el código está obsoleto, si aplica]
 */

    echo "Bienvenido al futuro enrutador de la Playaforma Correplayas...";
    echo "<br/>";
    echo "El comando que quieres ejecutar es: " . $_GET['comando'];
    echo "<br/>";

    if ($_GET['comando'] === "CORE:EMAIL") {
        echo "Hola! Muy pronto prodrás mandarnos un formulario de contacto!!";
        echo "<br/>";
        var_dump($_POST);
        echo "<br/>";
        echo "<a href='/#contacto'>Volver al inicio</a>";
    }

?>
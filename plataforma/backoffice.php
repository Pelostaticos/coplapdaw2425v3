<?php

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
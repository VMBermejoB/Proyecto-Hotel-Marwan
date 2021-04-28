<?php
session_start();
?>
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Cerrar Sesión</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
    <div><h1>CERRAR SESIÓN</h1></div>
<?php
    echo'<div id="Titulo"><h3>Adiós !! Haz click aqui para volver a <a href="iniciosesion.php">iniciar sesion</a>.</h3></div>';
    session_destroy();
?>
    </body>
</html>

<?php
/**
 * Consulta para comprobar si el correo que se le pasa por URL existe
 */
    require_once 'metodos.php';
    $objMetodos = new metodos();

    $correo=$_GET["correo"];

    $sentencia = $objMetodos->mysqli->prepare("SELECT * FROM usuarios WHERE correo=?");
    $sentencia->bind_param("s", $correo);
    $sentencia->execute();

    $resultado=$sentencia->get_result();

    if($resultado->num_rows==0){
        echo "0";
    }
    else
    {
        echo "1";
    }
?>


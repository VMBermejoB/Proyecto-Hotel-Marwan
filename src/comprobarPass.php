<?php
    session_start();
    require_once 'metodos.php';
    $objMetodos = new metodos();
    /**
    * Consulta para comprobar si la pass que se le pasa por URL es correcta
    */
    $pass1=$_GET["pass1"];

    $sentencia = $objMetodos->mysqli->prepare("SELECT password FROM usuarios WHERE idUsuario=".$_SESSION["id"]);
    $sentencia->execute();

    $resultado=$sentencia->get_result();

    $pass2=$resultado->fetch_assoc();

    $pass3=$pass2["password"];

    $sentencia->bind_result($pass2);
    if(password_verify($pass1, $pass3)){
        echo "1";
    }
    else
    {
        echo "0";
    }
?>

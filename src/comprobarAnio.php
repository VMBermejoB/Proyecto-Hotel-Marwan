<?php
    /**
     * Consulta para comprobar si el año que se ha introducido existe
     */
    require_once 'metodos.php';
    $objMetodos = new metodos();

    $anio=$_GET["anio"];

    $sentencia = $objMetodos->mysqli->prepare("SELECT * FROM temporada WHERE anio=?");
    $sentencia->bind_param("s", $anio);
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

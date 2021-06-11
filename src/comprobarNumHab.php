<?php
require_once 'metodos.php';
$objMetodos = new metodos();

$numHabitacion=$_GET["numHabitacion"];

$sentencia = $objMetodos->mysqli->prepare("SELECT * FROM habitaciones WHERE numHabitacion=?");
$sentencia->bind_param("i", $numHabitacion);
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
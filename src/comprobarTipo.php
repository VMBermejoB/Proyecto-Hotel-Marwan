<?php
require_once 'metodos.php';
$objMetodos = new metodos();

$nombre=$_GET["nombre"];

$sentencia = $objMetodos->mysqli->prepare("SELECT * FROM tipo WHERE nombre=?");
$sentencia->bind_param("s", $nombre);
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
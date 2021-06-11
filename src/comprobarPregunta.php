<?php
require_once 'metodos.php';
$objMetodos = new metodos();
    /**
     * Consulta para comprobar que la respuesta es correcta
     */
$correo=$_GET["correo"];
$respuestaUsuario=$_GET["respuestaUsuario"];

$sentencia = $objMetodos->mysqli->prepare("SELECT * FROM usuarios WHERE correo=?");
$sentencia->bind_param("s", $correo);
$sentencia->execute();

$resultado=$sentencia->get_result();
if($resultado->num_rows)
{
    $fila=$resultado->fetch_array();
    if($fila["respuesta"]==$respuestaUsuario)
    {
        echo "1";
    }
    else
    {
        echo "0";
    }
}
else
{
echo "0";
}
?>

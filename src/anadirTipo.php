<?php
    /**
    * Comprueba que se ha iniciado sesión con perfil trabajador
    */
    session_start();
    if($_SESSION["perfil"]!="t"){
        header("Location:disenio.php");
    }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
<nav class="row">
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="consultarTemporadas.php">Temporada</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="mostrarTipo.php">Tipo</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Habitaciones </a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#"> Ofertas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Reservas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
        <img src="imagenes/logo2.PNG">
    </div>
</nav>
<?php
require_once  'metodos.php';
$objMetodos=new metodos();
if(!isset($_POST["enviar"])){
    echo '
        <div class="containter" >
        <main class="row" id="contenedor">
            <article class="row">
                <div class="col-12">
                <form  onsubmit="return validacion()" method="post" action="#" enctype="multipart/form-data">
                    <h2>Añadir Tipo de Habitación</h2>
                    <hr>
                    <div class="form-group">
                        <label for="nombre">Introduce el tipo de habitación</label><br>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Introduce el tipo de habitacion" required/>
                        <label for="descripcion">Introduce la descripción del tipo de habitación</label><br>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Introduce la descripcion del tipo de habitacion" required/>
                        <div class="form-group">
                            <input type="file" class="form-control" id="archivo[]" name="archivo[]" multiple="" required><br>
                        </div>
                    </div>
                     <input type="submit" class="btn btn-primary" name="enviar" value="enviar"/>
                </form>
            </div>
           
            </article>
            </main>
        </div>
     ';
}
else
{

/**
 * Recogemos la variables del formulario $_POST["nombre"] y $_POST["descripcion"];
 */

$nombre=$_POST["nombre"];
$descripcion=$_POST["descripcion"];

/**
 * Ejecutamos consulta preparada
 */

    $sentencia = $objMetodos->mysqli->prepare("INSERT INTO tipo(nombre, descripcion) VALUES (?,?)");
    $sentencia->bind_param("ss", $nombre,$descripcion);
    $resultado=$sentencia->execute();
    $id=$sentencia->insert_id;
    echo $id;

    foreach ($_FILES["archivo"]['tmp_name'] as $archivos =>$tmp_name){

        if($_FILES["archivo"]["name"][$archivos]) {
            $nombrearchivo = $_FILES["archivo"]["name"][$archivos];
            $path = "archivos/".$nombrearchivo;

            copy($_FILES['archivo']['tmp_name'][$archivos], $path);
            if (file_exists($path)) {

                $sentencia = $objMetodos->mysqli->prepare(" INSERT INTO imagenes (nombre) VALUES (?)");
                $sentencia->bind_param("s", $path);
                $sentencia->execute();
                $idImagen=$sentencia->insert_id;

                $consulta="INSERT INTO imagenestipos (idTipo, idImagen) VALUES (".$id.",".$idImagen.")";
                $sentencia = $objMetodos->mysqli->prepare("INSERT INTO imagenestipos (idTipo, idImagen) VALUES (?,?)");
                $sentencia->bind_param("ii", $id, $idImagen);
                $sentencia->execute();

                if($objMetodos->comprobar()<=0){
                    echo '<script>
                               alert("Error al subir los archivos");
                               </script>';
                }
            }
            else
            {
                echo '<script>
                               alert("Error al subir los archivos");
                               </script>';
            }
        }
    }
    /**
     * Comprobamos si hay temporadas al crear los tipos
     */
    $consulta=
        "
            SELECT *
            FROM temporada;
        ";

    $objMetodos->realizarConsultas($consulta);

    if($objMetodos->comprobarSelect()>0)
    {
        $prueba=$objMetodos->comprobarSelect();
        for ($i=0;$i<$prueba;$i++)
        {
            $fila[$i]=$objMetodos->extraerFilas();
        }
        $sentencia = $objMetodos->mysqli->prepare("INSERT INTO temporadaTipo(idTipo, idTemporada) VALUES (?,?)");
        for ($i=0;$i<$prueba;$i++)
        {
            $sentencia->bind_param("ss", $id,$fila[$i]["idTemporada"]);
            $resultado=$sentencia->execute();
        }
        header("Location: precio.php");
    }
    else
    {
        header("Location:consultarTemporadas.php");
    }
}
?>


</body>
</html>
<script>
    /**
    *Comprueba si el nombre que se le quiere poner al nuevo tipo ya existe en la base de datos
     */
    function validacion()
    {
        let nombre = document.getElementById("nombre").value;
        var val=0;
        $.ajax({
            url: "comprobarTipo.php?nombre="+nombre,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {
                if (respuesta == 1) {
                    val=1;
                    alert("El tipo de habitacion "+nombre+" ya existe, inserte otro distinto");
                    window.location="anadirTipo.php";
                }
                else
                {
                    window.location="anadirTipo.php";
                }
            }
        });

        if(val==1){
            return false;
        }
        else
        {
            return true
        }
    }
</script>
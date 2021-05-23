<?php
    if($_SESSION["perfil"]!='t'){
        header("Location:disenio.php");
    }
    if (($_SERVER['HTTP_REFERER'] != "http://localhost/ejercicios/disenioProyecto2/proyecto/reservas.php")){
        header("Location:reservas.php");
    }
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones</title>
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
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Ofertas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
        <img src="imagenes/logo2.PNG">
    </div>
</nav>
<main class="row" id="contenedor">
    <article class="row">
        <div class="col-12">
            <div class="col-12">
                <div class="col-6 confirmacion" id="mensajeConf">
                    <h3 id="mensaje"></h3>
                </div>
<?php
require_once  'metodos.php';
$objMetodos=new metodos();

$consulta=
    "
            SELECT numHabitacion,planta,capacidad,dimesiones,t.idTipo,t.nombre AS tipo,adaptada 
            FROM habitaciones h
	            INNER JOIN tipo t
	            ON t.idTipo=h.idTipo
            WHERE numHabitacion= ".$_GET["numHabitacion"]."
    ";
$objMetodos->realizarConsultas($consulta);

if ($objMetodos->comprobarSelect()>0) {
    $fila = $objMetodos->extraerFilas();
    $numHabitacionBD = $fila["numHabitacion"];
    $numHabitacion = $fila["numHabitacion"];
    $planta = $fila["planta"];
    $capacidad = $fila["capacidad"];
    $dimension = $fila["dimesiones"];
    $idTipo = $fila["idTipo"];
    $tipo = $fila["tipo"];
    $adaptada = $fila["adaptada"];

    $consulta2 =
        "
            SELECT idTipo,nombre 
            FROM tipo
        ";
    $objMetodos->realizarConsultas($consulta2);
    if (!isset($_POST["enviar"])) {
        echo '              
                <form onsubmit="return validacion2()" action="#" method="post">
                <h2>Modificar habitación</h2>
                <hr>
              
                     <label for="numHabitacionBD" class="sr-only"></label>
                     <input type="hidden" id="numHabitacionBD" class="form-control" name="numHabitacionBD" placeholder="Numero de habitacion" value="' . $numHabitacionBD . '" required/></br>
         
                <div class="form-group">
                     <label for="nombre">Número de habitación</label>
                     <input type="text" id="numHabitacion" class="form-control" name="numHabitacion" placeholder="Numero de habitacion" value="' . $numHabitacion . '" required onblur="validacion()"/></br>
                </div>
                <div class="form-group">
                            <label for="planta">Introduce la planta de la habitación</label><br>
                            <input type="number" class="form-control" name="planta" value="' . $planta . '" id="planta" placeholder="Introduce la planta de la habitación" required min="1"/>
                        </div>
                         <div class="form-group">
                            <label for="capacidad">Introduce la capacidad de la habitación</label><br>
                            <input type="number" class="form-control" name="capacidad" value="' . $capacidad . '" id="capacidad" placeholder="Introduce la capacidad de la habitación" required min="1"/>
                        </div>
                        <div class="form-group">
                            <label for="dimension">Introduce la dimension de la habitación</label><br>
                            <input type="number" class="form-control" name="dimension" value="' . $dimension . '" id="dimension" placeholder="Introduce la dimension de la habitación" required min="1"/>
                        </div>
                        <div class="form-group">
                            <label for="planta">Introduce el tipo de la habitación</label><br>
                            <select class="form-select" aria-label="Default select example" name="tipo">
        ';
        while ($fila = $objMetodos->extraerFilas()) {
            if ($fila["idTipo"] == $idTipo) {
                echo '<option name="' . $fila["nombre"] . '" value="' . $fila["idTipo"] . '" selected="true">' . $fila["nombre"] . '</option> ';
            } else {
                echo '<option name="' . $fila["nombre"] . '" value="' . $fila["idTipo"] . '">' . $fila["nombre"] . '</option> ';
            }
        }
        echo '               </select>
                        </div>
                        <div class="form-group">
                        <label>Selecciona si la habitación esta adaptada</label><br>
       ';
        if ($adaptada == 1) {
            echo '
                        <div class="form-group">
                           <input type="radio" class="btn-check" name="adaptada" id="adsi" value="1" checked>
                           <label class="btn btn-outline-primary text-light" for="adsi">Adaptada</label>
                           <input type="radio" class="btn-check" name="adaptada" id="adno" value="0">
                           <label class="btn btn-outline-primary text-light" for="adno">No adaptada</label>
                        </div>
           ';
        } else {
            echo ' 
                            <div class="form-group">
                           <input type="radio" class="btn-check" name="adaptada" id="adsi" value="1">
                           <label class="btn btn-outline-primary text-light" for="adsi">Adaptada</label>
                           <input type="radio" class="btn-check" name="adaptada" id="adno" value="0" checked>
                           <label class="btn btn-outline-primary text-light" for="adno">No adaptada</label>
                        </div>
       ';
        }
        echo '
                     <input type="submit" class="btn btn-primary" name="enviar" value="Enviar"/>';
        echo '</form>

            ';
    }
    else
    {
        $consulta =
            "
                UPDATE habitaciones
                SET numHabitacion='" . $_POST["numHabitacion"] . "',planta='" . $_POST["planta"] . "',capacidad='" . $_POST["capacidad"] . "',dimesiones='" . $_POST["dimension"] . "',idTipo=" . $_POST["tipo"] . ",adaptada=" . $_POST["adaptada"] . " 
                WHERE numHabitacion=" . $_POST["numHabitacionBD"] . ";
           ";
        echo $consulta;

        $objMetodos->realizarConsultas($consulta);
        if($objMetodos->comprobar()<=0){
            echo'<script>
                        document.getElementById("mensaje").innerHTML="Error al añadir la habitación, intentelo de nuevo más tarde";
                        var el = document.getElementById("mensajeConf");
                        el.style.display="block";
                    </script>';

        }
        else
        {
            header("location:mostrarHabitaciones.php");
        }

    }
}
?>
        </div>
    </article>
</main>
</body>
</html>
<script>
    function validacion()
    {
        let numHabitacion = document.getElementById("numHabitacion").value;
        let numHabitacionBD = document.getElementById("numHabitacionBD").value;
        if(numHabitacion==numHabitacionBD)
        {
            return true
        }
        else
        {
            let numHabitacion = document.getElementById("numHabitacion").value;
            var val=0;
            $.ajax({
                url: "comprobarNumHab.php?numHabitacion="+numHabitacion,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        val=1;
                        alert("El numero de habitacion "+numHabitacion+" ya existe, inserte otro distinto");
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
    }
    function validacion2()
    {
        let numHabitacion = document.getElementById("numHabitacion").value;
        let numHabitacionBD = document.getElementById("numHabitacionBD").value;
        if(numHabitacion==numHabitacionBD)
        {
            alert("Se ha modificado la habitación "+numHabitacion+ " correctamente");
            window.location="mostrarHabitaciones.php";
            return true
        }
        else
        {
            let numHabitacion = document.getElementById("numHabitacion").value;
            var val=0;
            $.ajax({
                url: "comprobarNumHab.php?numHabitacion="+numHabitacion,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        val=1;
                        alert("El numero de habitacion "+numHabitacion+" ya existe, inserte otro distinto");
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
    }
</script>
<?php
/**
 * Comprobación de perfiles
 */
session_start();

    if(!isset($_SESSION["perfil"])){
        header("Location:index.php");
    }

    if($_SESSION["perfil"]!="t"){
        header("Location:index.php");
    }

    if(!isset($_GET["numHabitacion"]) || empty($_GET["numHabitacion"])){
        header("Location:index.php");
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<nav class="row">

    <div class="col-6 col-sm-2 col-xl-1 d-flex align-items-center"><a href="consultarTemporadas.php">Temporadas</a></div>
    <div class="col-6 col-sm-1 d-flex align-items-center"><a href="mostrarTipo.php">Tipos</a></div>
    <div class="col-6 col-sm-2 col-xl-1 d-flex align-items-center"><a href="mostrarHabitaciones.php">Habitaciones </a></div>
    <div class="col-6 col-sm-1 d-flex align-items-center"><a href="precio.php">Precios </a></div>
    <div class="col-6 col-sm-1 d-flex align-items-center"><a href="mostrarOfertas.php">Ofertas</a></div>
    <div class="col-6 col-sm-1 d-flex align-items-center"><a href="mostrarReserva.php">Reservas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto d-none d-md-block d-flex align-items-center">
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
require_once 'metodos.php';
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

        echo '              
                <form onsubmit="return validacion()" action="#" method="post">
                <h2>Modificar habitación</h2>
                <hr>
              
                     <label for="numHabitacionBD" class="sr-only"></label>
                     <input type="hidden" id="numHabitacionBD" class="form-control" name="numHabitacionBD" placeholder="Numero de habitacion" value="' . $numHabitacionBD . '" required/></br>
         
                <div class="form-group">
                     <label for="nombre">Número de habitación</label>
                     <input type="number" id="numHabitacion" class="form-control" name="numHabitacion" placeholder="Numero de habitacion" value="' . $numHabitacion . '" min="1" max="999" required "/></br>
                </div>
                <div class="form-group">
                            <label for="planta">Introduce la planta de la habitación</label><br>
                            <input type="number" class="form-control" minlength="1" maxlength="3" name="planta" value="' . $planta . '" id="planta" placeholder="Introduce la planta de la habitación" required min="1" max="9"/>
                        </div>
                         <div class="form-group">
                            <label for="capacidad">Introduce la capacidad de la habitación</label><br>
                            <input type="number" class="form-control" name="capacidad" value="' . $capacidad . '" id="capacidad" placeholder="Introduce la capacidad de la habitación" required min="1" max="9"/>
                        </div>
                        <div class="form-group">
                            <label for="dimension">Introduce la dimension de la habitación</label><br>
                            <input type="number" class="form-control" name="dimension" value="' . $dimension . '" id="dimension" placeholder="Introduce la dimension de la habitación" required min="1" max="255"/>
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
    if (isset($_POST["enviar"])) {

        if(!isset($_POST["numHabitacion"]) || empty($_POST["numHabitacion"]) || !isset($_POST["planta"]) || empty($_POST["planta"]) ||
            !isset($_POST["capacidad"]) || empty($_POST["capacidad"]) || !isset($_POST["dimension"]) || empty($_POST["dimension"]) ||
            !isset($_POST["tipo"]) || empty($_POST["tipo"])){

            echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Rellene todos los campos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';
        }
        else {
            $consulta =
                "
                    UPDATE habitaciones
                    SET numHabitacion='" . $_POST["numHabitacion"] . "',planta='" . $_POST["planta"] . "',capacidad='" . $_POST["capacidad"] . "',dimesiones='" . $_POST["dimension"] . "',idTipo=" . $_POST["tipo"] . ",adaptada=" . $_POST["adaptada"] . " 
                    WHERE numHabitacion=" . $_POST["numHabitacionBD"] . ";
               ";

            $objMetodos->realizarConsultas($consulta);
            if ($objMetodos->comprobar() < 0) {
                echo '<script>
                 Swal.fire({
                title:"Error",
                icon:"error",
                text:"Error al modificar la habitación",
                confirmButtonColor: "#011d40",
                confirmButtonText:"Aceptar",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
                 })
                        </script>';

            } else {
                echo '<script>
                 Swal.fire({
                 title:"Éxito",
                icon:"success",
                text:"La habitación se ha modificado con éxito",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#011d40",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
                 }).then((result) => {
                if (result.isConfirmed) {
                    window.top.location="mostrarHabitaciones.php";
                }
            })
              </script>';

            }
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
                        Swal.fire({
                            title:"Error",
                            icon:"error",
                            text:"La habitación ya existe, elige otro distinto",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#011d40",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        })
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
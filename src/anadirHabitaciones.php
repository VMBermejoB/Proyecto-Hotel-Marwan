
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir habitaciones</title>
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
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="mostrarTipo.php">Tipos</a></div>
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
<?php
require_once  'metodos.php';
$objMetodos=new metodos();

    $consulta=
        "
            SELECT idTipo,nombre 
            FROM tipo
        ";
    $objMetodos->realizarConsultas($consulta);
    if($objMetodos->comprobarSelect()) {
        echo '
        
                    <div class="col-12">             
                    <div class="col-6 confirmacion" id="mensajeConf">
                            <h3 id="mensaje"></h3>
                    </div>
                 <div class="col-12">
                    <form  onsubmit="return validacion2()" method="post" action="#" >
                        <h2>Añadir Habitación</h2>
                        <hr>
                        <div class="form-group">
                            <label for="numHabitacion">Introduce el numero de la habitación</label><br>
                            <input type="number" class="form-control" name="numHabitacion" id="numHabitacion" maxlength="3" placeholder="Introduce el numero de la habitacion" required onblur="validacion()" min="1"/>
                        </div>
                        <div class="form-group">
                            <label for="planta">Introduce la planta de la habitación</label><br>
                            <input type="number" class="form-control" name="planta" id="planta" placeholder="Introduce la planta de la habitación" required min="1"/>
                        </div>
                         <div class="form-group">
                            <label for="capacidad">Introduce la capacidad de la habitación</label><br>
                            <input type="number" class="form-control" name="capacidad" id="capacidad" placeholder="Introduce la capacidad de la habitación" required min="1"/>
                        </div>
                        <div class="form-group">
                            <label for="dimension">Introduce la dimension de la habitación</label><br>
                            <input type="number" class="form-control" name="dimension" id="dimension" placeholder="Introduce la dimension de la habitación" required min="1"/>
                        </div>
                        <div class="form-group">
                            <label for="planta">Introduce el tipo de la habitación</label><br>
                            <select class="form-select" aria-label="Default select example" name="tipo" id="tipo" onblur="validacion()">
                            <option selected="true" disabled="disabled" value="-1">Seleccione el tipo de habitacion</option>
        ';                  while ($fila=$objMetodos->extraerFilas())
                            {
                                echo '<option name="'.$fila["nombre"].'" value="'.$fila["idTipo"].'">'.$fila["nombre"].'</option> ';
                            }
    echo '                    </select>
                        </div>
                        <div class="form-group">
                        <label>Selecciona si la habitación esta adaptada</label><br>
                           <input type="radio" class="btn-check" name="adaptada" id="adsi" value="1">
                           <label class="btn btn-outline-primary text-light" for="adsi">Adaptada</label>
                           <input type="radio" class="btn-check" name="adaptada" id="adno" value="0" checked>
                           <label class="btn btn-outline-primary text-light" for="adno">No adaptada</label>
                        </div>
                         <input type="submit" class="btn btn-primary" name="enviar" value="enviar"/>
                    </form>
                </div>
            </div>
         ';
    }


if(isset($_POST["enviar"])){
 $consulta=
 "
    INSERT INTO habitaciones(numHabitacion, planta, capacidad, dimesiones, idTipo, adaptada)
    VALUES ('".$_POST["numHabitacion"]."','".$_POST["planta"]."','".$_POST["capacidad"]."','".$_POST["dimension"]."',".$_POST["tipo"].",".$_POST["adaptada"].");
 ";

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
        echo'<script>
                        document.getElementById("mensaje").innerHTML="Habitación añadida correctamente";
                        var el = document.getElementById("mensajeConf");
                        el.style.display="block";
                    </script>
                ';
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
        var val=0;
        $.ajax({
            url: "comprobarNumHab.php?numHabitacion="+numHabitacion,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {
                if (respuesta == 1) {
                    val=1;
                    alert("El número de habitacion "+numHabitacion+" ya existe, inserte otro distinto");
                    window.location="anadirHabitaciones.php";
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
    function validacion2()
    {
        validacion();
        let tipo = document.getElementById("tipo").value;
        if(tipo==-1)
        {
            alert("Seleccione un tipo de habitación");
            return false
        }
    }
</script>
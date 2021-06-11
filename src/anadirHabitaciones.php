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
?>
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
<?php
require_once  'metodos.php';
$objMetodos=new metodos();
/**
 * Se comprueba si hay tipos añadodos antes de poder añadir las habitaciones
 */
    $consulta="SELECT * FROM tipo";
    $objMetodos->realizarConsultas($consulta);
    if($objMetodos->comprobarSelect()<=0){
        echo '<script>
                 Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Por favor, introduzca primero tipos de habitación",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                            if (result.isConfirmed) {
                                window.top.location="anadirTipo.php";
                            }
                        })
                        </script>';
    }
/**
 * Selecciona los tipos
 */
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
                 <form  onsubmit="return validacion()" method="post" action="#" >
                        <h2>Añadir Habitación</h2>
                        <hr>
                        <div class="form-group">
                            <label for="numHabitacion">Introduce el numero de la habitación</label><br>
                            <input type="number" class="form-control" name="numHabitacion" id="numHabitacion" placeholder="Introduce el numero de la habitacion" required  min="1" max="999"/>
                        </div>
                        <div class="form-group">
                            <label for="planta">Introduce la planta de la habitación</label><br>
                            <input type="number" class="form-control" name="planta" minlength="1" maxlength="1" id="planta" placeholder="Introduce la planta de la habitación" required min="1" max="9"/>
                        </div>
                         <div class="form-group">
                            <label for="capacidad">Introduce la capacidad de la habitación</label><br>
                            <input type="number" class="form-control" name="capacidad" minlength="1" maxlength="1" id="capacidad" placeholder="Introduce la capacidad de la habitación" required min="1" max="9"/>
                        </div>
                        <div class="form-group">
                            <label for="dimension">Introduce la dimension de la habitación</label><br>
                            <input type="number" class="form-control" name="dimension" min="1" max="255" id="dimension" placeholder="Introduce la dimension de la habitación" required/>
                        </div>
                        <div class="form-group">
                            <label for="planta">Introduce el tipo de la habitación</label><br>
                            <select class="form-select" aria-label="Default select example" name="tipo" id="tipo">
                            <option selected="true" disabled="disabled" value="-1">Seleccione el tipo de habitacion</option>
        ';
        /**
         * Se extraen cada una de las filas de los tipos para mostrarlos en el select
         */
                            while ($fila=$objMetodos->extraerFilas())
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
                         <input type="submit" class="btn btn-primary" name="enviar" value="Enviar"/>
                    </form>
                </div>
            </div>
         ';
    }


if(isset($_POST["enviar"])){

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
    else
    {
        /**
         * Se insertan los datos en la tabla de habitaciones
         */
        $consulta=
            "
    INSERT INTO habitaciones(numHabitacion, planta, capacidad, dimesiones, idTipo, adaptada)
    VALUES ('".$_POST["numHabitacion"]."','".$_POST["planta"]."','".$_POST["capacidad"]."','".$_POST["dimension"]."',".$_POST["tipo"].",".$_POST["adaptada"].");
 ";

        $objMetodos->realizarConsultas($consulta);
        if($objMetodos->comprobar()<=0){

            echo'<script>
                     Swal.fire({
                            title: "Error",
                            text: "No se se ha añadido la habitación",
                            icon: "error",
                            confirmButtonColor: "#011d40",
                          confirmButtonText: "Aceptar",
                           allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        }).then((result) => {
                 
                          if (result.isConfirmed) {
                           setTimeout(function (){window.location.replace("mostrarHabitaciones.php");},1000)
                          }
                      });
         </script>';

        }
        else
        {
            echo'<script>

                        Swal.fire({
                            title: "Éxito",
                            text: "Se ha añadido correctamente",
                            icon: "success",
                          confirmButtonText: "Aceptar",
                          confirmButtonColor: "#011d40",
                          allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        }).then((result) => {
           
                          if (result.isConfirmed) {
                          window.location.replace("mostrarHabitaciones.php");
                          }
                      });
         </script>
                ';
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

    /**
     *
     * @returns {boolean}
     */

    /**
     *
     * Comprueba si la habitación existe
     */
    function validacion()
    {
        let numHabitacion = document.getElementById("numHabitacion").value;

        let tipo = document.getElementById("tipo").value;

        var val=0;

        if(tipo==-1)
        {
            Swal.fire({
                title: "Error",
                text: "Seleccione un tipo de habitación",
                icon: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#011d40",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
            });
            return false
        }


        $.ajax({
            url: "comprobarNumHab.php?numHabitacion="+numHabitacion,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {
                if (respuesta == 1) {
                    val=1;
                    Swal.fire({
                        title: "Error",
                        text: "La habitación ya existe",
                        icon: "error",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });

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
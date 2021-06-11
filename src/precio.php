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
    <title>Tipos</title>
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
<div class="containter" >
    <main class="row" id="contenedor">
        <article class="row">

            <div class="col-6 confirmacion" id="mensajeConf">
                <h3 id="mensaje"></h3>
            </div>

            <div class="col-12">
<?php
require_once 'metodos.php';

/**
 * Extrae los datos de la tabla temporadatipo para insertar los precios
 */
$objMetodos=new metodos();
$consulta=
    "
       SELECT t.idTemporada, t.anio, t.nombre AS temporada,tp.idTipo,tp.nombre AS tipoHabitacion,tt.precio
        FROM temporadaTipo tt INNER JOIN temporada t
        ON tt.idTemporada=t.idTemporada
	        INNER JOIN tipo tp
            ON tt.idTipo=tp.idTipo
        ORDER BY tt.idTipo, tt.idTemporada
    ;";
$objMetodos->realizarConsultas($consulta);
if($objMetodos->comprobarSelect()>0)
{
        echo '
        
        <div class="container">
            <div class="row">
                <div class="col-12">
                <form onsubmit="validacion()"  method="post" action="#" >
                    <h2>Gestión Precios</h2>
                    <hr>
                    <table class="table table-hover">
                        <thead class="">
                            <tr>
                                <th scope="col">Año</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Temporada</th>
                                <th scope="col">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                    
        ';
        /**
         * Crea la tabla de forma dinámica dependiendo de las filas que haya en la tabla temporadatipo
         */
        while ($fila=$objMetodos->extraerFilas())
        {
            echo '
                          <tr>
                            <td>'.$fila["anio"].'</td>
                            <td>'.$fila["tipoHabitacion"].'</td>
                            <td>'.$fila["temporada"].'</td>
                            <td>
                            <div>
                            <input type="number" class="form-control" id="precio" name="precio[]" value="'.$fila["precio"].'"  placeholder="Insertar precio"  min="1" max="999.99" step="any" required/>
                         </div>
                         </td>
                          </tr>
                        
                            
                ';
        }
        echo'
                        </table>
                     <input type="submit" class="btn btn-primary" name="enviar" value="enviar"/>
                </form>
            </div>
          </div> 
        </div>
     ';
    }
    else
    {
        /**
         * Si no hay datos en la tabla temporadatipo, muestra el siguiente mensaje de error
         */
        echo
        '
            <script>
                Swal.fire({
            title:"Error",
            icon: "error",
            text:"Se deben insertar temporadas y tipos de habitaciones",
            confirmButtonColor: "#011d40",
            confirmButtonText:"Aceptar",
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            stopKeydownPropagation:false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.top.location="consultarTemporadas.php";
            }
        })
            </script>
        ';
    }
        /**
         * Extrae los datos de la tabla temporadatipo
         */
        if(isset($_POST["enviar"])){
            $consulta=
                "
            SELECT *
            FROM temporadaTipo
            ORDER BY idTipo, idTemporada;
        ";

            $objMetodos->realizarConsultas($consulta);

            /**
             * Si hay datos, introduce los precios
             */
            if($objMetodos->comprobarSelect()>0)
            {
                $prueba=$objMetodos->comprobarSelect();
                for ($i=0;$i<$prueba;$i++)
                {
                    $fila[$i]=$objMetodos->extraerFilas();
                }
                $sentencia = $objMetodos->mysqli->prepare("UPDATE temporadaTipo SET precio=? WHERE idTipo=? AND idTemporada=?");
                for ($i=0;$i<$prueba;$i++)
                {
                    $sentencia->bind_param("sss", $_POST["precio"][$i],$fila[$i]["idTipo"], $fila[$i]["idTemporada"]);
                    $resultado=$sentencia->execute();
                }
            }

            if($sentencia->affected_rows<0){
                echo
                '
                <script>
                    Swal.fire({
                    title:"Error",
                    icon: "error",
                    text:"Se ha producido un error al añadir los precios para las habitaciones, por favor intentelo de nuevo más tarde",
                    confirmButtonColor: "#011d40",
                    confirmButtonText:"Aceptar",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    stopKeydownPropagation:false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.top.location="precio.php";
                        }
                    })
                </script>
        ';
            }
            else
            {
                echo
                '
            <script>
                Swal.fire({
            title:"Éxito",
            icon: "success",
            text:"Se han añadido los precios correctamente",
            confirmButtonColor: "#011d40",
            confirmButtonText:"Aceptar",
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            stopKeydownPropagation:false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.top.location="precio.php";
            }
        })
            </script>
        ';
            }

        }
?>
            </div>
        </article>
    </main>
</div>
</body>
</html>



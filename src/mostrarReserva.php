<?php
require_once  'metodos.php';
$objMetodos=new metodos();


/**
 * Comprobación de perfiles
 */
    session_start();

    if (!isset($_SESSION["perfil"])) {
        header("Location:index.php");
    }

    if ($_SESSION["perfil"] != "t") {
        header("Location:index.php");
    }


/**
 * Comprobación para el borrado de reservas
 */


if(isset($_GET["del"]))
{
    $id=$_GET['del'];
    $consulta2=
        "
            DELETE  
            FROM reservas
            WHERE idReserva=".$id.";
       ";
    $objMetodos->realizarConsultas($consulta2);
    header("location:mostrarReserva.php");
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Reservas</title>
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
                    <div class="row">
        <?php
        $consulta=
               "
                    SELECT r.idReserva,u.nombre,u.correo,r.fInicio,r.fFin
                    FROM reservas r
                    INNER JOIN
                    usuarios u
                    ON r.idUsuario=u.idUsuario
                    ORDER BY r.fInicio DESC;
               ";
           $objMetodos->realizarConsultas($consulta);
           if ($objMetodos->comprobarSelect()>0)
           {
               echo
               '
                  <table class="tamanioceldas table table-striped table-hover" >
                    <thead>
                        <tr>
                          <th scope="col">Nombre Cliente</th>
                          <th scope="col">Correo Cliente</th>
                          <th scope="col">Fecha llegada</th>
                          <th scope="col">Fecha salida</th>
                          <th scope="col">Descargar</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    
               ';
                    for($i=0;$i<$fila=$objMetodos->extraerFilas();$i++){

                        $tfIn=explode("-", $fila["fInicio"]);
                        $fIn=$tfIn[2]."/".$tfIn[1]."/".$tfIn[0];

                        $tfFin=explode("-", $fila["fFin"]);
                        $fFin=$tfFin[2]."/".$tfFin[1]."/".$tfFin[0];

            echo'   
                   <tbody class="table-striped">
                      <tr>
                        <th>'.$fila["nombre"].'</th>
                        <td>'.$fila["correo"].'</td>
                        <td>'.$fIn.'</td>
                        <td>'.$fFin.'</td>
            ';
        echo'         
                      <td><button type="button" class="btn btn-secondary info" ><a href="generarPdf.php?reserva='.$fila["idReserva"].'"><img src="imagenes/iconos/pdf.png"></a></button></td>
                      <td><button type="button" class="btn btn-secondary info" ><a href="#" onclick="preguntar('.$fila["idReserva"].')"><img src="imagenes/iconos/papelera.png"></a></button></td>
                      </tr>
               ';
                   }
           echo '    
                   </tbody>
                </table>
           
               ';
           }
           else
           {

                   echo
                   '
               
                  <table class="table table-striped table-hover" >
                    <thead>
                        <tr>
                          <th scope="col">Nombre Cliente</th>
                          <th scope="col">Correo Cliente</th>
                          <th scope="col">Fecha llegada</th>
                          <th scope="col">Fecha salida</th>
                          <th scope="col">Descargar</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                   <tbody class="table-striped">
                      <tr>
                        <th scope="col-12" colspan="6" class="text-center">No hay reservas</th>
                      </tr>
                   </tbody>
                  </table>
               ';

           }
        ?>
            </div>
        </article>
        </main>
    </body>
</html>
<script>

    /**
     * Confirmación de borrado de reserva
     * @param id
     */
    function preguntar(id)
    {
        Swal.fire({
            title:"Atención",
            icon:"warning",
            text:"¿Deseas eliminar la reserva?",
            confirmButtonColor: "#011d40",
            confirmButtonText:"Aceptar",
            cancelButtonText:"Cancelar",
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            stopKeydownPropagation:false,
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                window.top.location="mostrarReserva.php?del="+id;
            }
        })
    }
</script>
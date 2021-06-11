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
 * Comprueba si se ha pulsado el botón de borrado para eliminar la oferta
 */
if(isset($_GET["delo"]) and isset($_GET["delt"]))
{
    $idOferta=$_GET['delo'];
    $idTipo=$_GET['delt'];
    $consulta2=
        "
            DELETE  
            FROM oferta
            WHERE idOferta=".$idOferta." AND idTipo=".$idTipo.";
       ";
    $objMetodos->realizarConsultas($consulta2);


    header("location:mostrarOfertas.php");
}
?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>Ofertas</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

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
                <div class="row justify-content-center">
                    <a href="anadirOfertas.php" class="btn btn-primary col-2"> Añadir Oferta</a>
                </div>

<?php
$consulta=
       "
            SELECT o.idOferta,t.idTipo,t.nombre,o.fInicio,o.fFin,o.porcentaje
            FROM oferta o
            INNER JOIN
            tipo t
            ON o.idTipo=t.idTipo
       ";
   $objMetodos->realizarConsultas($consulta);
   if ($objMetodos->comprobarSelect()>0)
   {
       echo
       '

        
            
          <table class="tamanioceldas table table-striped table-hover" >
            <thead>
                <tr>
                  <th scope="col">Tipo de habitación</th>
                  <th scope="col">Fecha inicio de la oferta</th>
                  <th scope="col">Fecha fin de la oferta</th>
                  <th scope="col">Descuento</th>
                  <th scope="col">Modificar</th>
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
                <td>'.$fIn.'</td>
                <td>'.$fFin.'</td>
                <td>'.$fila["porcentaje"].'</td>
    ';
echo'
                <td><button type="button" class="btn btn-secondary info" ><a href="modificarOfertas.php?oferta='.$fila["idOferta"].'&tipo='.$fila["idTipo"].'"><img src="imagenes/iconos/editar.png"></a></button></td>
                <td><button type="button" onclick="preguntar('.$fila["idOferta"].','.$fila["idTipo"].')" class="btn btn-secondary info" ><a href="#"><img src="imagenes/iconos/papelera.png"></a></button></td> 
              
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
                  <th scope="col">Tipo de habitación</th>
                  <th scope="col">Fecha inicio de la oferta</th>
                  <th scope="col">Fecha fin de la oferta</th>
                  <th scope="col">Porcentaje de descuento</th>
                  <th scope="col">Eliminar</th>
                </tr>
            </thead>
           <tbody class="table-striped">
              <tr>
                <th scope="col-12" colspan="5" class="text-center">No hay ofertas</th>
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
    function preguntar(idOferta,idTipo)
    {
        Swal.fire({
            icon:"warning",
            text:"¿Deseas eliminar oferta?",
            confirmButtonColor: "#011d40",
            confirmButtonText:"Aceptar",
            cancelButtonText:"Cancelar",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            stopKeydownPropagation:false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.top.location="mostrarOfertas.php?delo="+idOferta+"&delt="+idTipo;
            }
        })

    }
</script>
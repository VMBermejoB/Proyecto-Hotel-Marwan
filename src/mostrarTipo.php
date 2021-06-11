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


require_once  'metodos.php';
$objMetodos=new metodos();

if(isset($_GET["del"]))
{
    $id=$_GET['del'];

    $consulta2=
        "
            DELETE
            FROM tipo
            WHERE idTipo=".$id.";
       ";
    $objMetodos->realizarConsultas($consulta2);


    header("location:mostrarTipo.php");
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
                <div class="col-12">
    <?php
        /**
         * Extrae los datos de la tabla tipo
         */
    $consulta=
           "
                SELECT * FROM tipo
           ";
       $objMetodos->realizarConsultas($consulta);
       /**
        * Si hay datos en la tabla tipo los muestra en una tabla
        */
       echo
       '
            <div class="row justify-content-center">
                <a href="anadirTipo.php" class="btn btn-primary col-2"> Añadir Tipos</a>
            </div>
       ';
       if ($objMetodos->comprobarSelect()>0)
       {
           echo
           '
            <div id =contenedor>
              <table class="tamanioceldas table table-hover" >
                <thead>
                    <tr>
                      <th scope="col">Tipo</th>
                      <th scope="col">Descripción</th>
                      <th scope="col">Modificar</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                </thead>
           ';
           /**
            * Crea la tabla de forma dinámica según los datos extraidos de la tabla tipos
            */
                for($i=0;$i<$fila=$objMetodos->extraerFilas();$i++){
        echo'   
               <tbody class="table-striped">
                  <tr>
                  
                    <td>'.$fila["nombre"].'</td>
                    <td>'.$fila["descripcion"].'</td>
                    <td><button type="button" class="btn btn-secondary info" ><a href="modificarTipos.php?idTipo='.$fila["idTipo"].'"><img src="imagenes/iconos/editar.png"></a></button></td>
                    <td><button type="button" class="btn btn-secondary info" ><a href="#" onclick="preguntar('.$fila["idTipo"].')"><img src="imagenes/iconos/papelera.png"></a></button></td>
                  </tr>
           ';
               }
       echo '    
               </tbody>
            </table>
        </div>
           ';
       }
       else
       {

           if($objMetodos->comprobarSelect()<0)
           {
               echo 'Se ha producido un error al mostrar los tipos de habitaciones existentes';
           }
           else
           {
               echo
               '
            <div id =contenedor>
              <table class="table table-hover" >
                <thead class="">
                    <tr>
                      <th scope="col">ID Tipo</th>
                      <th scope="col">Tipo</th>
                      <th scope="col">Descripción</th>
                      <th scope="col">Modificar</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                </thead>
               <tbody class="table-striped">
                  <tr>
                   <th scope="col-12" colspan="5" class="text-center">No hay tipos de habitaciones añadidos</th>
                  </tr>
               </tbody>
              </table>
           ';
           }
       }
    ?>
                </div>
            </article>
        </main>
    </div>
    <script>
        /**
        * Alert de confirmación para elimiminar los tipos
        */
        function preguntar(id)
        {
            Swal.fire({
                title:"Atención",
                icon:"warning",
                text:"¿Deseas eliminar el tipo de habitación?",
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
                    window.top.location="mostrarTipo.php?del="+id;
                }
            })
        }
    </script>
</body>
</html>
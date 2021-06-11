<?php
require_once  'metodos.php';
$objMetodos=new metodos();

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

    if(isset($_GET["del"]))
    {
        $id=$_GET['del'];
        $consulta2=
            "
                DELETE  
                FROM habitaciones
                WHERE numHabitacion=".$id.";
           ";
        $objMetodos->realizarConsultas($consulta2);
        header("location:mostrarHabitaciones.php");
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
                    <div class="row">
        <?php

        /**
         *Extraer datos de habitaciones
         */
        $consulta=
               "
                    SELECT numHabitacion,planta,capacidad,dimesiones,t.nombre AS tipo,adaptada 
                    FROM habitaciones h
                        INNER JOIN tipo t
                        ON t.idTipo=h.idTipo
               ";
           $objMetodos->realizarConsultas($consulta);
        /**
         * Mostrar los datos de las habitaciones en una tabla
         */
           if ($objMetodos->comprobarSelect()>0)
           {
               echo
               '
                           
                  <table class="table table-striped table-hover" >
                    <thead>
                        <tr>
                          <th scope="col">Número de Habitación</th>
                          <th scope="col">Planta</th>
                          <th scope="col">Capacidad</th>
                          <th scope="col">Dimensiones</th>
                           <th scope="col">Tipo</th>
                           <th scope="col">Adaptada</th>
                          <th scope="col">Modificar</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    
               ';
                    for($i=0;$i<$fila=$objMetodos->extraerFilas();$i++){
            echo'   
                   <tbody class="table-striped">
                      <tr>
                        <th scope="row">'.$fila["numHabitacion"].'</th>
                        <td>'.$fila["planta"].'</td>
                        <td>'.$fila["capacidad"].'</td>
                        <td>'.$fila["dimesiones"].'</td>
                        <td>'.$fila["tipo"].'</td>
            ';            if($fila["adaptada"]==1)
                        {
                           echo '<td>Si</td>';
                        }
                        else
                        {
                            echo '<td>No</td>';
                        }
        echo'         
                        <td><button type="button" class="btn btn-secondary info" ><a href="modificarHabitaciones.php?numHabitacion='.$fila["numHabitacion"].'"><img src="imagenes/iconos/editar.png"></a></button></td>
                        <td><button type="button" class="btn btn-secondary info" ><a href="#" onclick="preguntar('.$fila["numHabitacion"].')"><img src="imagenes/iconos/papelera.png"></a></button></td>
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
               /**
                * Muestra una tabla que contiene el mensaje "No hay habitaciones añadidas" en el caso de que no se encuentre habitaciones
                */
                   echo
                   '
               
                  <table class="table table-striped table-hover" >
                   <thead>
                        <tr>
                          <th scope="col">Número de Habitación</th>
                          <th scope="col">Planta</th>
                          <th scope="col">Capacidad</th>
                          <th scope="col">Dimensiones</th>
                           <th scope="col">Tipo</th>
                           <th scope="col">Adaptada</th>
                          <th scope="col">Modificar</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                   <tbody class="table-striped">
                      <tr>
                        <th scope="col-12" colspan="8" class="text-center">No hay habitaciones añadidas</th>
                      </tr>
                   </tbody>
                  </table>
               ';

           }
        ?>
                        <div class="row justify-content-center">
                            <a href="anadirHabitaciones.php" class="btn btn-primary col-2"> Añadir Habiación</a>
                        </div>
            </div>
        </article>
        </main>
    </body>
</html>
<script>
    function preguntar(id)
    {
        Swal.fire({
            title:"Atención",
            icon:"warning",
            text:"¿Deseas eliminar la habitación?",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText:"Cancelar",
            confirmButtonColor: "#011d40",
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            stopKeydownPropagation:false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.top.location="mostrarHabitaciones.php?del="+id;
            }
        })

    }
</script>
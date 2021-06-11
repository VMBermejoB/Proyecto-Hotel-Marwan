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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Temporadas</title>
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

            require 'procesosApp.php';
            $objProcesos=new procesosApp();

            require_once 'metodos.php';
            $objConexion=new metodos();

            /**
             * Extrae todas las temporadas de la base de datos
             */
            $consulta="SELECT * FROM temporada";
            $objConexion->realizarConsultas($consulta);

            /**
             * Comprueba si se han obtenido resultados para crear las tablas
             */
            if($objConexion->comprobarSelect()>0){

                echo'
                <table class="table table-striped table-hover" >
                    <thead>
                        <tr>
                         
                          <th scope="col">Temporada</th>
                          <th scope="col">Fecha Inicio</th>
                          <th scope="col">Fecha Fin</th>
                          <th scope="col">Año</th>
                          
                        </tr>
                    </thead>
                    ';
                for($i=0;$i<$fila=$objConexion->extraerFilas();$i++){

                    /**
                     * Cambio de formato de fecha
                     */

                    $tfIn=explode("-", $fila["fInicioTemp"]);
                    $fIn=$tfIn[2]."/".$tfIn[1]."/".$tfIn[0];

                    $tfFin=explode("-", $fila["fFinTemp"]);
                    $fFin=$tfFin[2]."/".$tfFin[1]."/".$tfFin[0];
                    echo'
                    
                      <tr>           
                        <td>'.$fila["nombre"].'</td>
                        <td>'.$fIn.'</td>
                        <td>'.$fFin.'</td>
                        <td>'.$fila["anio"].'</td>
                      </tr>
       ';
                }
                echo '    
           
        </table>
    </div>';
            }
            /**
             * Formulario para añadir o modificar temporadas
             */
        ?>
            <div class="row">
                <div class="col-12">
                    <form method="post" onsubmit="return validarCrear()" action="gestionTemporadas.php">
                        <h3>Gestión de Temporadas</h3>
                        <div class="form-group">
                            <label for="pass1">Introduzca el año </label>
                            <input name ="anio" class="form-control" id="anio" type="text" required/>
                        </div>
                        <input type="submit" class="btn btn-primary" id="submit" onclick="comprobarSubmit(1)" name="crear" value="Crear temporadas"><br>
                        <input type="submit" class="btn btn-primary" id="submit" onclick="comprobarSubmit(2)" name="modificar" value="Modificar temporadas"><br>
                    </form>
                </div>
            </div>
            </div>
        </article>    
    </main>
</body>
</html>

<script>

    /**
    * Comprueba si se ha pulsado
    */
    function comprobarSubmit(boton){
        opcion=boton;
    }
    function validarCrear(){
        anio=document.getElementById("anio").value;
        var val=0;


        if(/^\d{4}$/.test(anio)===false){
            Swal.fire({
                title:"Error",
                icon:"error",
                text:"Introduzca un año válido",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#011d40",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
            }).then((result) => {
                if (result.isConfirmed) {

                }
            });
            return false;
        }
        /**
        * Si se ha pulsado el botón añadir, comprueba que el año no esté en la base de datos
        */
        if(opcion==1){
            $.ajax({
                url: "comprobarAnio.php?anio="+anio,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if(respuesta==1){
                        Swal.fire({
                            title: "Error",
                            icon:"error",
                            text:"El año ya existe",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#011d40",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        }).then((result) => {
                            if (result.isConfirmed) {

                            }
                        });
                        return false;
                    }
                    else
                    {
                        val=1;
                    }
                }
            });

        }
        else
        {
            /**
            * Si se ha pulsado el botón modificar, se comprueba que el año esté en la base de datos
             */
            $.ajax({
                url: "comprobarAnio.php?anio="+anio,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if(respuesta==0){
                        Swal.fire({
                            title:"Error",
                            icon:"error",
                            text:"Para modificar elija un año diferente",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#011d40",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        }).then((result) => {
                            if (result.isConfirmed) {

                            }
                        });
                        return false;
                    }
                    else
                    {
                        val=1;
                    }
                }
            });


        }
        if(val==1){
            return true;
        }
        else
        {
            return false
        }

    }


</script>

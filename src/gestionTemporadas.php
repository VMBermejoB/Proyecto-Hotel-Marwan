<?php
    session_start();
    if($_SESSION["perfil"]!="t"){
        header("Location:disenio.php");
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>


<nav class="row">
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="consultarTemporadas.php">Temporadas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Tipos</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Habitaciones </a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Ofertas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Reservas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
        <img src="imagenes/logo2.PNG">
    </div>
</nav>
<main class="row" id="contenedor">
    <article class="row">
            <div class="col-12">
                <?php
                require 'procesosApp.php';
                $objProcesos=new procesosApp();

                require_once 'metodos.php';
                $objConexion=new metodos();
/**
 * Permite comprobar si se ha accedido desde la página de consultar temporadas o desde URL, permitiendo solo el acceso desde la págia de consultar temporadas
 */
                if(isset($_POST["anio"])){
                    $anio=$_POST["anio"];
                }
                else
                {
                    header("Location:consultarTemporadas.php");
                }



                if(isset($_POST["modificar"])){
                    $consulta="DELETE FROM temporada WHERE anio=".$anio;
                    $objConexion->realizarConsultas($consulta);

                }
                echo'
                <form method="post" action="'.$objProcesos->anadirTemporadas().'">
                    <h2>Fechas de temporadas</h2>
                    <input type="hidden" id="anio" name="anio" value="'.$anio.'">
                    <div class="form-group row justify-content-center">
                     
                        <label for="fIn1" class="col-6">Inicio temporada Media</label>
                        <label for="fFin1" class="col-6">Final temporada Media</label>
                       
                        <input type="text" class="col-5" id="fIn1" autocomplete="off" onkeydown="return false" name="fIn1" value="01/01/'.$anio.'" readonly required>                   
                        <input type="text" class="offset-1 col-5" id="datepicker" autocomplete="off" name="fFin1" onchange="fecha()" onkeydown="return false" required></p>

                       
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="fIn2" class="col-6">Inicio temporada Alta</label>
                        <label for="fFin2" class="col-6">Final temporada Alta</label>
                        
                        <input type="text" class="col-5" id="fIn2" name="fIn2" autocomplete="off" onkeydown="return false" readonly required>
                        <input type="text" class="offset-1 col-5" id="datepicker2" name="fFin2" onchange="fecha2()"autocomplete="off" onkeydown="return false" required>
                    </div>
                   
                    <div class="form-group row justify-content-center">
                        <label for="fIn3" class="col-6" >Inicio temporada Baja</label>
                        <label for="fFin3" class="col-6">Final temporada Baja</label>
                        
                        <input type="text" class="col-5" id="fIn3" name="fIn3" autocomplete="off" onkeydown="return false" readonly required>
                         <input type="text" class="offset-1 col-5" id="fFin3" name="fFin3" value="31/12/'.$anio.'" autocomplete="off" onkeydown="return false" readonly required>
                    </div>
                 
                    
                    <input type="submit" class="btn btn-primary" id="enviar" name="enviar" value="Anadir temporadas"><br>
                </form>
                
            ';
                ?>

            </div>

    </article>
</main>
</body>
</html>
<script>
/**
*Validaciones para los campos de las fechas
 */
    anio=document.getElementById("anio").value;
    $( function() {
        $( "#datepicker" ).datepicker({
            minDate: new Date(+anio, 1 - 1, 2),
            maxDate: new Date(+anio, 12 -1, 31),
            dateFormat:'dd/mm/yy',
        });

    } );

    function fecha(){
        fIn1=document.getElementById("fIn1").value;
        fIn1=new Date(fIn1);

        fecha=document.getElementById("datepicker").value;
        var partesfecha = fecha.split("/");
        fecha=new Date(+partesfecha[2], partesfecha[1] - 1, +partesfecha[0]);
        fecha.setDate(fecha.getDate()+1);
        fecha=fecha.toLocaleDateString('en-GB');

        document.getElementById("fIn2").value = fecha;

        fecha=new Date(+partesfecha[2], partesfecha[1] - 1, +partesfecha[0]);

        $( function() {
            $( "#datepicker2" ).datepicker({
                minDate: new Date (fecha.setDate(fecha.getDate()+2)),
                maxDate: new Date(+anio, 12 -1, 31),
                dateFormat:'dd/mm/yy',

            });

        } );

    }

    function fecha2(){
        fecha=document.getElementById("datepicker2").value;
        var partesfecha = fecha.split("/");
        fecha=new Date(+partesfecha[2], partesfecha[1] - 1, +partesfecha[0]);
        fecha.setDate(fecha.getDate()+1);
        fecha=fecha.toLocaleDateString('en-GB');

        document.getElementById("fIn3").value = fecha;
    }

    
</script>
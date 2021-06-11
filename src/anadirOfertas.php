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
    <title>Reservas</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
            integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
            integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
<?php
require 'procesosApp.php';
    $objProcesos=new procesosApp();

    require_once 'metodos.php';
    $objConexion=new metodos();

/**
 * Extraer todos los tipos para incluirlos en el SELECT
 */
    $consulta = 'SELECT * FROM tipo';

    $objConexion->realizarConsultas($consulta);
?>
<main class="row" id="contenedor">
    <article class="row">
        <div class="col-12">

                <?php
/** $Formulario para añadir ofertas
 */

                $consulta = 'SELECT * FROM tipo';

                $objConexion->realizarConsultas($consulta);
                if($objConexion->comprobarSelect()>0) {
                    echo'<form onsubmit="return validarOfertas()" method="post" action="'.$objProcesos->anadirOfertas().'">';

                    /**
                     * Select de forma dinámica para seleccionar los tipos
                     */
                    echo '
                    <h3>Añadir ofertas</h3>
                    <hr>
                    <div class="form-group">

                    <select class="form-select" name="tipos">';

                    while ($fila = $objConexion->extraerFilas()) {
                        echo '<option value="' . $fila["idTipo"] . '" name="' . $fila["nombre"] . '">' . $fila["nombre"] . '</option>';
                    }
                    echo '

                    </select>
                <div class="form-group row">
                    <label for="fIn" class="col-5">Fecha de inicio</label>
                    <label for="fFin" class="col-5 offset-2">Fecha de fin</label>
          

                    <input type="text" class="col-5" id="datepicker" autocomplete="off" onchange="activar()" onkeydown="return false" name="fIn" required/></br>
                    <input type="text" class="col-5 offset-2" id="datepicker2" autocomplete="off" onkeydown="return false" name="fFin" required/></br>
                </div>
                <div class="form-group row">
                    <label for="porcentaje">Porcentaje de descuento</label>
                    <input type="number" class="form-control" id="porcentaje" name="porcentaje" required min="1" max="99"/></br>
                </div>
                
                    <input type="submit" class="btn btn-primary" name="enviar" value="Enviar"/>

               
            </form>';
                }
                else
                {
                    echo'<script>
                    Swal.fire({
                        title: "Error",
                        text: "No hay tipos añadidos, será usted redirigido a añadir tipos",
                        icon: "error",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                           window.top.location="anadirTipo.php";
                        }
                    });</script>';
                }
                     ?>
        </div>
    </article>
</main>
</body>
</html>
<script>

    /**
     * Datepicker de fecha de inicio
     */
    $( function() {
        $( "#datepicker" ).datepicker({
            minDate: new Date(),
            dateFormat:'dd/mm/yy',
        });

    } );

    /**
     * Datepicker de fecha de fin
     */
    function activar(){
        /**
         * Se activa este datepicker cuando se modifica el de fecha de inicio
         */
        var fecha=document.getElementById("datepicker").value;
        document.getElementById("datepicker2").value="";
        var partesfecha = fecha.split("/");
        fecha=new Date(+partesfecha[2], partesfecha[1] - 1, +partesfecha[0]);

        $('#datepicker2').datepicker('destroy');

        $( function() {
            $( "#datepicker2" ).datepicker({
                minDate: new Date (fecha),
                dateFormat:'dd/mm/yy',
            });

        } );
    }

    /**
     * Función de validación de ofertas antes de enviar el formulario
     */
    function validarOfertas(){
        var tipo=document.getElementsByName("tipos")[0].value;
        var fIn=document.getElementById("datepicker").value;
        var fFin=document.getElementById("datepicker2").value;

        var val=0;
        $.ajax({
            url: "comprobarOfertas.php?tipo="+tipo+"&fIn="+fIn+"&fFin="+fFin,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {

                if(respuesta==1){
                    val=1;
                }
                else
                {
                    /**
                     * Mensaje de error
                     */
                    Swal.fire({
                        title: "Error",
                        text: "Ya hay una oferta para este tipo en la fecha indicada",
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

            return true;
        }
        else{
            return false;
        }

    }
</script>

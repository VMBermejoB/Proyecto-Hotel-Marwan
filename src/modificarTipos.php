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

    if(!isset($_GET["idTipo"]) || empty($_GET["idTipo"])){
        header("Location:index.php");
    }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tipos</title>
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
<div class="containter" >
    <main class="row" id="contenedor">

        <article class="row">
            <div class="col-12">
<?php
require_once  'metodos.php';
$objMetodos=new metodos();

    /**
     * Extrae el tipo de la tabla tipos según el tipo seleccionado para modificar
     */
$consulta=
    "
            SELECT * FROM tipo
            WHERE idTipo= ".$_GET["idTipo"]."
    ";
$objMetodos->realizarConsultas($consulta);
    /**
     * Comprueba si ha encontrado algún resultado para mostrar el formulario
     */
if ($objMetodos->comprobarSelect()>0)
{
    $fila=$objMetodos->extraerFilas();

       echo '              
                <form onsubmit="return validacion()" action="#" method="post">
                <h2>Modificar tipo de habitación</h2>
                <hr>
                                 
                     <label for="nombreBD" class="sr-only"></label>
                     <input type="hidden" id="nombreBD" class="form-control" name="nombreBD" placeholder="nombre" value="'.$fila["nombre"].'" required/>          
                <div class="form-group">
                     <label for="nombre">Tipo de habitación</label>
                     <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Tipo  de habitacion" value="'.$fila["nombre"].'" maxlength="30" required/></br>
                </div>
                <div class="form-group">
                     <label for="descripcion">Descripcion</label>
                     <input type="text" class="form-control" name="descripcion" placeholder="Descripcion" value="'.$fila["descripcion"].'" maxlength="300" required/></br>
                </div>
                <input type="hidden" class="form-control" name="idTipo"  value="'.$_GET["idTipo"].'" required/>
                     <input type="submit" class="btn btn-primary" name="enviar" value="Enviar"/>
       </form>

            ';

       if(isset($_POST["enviar"])){
           if(!isset($_POST["nombre"]) || empty($_POST["nombre"]) || !isset($_POST["descripcion"]) || empty($_POST["descripcion"])){
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
                * Realiza el update para modificar los datos del tipo seleccionado
                */
               $consulta=
                   "
                    UPDATE tipo 
                    SET nombre='".$_POST["nombre"]."',descripcion='".$_POST["descripcion"]."'
                    WHERE idTipo=".$_POST["idTipo"].";
               ";

               $objMetodos->realizarConsultas($consulta);

               if($objMetodos->comprobar()<0){
                   echo'<script>
                         Swal.fire({
                            title:"Error",
                            icon:"error",
                            text:"Error al modificar, inténtelo de nuevo más tarde",
                            confirmButtonColor: "#011d40",
                             confirmButtonText:"Aceptar",
                             allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        })
                    </script>';
               }
               else
               {
                   echo'<script>
                         Swal.fire({
                            title:"Éxito",
                            icon:"success",
                            text:"Tipo modificado correctamente",
                            confirmButtonColor: "#011d40",
                             confirmButtonText:"Aceptar",
                             allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.top.location="mostrarTipo.php";
                            }
                        });
                    </script>
                ';
               }
           }
       }

}
?>
            </div>
        </article>
    </main>
</div>
<script>
    /**
    * Valida los campos del formulario
    */
    function validacion()
    {

        var nombre = document.getElementById("nombre").value;
        var nombreBD = document.getElementById("nombreBD").value;
        /**
        * Comprueba si el nombre inroducido en el formulario coincide con alguno de la base de datos
        */

        if(nombre==nombreBD)
        {
            window.location="mostrarTipo.php";
            return true
        }
        else
        {
            var val=0;
            $.ajax({
                url: "comprobarTipo.php?nombre="+nombre,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {

                    if (respuesta == 1) {
                        val = 1;

                            Swal.fire({
                                title:"Error",
                                icon:"error",
                                text:"El tipo de habitación ya existe",
                                confirmButtonColor: "#011d40",
                                confirmButtonText:"Aceptar",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                stopKeydownPropagation:false,
                            })

                    }
                }
                });

            if(val===1){
                return false;
            }
            else
            {
                return true
            }
        }
    }
</script>
</body>
</html>
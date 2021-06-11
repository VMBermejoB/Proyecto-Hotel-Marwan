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
    <title>Recuperar contraseña</title>
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

<?php
require_once  'metodos.php';
$objMetodos=new metodos();

    echo '
        <div class="containter" >
        <main class="row" id="contenedor">
            <article class="row">
                <div class="col-12">
                <form  onsubmit="return validacion()" method="post" action="#" enctype="multipart/form-data">
                    <h2>Añadir Tipo de Habitación</h2>
                    <hr>
                    <div class="form-group">
                        <label for="nombre">Introduce el tipo de habitación</label><br>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Introduce el tipo de habitacion" maxlength="30" required/>
                        <label for="descripcion">Introduce la descripción del tipo de habitación</label><br>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Introduce la descripcion del tipo de habitacion" maxlength="300" required/>
                        <div class="form-group">
                            <input type="file" class="form-control" id="archivo[]" name="archivo[]" multiple="" accept="image/png,image/jpeg" required><br>
                        </div>
                    </div>
                     <input type="submit" class="btn btn-primary" name="enviar" value="enviar"/>
                </form>
            </div>
           
            </article>
            </main>
        </div>
     ';
if(isset($_POST["enviar"])) {

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
         * Recogemos la variables del formulario $_POST["nombre"] y $_POST["descripcion"];
         */

        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];

        /**
         * Comprobamos que los archivos seleccionados son de formato imagen
         */

        $validar = 0;

        $extensiones = array('jpg', 'png');
        foreach ($_FILES["archivo"]['tmp_name'] as $archivos => $tmp_name) {

            $fileNameCmps = explode(".", $_FILES["archivo"]["name"][$archivos]);
            $extension = strtolower(end($fileNameCmps));

            if ($validar == 0) {
                if (in_array($extension, $extensiones)) {
                    $validar = 0;
                } else {
                    $validar = 1;
                }
            }

        }

        /**
         * Si los archivos subidos no son imagenes, muestra mensaje de error y no permite continuar con el proceso
         */
        if ($validar == 1) {
            echo '<script>
                              Swal.fire({
                             title: "Error",
                            icon:"error",
                            text:"Solo se permite formato imagen",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#011d40",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                            })
                     
                               </script>';
        } else {
            /**
             * Ejecutamos consulta preparada
             */

            $sentencia = $objMetodos->mysqli->prepare("INSERT INTO tipo(nombre, descripcion) VALUES (?,?)");
            $sentencia->bind_param("ss", $nombre, $descripcion);
            $resultado = $sentencia->execute();
            $id = $sentencia->insert_id;
            echo $id;

            $validar = 0;

            foreach ($_FILES["archivo"]['tmp_name'] as $archivos => $tmp_name) {

                if ($validar == 0) {


                    if ($_FILES["archivo"]["name"][$archivos]) {
                        $nombrearchivo = $_FILES["archivo"]["name"][$archivos];
                        $path = "archivos/" . $nombrearchivo;

                        $extension = pathinfo($nombrearchivo, PATHINFO_EXTENSION);



                        copy($_FILES['archivo']['tmp_name'][$archivos], $path);
                        if (file_exists($path)) {

                            $sentencia = $objMetodos->mysqli->prepare(" INSERT INTO imagenes (nombre, idTipo) VALUES (?,?)");
                            $sentencia->bind_param("si", $path, $id);
                            $sentencia->execute();
//                            $idImagen = $sentencia->insert_id;
//                            $sentencia = $objMetodos->mysqli->prepare("INSERT INTO imagenestipos (idTipo, idImagen) VALUES (?,?)");
//                            $sentencia->bind_param("ii", $id, $idImagen);
//                            $sentencia->execute();

                            if ($objMetodos->comprobar() <= 0) {
                                $validar = 1;
                                echo '<script>
                              Swal.fire({
                             title: "Error",
                            icon:"error",
                            text:"Error al subir los archivos",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#011d40",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        });
                               </script>';
                            }
                        } else {
                            echo '<script>
                                Swal.fire({
                             title: "Error",
                            icon:"error",
                            text:"Error al subir los archivos",
                            confirmButtonColor: "#011d40",
                            confirmButtonText: "Aceptar",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        });
                </script>';
                            $validar = 1;
                        }

                    }
                }
            }
            /**
             * Comprobamos si hay temporadas al crear los tipos
             */
            $consulta =
                "
            SELECT *
            FROM temporada;
        ";

            $objMetodos->realizarConsultas($consulta);

            if ($objMetodos->comprobarSelect() > 0) {
                $prueba = $objMetodos->comprobarSelect();
                for ($i = 0; $i < $prueba; $i++) {
                    $fila[$i] = $objMetodos->extraerFilas();
                }
                $sentencia = $objMetodos->mysqli->prepare("INSERT INTO temporadaTipo(idTipo, idTemporada) VALUES (?,?)");
                for ($i = 0; $i < $prueba; $i++) {
                    $sentencia->bind_param("ss", $id, $fila[$i]["idTemporada"]);
                    $resultado = $sentencia->execute();
                }
                echo
                '
            <script>
                Swal.fire({
            title:"Éxito",
            icon: "success",
            text:"Se ha añadido el tipo con extio, Usted será redigido a la asignación de los precios, para asignar el precio a el nuevo tipo creado",
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
            } else {
                echo
                '
            <script>
             Swal.fire({
             title:"Éxito",
            icon: "success",
          confirmButtonText: "Aceptar",
          confirmButtonColor: "#011d40",
            text:"El Tipo de habitación se ha añadido correctamente, pero no hay temporadas añadidas, usted será redigido a la creación de temporadas",
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            stopKeydownPropagation:false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.top.location="gestionTemporadas.php";
            }
        })
            </script>
        ';
            }
        }
    }


}


?>


</body>
</html>
<script>
    /**
    *Comprueba si el nombre que se le quiere poner al nuevo tipo ya existe en la base de datos
     */
    function validacion()
    {
        let nombre = document.getElementById("nombre").value;
        var val=0;
        $.ajax({
            url: "comprobarTipo.php?nombre="+nombre,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {
                if (respuesta == 1) {
                    val=1;
                    Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"El tipo de habitación ya existe, inserte otro distinto",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location="anadirTipo.php";
                        }
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
<?php
/**
 * Comprobación de perfiles
 */
    session_start();

    if(isset($_SESSION["perfil"])){
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
        <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#donde">Donde estamos</a></div>
        <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#serv">Servicios</a></div>
        <div class="col-12 col-sm-1 d-flex align-items-center"><a href="habitaciones.php">Habitaciones</a></div>
        <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#contacto">Contactenos</a></div>
        <div class="col-12 col-sm-1 d-flex align-items-center"><a href="iniciosesion.php">Inicio Sesión</a></div>
        <div id="logo" class="col-auto offset-auto d-none d-sm-block">
            <img src="imagenes/logo2.PNG" alt="logo">
        </div>
        </nav>
    <?php
    require_once  'metodos.php';
    require_once 'procesosApp.php';
    $objMetodos=new metodos();
    $objProcesos=new procesosApp();
    /**
     * Muestra el primer formulario
     */
    if(!isset($_POST["enviar"]) and !isset($_POST["enviar2"])){
        echo '
        <main class="row" id="contenedor">
            <article class="row">
                <div class="col-12">
                    <form onsubmit="return validacion()" method="post" >
                        <h2>Recuperación de Contraseña</h2>
                        <hr>
                        <div class="form-group">
                            <label for="correo">Introduce correo</label><br>
                            <input type="email" class="form-control" name="correo" id="correo" placeholder="Introduce correo" required/>
                        </div>
                         <input type="submit" class="btn btn-primary" name="enviar" value="enviar"/>
                    </form>
                </div>
            </article> 
        </main>
     ';
    }
    else
    {
        /**
         * Si se ha enviado el primer formulario, extrae la pregunta secreta y muestra el segundo formulario
         */
        $correo=$_POST["correo"];
            $sentencia=$objMetodos->mysqli->prepare(
                    " SELECT correo,pregunta
                            FROM usuarios
                            WHERE correo=?;"
            );
            $sentencia->bind_param("s",$correo);
            $sentencia->execute();
            $resultado=$sentencia->get_result();
            if ($fila = $resultado->fetch_array()) {
             if(isset($_POST["enviar"]) and !isset($_POST["enviar2"]))
            {
                /**
                 * Segundo formulario en el que se comprueba la respuesta de la pregunta
                 */
                echo
                '
                <main class="row" id="contenedor2">
                    <article class="row">
                        <div class="col-12">
                           <form onsubmit="return comprobarPregunta()" action="recuperar2.php" method="post">
                               <h2>Recuperación de Contraseña</h2>
                                <hr>
                               <div class="form-group">
                               <h4>Responda a la siguiente pregunta</h4>
                                   <label for="correo" class="sr-only"></label>
                                   <input type="hidden" id="correo" name="correo" value="'.$fila["correo"].'" required/></br>
                               </div>
                               <div class="form-group">
                                    <label for="respuestaUsuario">'.$fila["pregunta"].'</label>
                                    <input type="text" id="respuestaUsuario" class="form-control" name="respuestaUsuario" placeholder="Responda a la pregunta secreta" required/></br>
                               </div>
                                <input type="submit" class="btn btn-primary" name="enviar2" value="enviar"/>
                           </form>
                        </div>
                    </article>
                </main>
                ';
            }
        }
    }
    ?>
</body>
</html>
<script>
    /**
    *Comprobación del campo correo del primer formulario
     */
    function validacion()
    {
        let correo = document.getElementById("correo").value;
        var val=0;
        $.ajax({
            url: "comprobarCorreo.php?correo="+correo,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {
                if (respuesta == 1) {
                    val=1;
                }
                else
                {
                    Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"El correo introducido no existe, o es erroneo",
                        confirmButtonColor: "#011d40",
                        confirmButtonText:"Aceptar",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.top.location="recuperar.php";
                        }
                    })
                    return false;
                }
            }
        });

        if(val==1){
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
    *Comprueba si la respuesta que escribe el usuario es correcta
     */
    function comprobarPregunta()
    {
        let correo = document.getElementById("correo").value;
        let respuestaUsuario= document.getElementById("respuestaUsuario").value;

        var val=0;

        $.ajax({
            url: "comprobarPregunta.php?correo="+correo+"&respuestaUsuario="+respuestaUsuario,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {

                if (respuesta == 1) {
                    val=1;
                }
                else
                {
                    Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"La respuesta es incorrecta",
                        confirmButtonColor: "#011d40",
                        confirmButtonText:"Aceptar",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    })
                    return false;
                }
            }
        });

        if(val==1){
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
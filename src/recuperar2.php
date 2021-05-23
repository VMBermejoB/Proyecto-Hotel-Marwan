
//    if (($_SERVER['HTTP_REFERER'] != "http://localhost/ejercicios/disenioProyecto2/proyecto/reservas.php")){
//        header("Location:reservas.php");
//    }
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
</head>
<body>

<nav class="row">
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Quienes Somos</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Noticias</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Habitaciones</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#"> Actividades</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="iniciosesion.php">Inicio Sesión</a></div>
    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
        <img src="imagenes/logo2.PNG">
    </div>
</nav>
<?php
    require_once  'metodos.php';
    $objMetodos=new metodos();

    /**
     * Consulta para extraer la respuesta del usuario
     */

    $correo=$_POST["correo"];
    $sentencia=$objMetodos->mysqli->prepare(
    " SELECT respuesta
            FROM usuarios
            WHERE correo=?;"
    );
    $sentencia->bind_param("s",$correo);
    $sentencia->execute();
    $resultado=$sentencia->get_result();
    if ($fila = $resultado->fetch_array()) {
        /**
         * Comprueba la respuesta para mostrar el formulario de cambio de contraseña
         */
        if ($_POST["respuestaUsuario"] == $fila["respuesta"])
        {
            if(!isset($_POST["enviar"])) {
                echo
                '
                    <div class="container">
                       <form action="#" method="post" onsubmit="return comprobarPassword()">
                       <h2>Cambio de Contraseña</h2>
                       <hr>
                       <div class="form-group">
                           <label for="correo" class="sr-only"></label>
                           <input type="hidden" class="form-control" name="correo" value="'.$_POST["correo"].'"/></br>
                       </div>
                       <div class="form-group">
                            <label for="respuestaUsuario" id="respuestaUsuario" class="sr-only"></label>
                            <input type="hidden"  class="form-control" name="respuestaUsuario" value="'.$_POST["respuestaUsuario"].'"/></br>
                       </div>
                       <div class="form-group">
                            <label for="password">Introduce una nueva contraseña</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Introduce una nueva contraseña" required/></br>
                        </div>
                        <div class="form-group">
                            <label for="password2">Repite la nueva contraseña</label><br>
                            <input type="password" id="password2" class="form-control" name="password2" placeholder="Repite la nueva contraseña" required/></br>
                        </div>
                        <input type="submit" class="btn btn-primary" name="enviar" value="enviar"/>
                    </form>
                  </div>
                    ';
            }
            else
            {

                if($_POST["password"]== $_POST["password2"])
                {
                    $encriptar=$objMetodos->encriptar($_POST["password"]);
                    $consulta=
                        "
                            UPDATE usuarios
                            SET password='".$encriptar."'
                             WHERE  correo='".$_POST["correo"]."'
                        ";
                    $objMetodos->realizarConsultas($consulta);

                    if($objMetodos->comprobar()>=0){
                        echo'<script>window.location="iniciosesion.php";</script>';
                    }
                }
            }
        }
    }
?>
<script>
    /**
     * Comprueba si las dos contraseñas son iguales para realizar el cambio de contraseña
     */
    function comprobarPassword()
    {
        let password = document.getElementById("password").value;
        let password2= document.getElementById("password2").value;
        if(password==password2)
        {
            return true
        }
        else
        {
            alert("Las contraseñas no coinciden")
            return false
        }
    }
</script>
</body>
</html>
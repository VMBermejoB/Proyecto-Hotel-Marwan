<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
    <nav class="row">
        <div class="col-1 d-flex align-items-center"><a href="#">Quienes Somos</a></div>
        <div class="col-1 d-flex align-items-center"><a href="#">Noticias</a></div>
        <div class="col-1 d-flex align-items-center"><a href="#">Habitaciones</a></div>
        <div class="col-1 d-flex align-items-center"><a href="#"> Actividades</a></div>
        <div class="col-1 d-flex align-items-center"><a href="iniciosesion.php">Inicio Sesión</a></div>
        <div id="logo" class="col-auto offset-auto">
            <img src="imagenes/logo2.PNG">
        </div>
        </nav>
    <?php
    require_once  'metodos.php';
    require_once 'procesosApp.php';
    $objMetodos=new metodos();
    $objProcesos=new procesosApp();
    /*
     * Muestra el primer formulario
     */
    if(!isset($_POST["enviar"]) and !isset($_POST["enviar2"])){
        echo '
        
        <div class="container">
            <div class="row">
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
            </div> 
        </div>
     ';
    }
    else
    {
        /*
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
                /*
                 * Segundo formulario en el que se comprueba la respuesta de la pregunta
                 */
                echo
                '
                   <div class="container">
                       <form onsubmit="return comprobarPregunta()" action="recuperar2.php" method="post">
                           <h2>Recuperación de Contraseña</h2>
                            <hr>
                           <h4>Responda a la siguiente pregunta</h4>
                           <div class="form-group">
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
                ';
            }
        }
    }
    ?>
</body>
</html>
<script>
    /*
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
                    alert("El correo no existe o es erroneo");
                    window.location="recuperar.php";
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
    /*
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
                    alert("La respuesta es incorrecta");
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
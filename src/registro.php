<?php
/**
 * Comprobación de perfiles
 */
    session_start();

    if(isset($_SESSION["perfil"])){
        header("Location:index.php");
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <script src="sweetalert2.all.min.js"></script>
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

<div class="containter" >
    <main class="row" id="contenedor">

        <article class="row justify-content-center">
            <div class="col-8">
                    <?php
                        require 'procesosApp.php';
                        $objProcesos=new procesosApp();
                    /**Formulario de registro*/
                    echo '<form method="post" onsubmit="return validacion()" action="'.$objProcesos->registro().'" class="col-10">';
                    ?>
                        <h1>REGISTRO</h1><br>
                        <div class="form-group">
                            <label for="nombre">Nombre: </label>
                            <input name="nombre" class="form-control" id="nombre" type="text" required/>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo: </label>
                            <input name="correo" class="form-control" id="correo" type="email" required/>
                        </div>
                        <div class="form-group">
                            <label for="pass">Contraseña: </label>
                            <button type="button" class="btn btn-secondary info" data-bs-toggle="tooltip" data-bs-placement="top" title="La contraseña debe tener como mínimo de 8 letras, con al menos un símbolo, letras mayúsculas y minúsculas y un número.">
                                <img src="imagenes/iconos/informacion.png">
                            </button>
                            <input name="pass" class="form-control" id="pass" type="password" required/>
                        </div>
                        <div class="form-group">
                            <label for="pass2">Repetir Contraseña: </label>
                            <input name="pass2" class="form-control" id="pass2" type="password" required/>
                        </div>
                         <div class="form-group">
                            <label for="tlfno">Teléfono: </label>
                            <input name="tlfno" class="form-control" id="tlfno" type="text" required/>
                         </div>
                        <div class="form-group">
                            <label for="pregunta">Pregunta: </label>
                            <input name="pregunta" class="form-control" id="pregunta" type="text" required/>
                        </div>
                        <div class="form-group">
                            <label for="respuesta">Respuesta: </label>
                            <input name="respuesta" class="form-control" id="respuesta" type="text" required/>
                        </div>

                        <br/><br/>

                        <input type="submit" class="btn btn-primary" name="enviar" value="Registrarse"><br>

                    </form>

            </div>

        </article>

    </main>
    <footer class="row">

        <div class="col-12 center-block">
            <div class="logo2"><img src="imagenes/logo3.PNG"></div>
        </div>
        <div class="col-auto" id="pie">

            <h5 class="col-12"><a name="contacto">Contacto</a></h5>

            <div class="col-12">
                <p> via Verona 149, angolo con via Verdi 1 - 25019<br/>
                    Lugana di Sirmione (BS) Lago di Garda Italia<br/>
                    Tel +39 030 919026 - Fax +39 030 9196039<br/>
                    marwan@hotelmarwan.it<br/>
                    P.IVA 04324930231
                </p>
            </div>

        </div>

    </footer>

</div>
</body>
</html>


<script>
    /**
    *Validaciones del formulario de registro
     */
    function validacion(){
        let nombre = document.getElementById("nombre").value;
        let correo = document.getElementById("correo").value;
        let pass = document.getElementById("pass").value;
        let pass2 = document.getElementById("pass2").value;
        let tlfno = document.getElementById("tlfno").value;

        if(/^(?=.*\d)(?=.*[!@#$\-\_%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(pass)==false){


            Swal.fire({
                title:"Error",
                icon:"error",
                confirmButtonColor: "#011d40",
                confirmButtonText:"Aceptar",
                text:"La contraseña debe tener como mínimo de 8 letras, con al menos un símbolo, letras mayúsculas y minúsculas y un número.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
            });


            return false;
        }

        /**
        *Validación correo correcto
         */
        if(/^[67]\d{8}$/.test(tlfno)===false)
        {

            Swal.fire({
                title:"Error",
                icon:"error",
                confirmButtonText:"Aceptar",
                confirmButtonColor: "#011d40",
                text:"Introduce el teléfono correctamente",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,

            });

            return false;
        }
        /**
        *Validación para ver si las contraseñas son iguales
         */
        if(pass!==pass2){

            Swal.fire({
                title:"Error",
                icon:"error",
                confirmButtonText:"Aceptar",
                confirmButtonColor: "#011d40",
                text:"Las contraseñas no coinciden",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
            });


            return false;
        }

        /**
        *Comprobación de correo para ver si está repetido
         */

        var val=0;
        $.ajax({
            url: "comprobarCorreo.php?correo="+correo,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {
                if(respuesta==1){

                    Swal.fire({
                        title:"Error",
                        icon:"error",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        text:"El usuario ya existe",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    return false;
                }
                else
                {
                    val=1;
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

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
<?php
session_start();
require_once 'metodos.php';
$objMetodos =new metodos();

    echo
    '
        <main class="row" id="contenedor">

        <article class="row justify-content-center">
            <div class="col-8">                    
                <form method="post" onsubmit="return validacion()" class="col-10">
                        <h1>REGISTRO</h1><br>
                        <hr>
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
                            <input name="password" class="form-control" id="pass" type="password" required/>
                        </div>
                        <div class="form-group">
                            <label for="pass2">Repetir Contraseña: </label>
                            <input name="password2" class="form-control" id="pass2" type="password" required/>
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
    ';
if(isset($_POST["enviar"]))
{
    if($_POST["password"]== $_POST["password2"] and
        (!empty($_POST["nombre"] and $_POST["password"] and $_POST["password2"] and $_POST["correo"] and $_POST["tlfno"] and $_POST["pregunta"] and $_POST["respuesta"])))
    {
        $encritar=$objMetodos->encriptar($_POST["password"]);

        $consulta =
            "
            INSERT INTO usuarios (nombre,correo,password,tlfno,perfil,pregunta,respuesta)
            VALUES ('" . $_POST["nombre"] . "','" . $_POST["correo"] . "','" . $encritar . "','" . $_POST["tlfno"] . "','t','" . $_POST["pregunta"] . "','" . $_POST["respuesta"] . "')
        ";
        $objMetodos->realizarConsultas($consulta);
        if($objMetodos->comprobar()>0)
        {
            echo
            '
                <script>
                Swal.fire({
                title:"Éxito",
                icon: "success",
                text:"Se ha añadido el trabajador con extio",
                confirmButtonColor: "#011d40",
                confirmButtonText:"Aceptar",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.top.location="iniciosesion.php";
                }
            })
                </script>
                ';
        }
        else
        {
            echo
            '
            <script>
                Swal.fire({
                title:"Error",
                icon:"error",
                confirmButtonText:"Aceptar",
                confirmButtonColor: "#011d40",
                text:"El Trabajador no fue añadido",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
                });
            </script>
        ';
        }
    }
    else
    {
        echo
        '
            <script>
                Swal.fire({
                title:"Error",
                icon:"error",
                confirmButtonText:"Aceptar",
                text:"Por favor rellene todos los campos",
                confirmButtonColor: "#011d40",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
                });
            </script>
        ';
    }

}
?>
<script>
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
        confirmButtonText:"Aceptar",
        text:"La contraseña debe tener como mínimo de 8 letras, con al menos un símbolo, letras mayúsculas y minúsculas y un número.",
        confirmButtonColor: "#011d40",
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

</body>
</html>
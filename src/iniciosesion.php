<?php
/**
 * Comprobación de perfiles
 */
session_start();

    if(isset($_SESSION["perfil"]))
    {
        if($_SESSION["perfil"]=="u"){
            header("Location:index.php");
        }
    }

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio sesión</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Inicio de Sesion</title>
</head>
<body onload="comprobarCookie()">
<?php

if(!isset($_SESSION["perfil"])){
            /**
             * Comprueba si se ha iniciado sesión
             */
            echo '
        
        
        <nav class="row">
            <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#donde">Donde estamos</a></div>
            <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#serv">Servicios</a></div>
            <div class="col-12 col-sm-1 d-flex align-items-center"><a href="habitaciones.php">Habitaciones</a></div>
            <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#contacto">Contactenos</a></div>
            <div class="col-12 col-sm-1 d-flex align-items-center"><a href="iniciosesion.php">Inicio Sesión</a></div>
            <div id="logo" class="col-auto offset-auto d-none d-sm-block">
                <img src="imagenes/logo2.PNG">
            </div>
        </nav>';
        }


    if (!isset($_POST["enviar"]) && !isset($_SESSION["perfil"])){/*pregunto si se ha mandado el formulario o si existe la $session*/
        echo '   
   <main class="row" id="contenedor">
    <article class="row">
        <div class="col-12">           
                <form action="iniciosesion.php" onsubmit="return compCorreo()" method="post">
                <h2>Inicio de Sesion</h2>
                <hr>
                    <div class="form-group">
                         <label for="correo">Introduce correo</label>
                         <input type="email" class="form-control" id="correo" name="correo" placeholder="Introduce correo" required/></br>
                    </div>
                    <div class="form-group">
                         <label for="pw">Introduce contraseña</label>
                         <input type="password" class="form-control" id="pass" name="pw" placeholder="Introduce contraseña" required/></br>
                    </div>
                     <h6><a href="recuperar.php">¿Has olvidado la contraseña?</a></h6>
                     <h6>¿Aún no está registrado? <button type="button" class="btn btn-primary" value="Registrese aqui"><a href="registro.php" >Registrese aqui</a></button></h6>
                     <input type="submit" class="btn btn-primary" name="enviar" value="Iniciar Sesion"/>
                </form>
        </div>
            </article>

    </main>';
    }else{
        /**
     * Si se ha iniciado sesión se comprueba si el usuario es de tipo trabajador o usuario normal
     */
        if(isset($_SESSION['perfil'])){/*si existe la variable perfil de sesión según el perfil muestra unas u otras opciones por si accede a esta página por url o enlace de volver*/
            switch ($_SESSION['perfil']) {
                case 't':
                    echo '
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
                                <div class="col-12 justify-content-center bienvenida"> 
                                    <div id="logoinicio">
                                        <img src="imagenes/logo3.PNG">
                                    </div>
                                        
                                     <h1>Bienvenido a la página de gestión</h1>                                
                                </div>
                            </article>
                        </main>
                         ';

                    break;
                case 'u':
                    header('Location: index.php');
                    break;
            }
        }else{
                require 'procesosApp.php';
                $objProcesos=new procesosApp();
                if ($objProcesos->iniciosesion($_POST["correo"], $_POST["pw"])){
                    switch ($_SESSION['perfil']) {
                        case 't':
                            echo '
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
                                <div class="col-12" id="logoinicio"> 
                                    <img src="imagenes/logo3.PNG">
                                    <h1>Bienvenido a la página de gestión</h1>                                
                                </div>
                            </article>
                        </main>';

                            break;
                        case 'u':
                                header('Location: index.php');
                            break;

                    }
                }else{
                    echo 'Correo o contraseña incorrectos <a href="iniciosesion.php">Volver</a>';
                }
            }
    }

?>
<article class="row">
    <div class="col-12">
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
            <!--Cuadro de cookies-->
            <div class="modal fade" id="cookieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="notice d-flex justify-content-between align-items-center">
                                <div class="cookie-text col-12">Para poder iniciar sesión o registrarse acepte nuestras cookies. Más información <a href="Legalidad.html">aquí</a></div>

                            </div>
                            <div class="buttons row justify-content-center">
                                <a href="#" class="btn btn-success btn-sm col-3" onclick="crearCookie()" data-dismiss="modal">Aceptar</a>
                                <a href="#" class="btn btn-secondary btn-sm col-3 offset-2" onclick="rechazarCookie()" data-dismiss="modal">Rechazar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</body>
</html>
<script>
    /**
     * Comprobaciones de cookies
     */
    function comprobarCookie() {
        var cookie = document.cookie.replace(/(?:(?:^|.*;\s*)aceptada\s*\=\s*([^;]*).*$)|^.*$/, "$1");

        if (cookie != "") {

            $(document).ready(function() {
                $('#cookieModal').modal('hide');
            });


        } else {
            $(document).ready(function() {
                $('#cookieModal').modal({ backdrop: 'static', keyboard: false });
                $('#cookieModal').modal('show');
            });

        }
    }

    function crearCookie(){

        document.cookie = "aceptada=1; max-age=3153600000; path=/";

        $(document).ready(function() {
            $('#cookieModal').modal('hide');
        });
    }

    function rechazarCookie() {

        $(document).ready(function () {
            $('#cookieModal').modal('hide');
            window.top.location="index.php";
        });



    }

    /**
     *
     * @returns {boolean}
     */
    function compCorreo(){
        var val=0;
        let correo=document.getElementById("correo").value;
        let pass=document.getElementById("pass").value;

        $.ajax({
            url: "comprobarCorreo.php?correo="+correo,
            type: "get",
            dataType: "text",
            async: false,

            success: function(respuesta) {
                if(respuesta==0){

                    Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Usuario o contraseña incorrectos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                        if (result.isConfirmed) {

                        }
                    });
                }
                else
                {
                    val=1;
                }
            }
        });

        if(val==1){
            $.ajax({
                url: "comprobarPass2.php?correo="+correo+"&pass="+pass,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if(respuesta==0){

                        Swal.fire({
                            title: "Error",
                            icon:"error",
                            text:"Usuario o contraseña incorrectos",
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
                        val=0;
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

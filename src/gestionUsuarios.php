<?php
/**
 * Comprobación de perfiles
 */
    session_start();

    if(!isset($_SESSION["perfil"])){
        header("Location:index.php");
    }

    if($_SESSION["perfil"]!="u"){
        header("Location:index.php");
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <title>Usuario</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

</head>
<body>
<nav class="row">
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php/#donde">Donde estamos</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php/#serv">Servicios</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="habitaciones.php">Habitaciones</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="reservas.php">Reservas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="gestionUsuarios.php">Usuario</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
        <img src="imagenes/logo2.PNG" alt="logo">
    </div>
</nav>

<div class="containter" >
    <main class="row" id="contenedor">

        <article class="row">
            <div class="col-12">
                <?php
                    require 'procesosApp.php';
                    $objProcesos=new procesosApp();

                    require_once 'metodos.php';
                    $objConexion=new metodos();

                    echo '<form method="post" onsubmit="return validacion()" action="'.$objProcesos->modificarUsuario().'">';
            /**
             * Consulta para extraer los datos del usuario que se mostrarán por defecto en el formulario de modificación de datos de usuario
             */
                    $consulta="SELECT nombre, correo, tlfno FROM usuarios WHERE idUsuario=".$_SESSION["id"];
                    $objConexion->realizarConsultas($consulta);
                    $filas=$objConexion->extraerFilas();
                /**
                 * Formulario de modificación de datos del usuario
                 */

                echo '<h1>Modificar datos</h1><br>
                <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input name ="nombre" id="nombre" class="form-control" type="text" value="'.$filas["nombre"].'" required/>
                </div>
                <div class="form-group">
                    <label for="correo">Correo: </label>
                    <input name ="correo" id="correo" class="form-control" type="email" value="'.$filas["correo"].' " required/>
                </div>
                
                <input type="hidden" name="correo2" id="correo2" value="'.$filas["correo"].'" /></br>
                <div class="form-group">
                    <label for="tlfno">Teléfono: </label>
                    <input name ="tlfno" id="tlfno" class="form-control" type="text" value="'.$filas["tlfno"].'" required/>
                </div>
               
                <br/><br/>

                <input type="submit" class="btn btn-primary" name="enviar" value="Aceptar"><br>

                </form>';
                ?>
            </div>

            <div class="col-12">

                <?php
                /**
               * Formulario para la modificación de contraseñas
               */
                     echo '<form method="post" onsubmit="return validarPass()" action="'.$objProcesos->modificarPass().'">';
                 ?>
                    <h1>Modificación de contraseña</h1>
                    <div class="form-group">
                        <label for="pass1">Introduzca contraseña </label>
                        <input name ="pass1" class="form-control" id="pass1" type="password" required/>
                    </div>
                    <div class="form-group">
                        <label for="pass2">Introduzca nueva contraseña </label>
                        <input name ="pass2" class="form-control" id="pass2" type="password" required/>
                    </div>
                    <div class="form-group">
                        <label for="pass3">Confirme contraseña </label>
                        <input name ="pass3" class="form-control" id="pass3" type="password" required/>
                    </div>

                    <input type="submit" class="btn btn-primary" name="enviar1" value="Cambiar clave"><br>
                </form>
            </div>
            <div class="col-12">
                <?php
                /**
                 * Formulario para la baja de usuario
                 */
                echo '<form method="post" id="baja" onsubmit="return validarPass2()" action="'.$objProcesos->bajaUsuario().'">';
                ?>
                <h1>Eliminar cuenta</h1>
                <div class="form-group">
                    <label for="pass4">Introduzca contraseña para eliminar la cuenta</label>
                    <input name ="pass4" class="form-control" id="pass4" type="password" required/>
                </div>
                <input type="submit" class="btn btn-primary" name="enviar2" id="enviar2" value="Dar de baja"><br>
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
                    dogana@hoteldogana.it<br/>
                    P.IVA 04324930231
                </p>
            </div>

        </div>
    </footer>
</div>

</body>
</html>

<!--Validaciones de los campos del formulario-->
<script>
    /**
     * Validaciones para el formulario de modificación de datos
     */
    function validacion(){

        let correoAct = document.getElementById("correo2").value;
        let tlfno=document.getElementById("tlfno").value;
        let correo=document.getElementById("correo").value;

        if(/^[67]\d{8}$/.test(tlfno)===false)
        {

            Swal.fire({
                title:"Error",
                icon:"error",
                confirmButtonText:"Aceptar",
                confirmButtonColor: "#011d40",
                text:"Introduce un teléfono válido",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,

            });

            return false;
        }

        if(correoAct===correo){

            return true;
        }
        else
        {
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
                            text:"Correo ya en uso",
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
                return false
            }

        }

    }
    /**
    * Validaciones para la función de cambio de contraseña
    */
    function validarPass(){
        let pass1 = document.getElementById("pass1").value;
        let pass2 = document.getElementById("pass2").value;
        let pass3 = document.getElementById("pass3").value;

        if(/^(?=.*\d)(?=.*[!@#$\-\_%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(pass2)==false){
            Swal.fire({
                title:"Error",
                icon:"error",
                confirmButtonText:"Aceptar",
                confirmButtonColor: "#011d40",
                text:"La contraseña debe tener como mínimo de 8 letras, con al menos un símbolo, letras mayúsculas y minúsculas y un número.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                stopKeydownPropagation:false,
            });
            return false;
        }

        var val=0;

        $.ajax({
            url: "comprobarPass.php?pass1="+pass1,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {

                if(respuesta==0){
                    Swal.fire({
                    title:"Error",
                        icon:"error",
                        text:"Contraseña incorrecta",
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
                    return false;
                }
                else
                {

                    if(pass2===pass3){

                        val=1;
                    }
                    else
                    {
                        Swal.fire({
                            title:"Error",
                            icon:"error",
                            text:"Las contraseñas no coinciden",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#011d40",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        });
                    }
                }
            }
        });

        if(val==1){
            return true;
        }
        else
        {
            return false
        }

    }

    $('#enviar2').on('click',function(e){
        e.preventDefault();
        var form = $(this).parents('#baja');
        Swal.fire({
            icon: "warning",
            text: "¿Deseas dar de baja el usuario?",
            confirmButtonText:"Aceptar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#011d40",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            stopKeydownPropagation:false,
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }
        })
    });

    /**
     * Comprobación de contraseña para eliminar la cuenta
     * @returns {boolean}
     */

    function validarPass2(){
        let pass = document.getElementById("pass4").value;

        var val=0;

        $.ajax({
            url: "comprobarPass.php?pass1="+pass,
            method: "get",
            async: false,
            dataType: "text",
            success: function(respuesta) {

                if(respuesta==0){
                    Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Contraseña incorrecta",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                }
                else
                {
                    val=1;

                }
            }
        });

        if(val==1) {

            return true;
        }
        else
        {
            return false;
        }

    }


</script>


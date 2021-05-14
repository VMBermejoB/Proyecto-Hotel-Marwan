<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
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
    <div class="col-1 d-flex align-items-center"><a href="registro.php"> Registro</a></div>
    <div class="col-1 d-flex align-items-center"><a href="iniciosesion.php">Inicio Sesión</a></div>
    <div id="logo" class="col-auto offset-auto">
        <img src="imagenes/logo2.PNG">
    </div>
</nav>

<div class="containter" >
    <main class="row" id="contenedor">

        <article class="row">
            <div class="col-12">
                    <?php
                        require 'procesosApp.php';
                        $objProcesos=new procesosApp();
                    /*Formulario de registro*/
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
<!--                        <label for="tlfno">Teléfono: </label>-->
<!--                        <input name ="tlfno" id="tlfno" type="text"/>-->
<!--                        <label for="tlfno">Teléfono: </label>-->
<!--                        <input name ="tlfno" id="tlfno" type="text"/>-->
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
                    dogana@hoteldogana.it<br/>
                    P.IVA 04324930231
                </p>
            </div>

        </div>

    </footer>

</div>
</body>
</html>


<script>
    /*
    *Validaciones del formulario de registro
     */
    function validacion(){
        /*
        *Validaciones campos vacíos
         */
        let nombre = document.getElementById("nombre").value;
        if(nombre == null || nombre.length === 0 || /^\s+$/.test(nombre) ) {
            alert("Introduce todos los datos");
            return false;
            
        }

        let correo = document.getElementById("correo").value;
        if(correo == null || correo.length === 0 || /^\s+$/.test(correo) ) {
            alert("Introduce todos los datos");
            return false;
        }

        let pass = document.getElementById("pass").value;
        if(pass == null || pass.length === 0 || /^\s+$/.test(pass) ) {
            alert("Introduce todos los datos");
            return false;
        }

        let pass2 = document.getElementById("pass2").value;
        if(pass2 == null || pass2.length === 0 || /^\s+$/.test(pass2) ) {
            alert("Introduce todos los datos");
            return false;
        }

        let tlfno = document.getElementById("tlfno").value;
        if(tlfno == null || tlfno.length === 0 || /^\s+$/.test(tlfno)){
            alert("Introduce todos los datos");
            return false;
        }
        /*
        *Validación correo correcto
         */
        if(/^[67]\d{8}$/.test(tlfno)===false)
        {
            alert("Introduce el teléfono correctamente");
            return false;
        }
        /*
        *Validación para ver si las contraseñas son iguales
         */
        if(pass!==pass2){
            alert("Las contraseñas no coinciden");
            return false;
        }
        /*
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
                    alert("El usuario ya existe");
                    return false;
                }
                else
                {
                    alert("Registro Completado");
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

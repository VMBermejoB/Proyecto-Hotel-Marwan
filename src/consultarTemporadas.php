<?php
    /*
    * Comprueba que se ha iniciado sesión con perfil trabajador
    */
    session_start();
    if($_SESSION["perfil"]!="t"){
        header("Location:disenio.php");
    }

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Temporadas</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

</head>
<body>
<nav class="row">
    <div class="col-1 d-flex align-items-center"><a href="consultarTemporadas.php">Gestion Temporada</a></div>
    <div class="col-1 d-flex align-items-center"><a href="#">Gestion Tipo De Habitacion</a></div>
    <div class="col-1 d-flex align-items-center"><a href="#">Gestion Habitaciones </a></div>
    <div class="col-1 d-flex align-items-center"><a href="#"> Gestion Ofertas</a></div>
    <div class="col-1 d-flex align-items-center"><a href="#">Gestion Reservas</a></div>
    <div class="col-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto">
        <img src="imagenes/logo2.PNG">
    </div>
</nav>
    <main class="row" id="contenedor">
        <article class="row">
            <div class="row">

        <?php

            require 'procesosApp.php';
            $objProcesos=new procesosApp();

            require_once 'metodos.php';
            $objConexion=new metodos();

            /*
             * Extrae todas las temporadas de la base de datos
             */
            $consulta="SELECT * FROM temporada";
            $objConexion->realizarConsultas($consulta);

            /*
             * Comprueba si se han obtenido resultados para crear las tablas
             */
            if($objConexion->comprobarSelect()>0){

                echo'
                <table class="table table-striped table-hover" >
                    <thead>
                        <tr>
                         
                          <th scope="col">Temporada</th>
                          <th scope="col">Fecha Inicio</th>
                          <th scope="col">Fecha Fin</th>
                          <th scope="col">Año</th>
                          
                        </tr>
                    </thead>
                    ';
                for($i=0;$i<$fila=$objConexion->extraerFilas();$i++){
                    echo'
                    
                      <tr>           
                        <td>'.$fila["nombre"].'</td>
                        <td>'.$fila["fInicioTemp"].'</td>
                        <td>'.$fila["fFinTemp"].'</td>
                        <td>'.$fila["anio"].'</td>
                      </tr>
       ';
                }
                echo '    
           
        </table>
    </div>';
            }
            /*
             * Formulario para añadir o modificar temporadas
             */
        ?>
            <div class="row">
                <div class="col-12">
                    <form method="post" onsubmit="return validarCrear()" action="gestionTemporadas.php">
                        <h3>Gestión de Temporadas</h3>
                        <div class="form-group">
                            <label for="pass1">Introduzca el año </label>
                            <input name ="anio" class="form-control" id="anio" type="text" required/>
                        </div>
                        <input type="submit" class="btn btn-primary" id="submit" onclick="comprobarSubmit(1)" name="crear" value="Crear temporadas"><br>
                        <input type="submit" class="btn btn-primary" id="submit" onclick="comprobarSubmit(2)" name="modificar" value="Modificar temporadas"><br>
                    </form>
                </div>
            </div>
            </div>
        </article>    
    </main>
</body>
</html>

<script>

    /*
    * Comprueba si se ha pulsado
    */
    function comprobarSubmit(boton){
        opcion=boton;
    }
    function validarCrear(){
        anio=document.getElementById("anio").value;
        var val=0;


        if(/^\d{4}$/.test(anio)===false){
            alert("Introduzca un año válido");
            return false;
        }
        /*
        * Si se ha pulsado el botón añadir, comprueba que el año no esté en la base de datos
        */
        if(opcion==1){
            $.ajax({
                url: "comprobarAnio.php?anio="+anio,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if(respuesta==1){
                        alert("El año ya existe, introduzca otro");
                        return false;
                    }
                    else
                    {
                        val=1;
                    }
                }
            });

        }
        else
        {
            /*
            * Si se ha pulsado el botón modificar, se comprueba que el año esté en la base de datos
             */
            $.ajax({
                url: "comprobarAnio.php?anio="+anio,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if(respuesta==0){
                        alert("Para modificar introduzca un año existente");
                        return false;
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

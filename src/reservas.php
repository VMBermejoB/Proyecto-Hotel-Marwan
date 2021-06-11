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
</head>
<body>


<nav class="row">
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#donde">Donde estamos</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#serv">Servicios</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="habitaciones.php">Habitaciones</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="reservas.php">Reservas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="gestionUsuarios.php">Usuario</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
        <img src="imagenes/logo2.PNG" alt="logo">
    </div>
</nav>
</nav>
<main class="row" id="contenedor">
    <article class="row">
        <div class="col-12">

            <?php
            require 'procesosApp.php';
                $objProcesos=new procesosApp();

                require_once 'metodos.php';
                $objConexion=new metodos();



                if(!isset($_POST["enviar"])){

                    /**
                     * Formulario de número de habitaciones
                     */

                    $consulta="SELECT * from habitaciones";

                    $objConexion->realizarConsultas($consulta);

                    /**
                     * Si no hay habitaciones, devuelve a la página de inicio
                     */

                    if($objConexion->comprobarSelect()>0){
                       echo' <div class="row justify-content-center">
                         <form action="reservas.php" class="col-6" method="post">
                        
                        <h2>Realizar Reservas</h2>
                        <hr>
                        <div class="form-group">
                            <label for="num">¿Cuántas habitaciones quieres?</label>
                           
                            <input type="number" class="form-control" id="num" name="num" required min="1"/></br>
                        </div>
                       <input type="submit" class="btn btn-primary" name="enviar" value="enviar"/>
                    </form>
                    </div>';
                    }
                    else
                    {
                        echo'<script>
                        
                         Swal.fire({
                            title:"Error",
                            icon:"error",
                            text:"No hay habitaciones disponibles para reservar",
                            confirmButtonText:"Aceptar",
                            confirmButtonColor: "#011d40",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                            
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("index.php");
                        }
                    })
                         
                        </script>
                       ';
                    }




                    /**
                     * Mostrar reservas realizadas por el cliente
                     */

                    $consulta="SELECT r.idReserva,u.nombre,u.correo,r.fInicio,r.fFin
                        FROM reservas r
                        INNER JOIN
                        usuarios u
                        ON r.idUsuario=u.idUsuario
                        WHERE r.idUsuario=".$_SESSION["id"]."
                        ORDER BY r.fInicio DESC";


                    $objConexion->realizarConsultas($consulta);
                    /**
                    * Comprueba si se han encontrado reservas realizadas, en el caso de ser así se muestran
                     */
                    if($objConexion->comprobarSelect()>0){

                        $numReservas=$objConexion->comprobarSelect();


                        echo'
                            <div class="row justify-content-center">
                            <h1 class="col-auto">Mis reservas</h1>

                         <table class="table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                          <th scope="col">Nombre</th>
                                          <th scope="col">Correo</th>
                                          <th scope="col">Fecha llegada</th>
                                          <th scope="col">Fecha salida</th>
                                          <th scope="col">Descargar</th>
                                          <th scope="col">Cancelar</th>
                                        </tr>
                                    </thead>';


                        for($i=0;$i<$fila=$objConexion->extraerFilas();$i++){

                            $tfIn=explode("-", $fila["fInicio"]);
                            $fIn=$tfIn[2]."/".$tfIn[1]."/".$tfIn[0];

                            $tfFin=explode("-", $fila["fFin"]);
                            $fFin=$tfFin[2]."/".$tfFin[1]."/".$tfFin[0];

                            echo'
                          <tbody class="table-striped">
                                 <tr>
                                    <th>'.$fila["nombre"].'</th>
                                    <td>'.$fila["correo"].'</td>
                                    <td>'.$fIn.'</td>
                                    <td >'.$fFin.'</td>
                                    <td><button type="button" class="btn btn-secondary info" ><a href="generarPdf.php?reserva='.$fila["idReserva"].'"><img src="imagenes/iconos/pdf.png"></a></button></td>
                                    <td><button type="button" class="btn btn-secondary info" ><img src="imagenes/iconos/papelera.png"></button></td>
                                </tr>';

                        }
                        echo'
                        
                            </tbody>
                             </table>
                        </div>';

                        }





                }
                else {
                    echo '<form action="resReservas.php" onsubmit="return validarHab()" method="post">
                    <input type="hidden" name="num" id="num" value="'.$_POST["num"].'">
                    <h2>Reservas</h2>
                    <hr>
                    <div class="form-group">
                        <label for="correo">Introduce tipo</label>';
                    for ($i = 0; $i < $_POST["num"]; $i++) {

/**
 * Input oculto en el que se guardarán las habitaciones que estén libres
 */
                        echo '<input type="hidden" id="libres" name="libres[]">';
                        $consulta = 'SELECT * FROM tipo';

                        $objConexion->realizarConsultas($consulta);
/**
 * Select de forma dinámica para seleccionar los tipos
 */
                        echo '<div class="form-group">

                            
                        <select class="form-select" name="tipos[]">';

                        while ($fila = $objConexion->extraerFilas()) {
                            echo '<option value="' . $fila["idTipo"] . '" name="' . $fila["nombre"] . '">' . $fila["nombre"] . '</option>';
                        }
                        echo '

                        </select>
                        
                        <label>¿Necesita una habitación adaptada?</label><br>
                           <input type="radio" class="btn-check" name="adaptada'.$i.'" id="adsi'.$i.'" value="1">
                           <label class="btn btn-outline-primary text-light" for="adsi'.$i.'">Adaptada</label>
                           <input type="radio" class="btn-check" name="adaptada'.$i.'" id="adno'.$i.'" value="0" checked>
                           <label class="btn btn-outline-primary text-light" for="adno'.$i.'">No adaptada</label>
                        </div>';
                    }

                    echo '
                       
                    </div>
                    <div class="form-group">
                        <label for="fIN">Introduce fecha de inicio</label>
                        <input type="text" class="form-control" id="datepicker" autocomplete="off" onchange="activar()" onkeydown="return false" name="fIn" required/></br>
                    </div>
                    <div class="form-group">
                        <label for="fFin">Introduce fecha de fin</label>
                        <input type="text" class="form-control" id="datepicker2" autocomplete="off" onkeydown="return false" name="fFin" required/></br>
                    </div>
                    
                    <input type="submit" class="btn btn-primary" name="enviar2" value="Calcular"/>
                </form>';
                }
            ?>
            
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
</body>
</html>
<script>

    $( function() {
        $( "#datepicker" ).datepicker({
            minDate: new Date(),
            dateFormat:'dd/mm/yy',
        });

    } );

    function activar(){
/**
 * Se activa este datepicker cuando se modifica el de fecha de inicio
 */
        var fecha=document.getElementById("datepicker").value;
        document.getElementById("datepicker2").value="";
        var partesfecha = fecha.split("/");
        fecha=new Date(+partesfecha[2], partesfecha[1] - 1, +partesfecha[0]);
        fecha.setDate(fecha.getDate()+1);

        $('#datepicker2').datepicker('destroy');

        $( function() {
            $( "#datepicker2" ).datepicker({
                minDate: new Date (fecha),
                dateFormat:'dd/mm/yy',
            });

        } );
    }
/**
 * Generación de Pdf
 */



    function validarHab(){

        var num=document.getElementById("num").value;
        var fIn=document.getElementById("datepicker").value;
        var fFin=document.getElementById("datepicker2").value;
        var cont=0;
        var tipos=[];
        var hab=[];
        var adaptada=[];

        var numAdaptadas=0;

/**
*   Inicializo el array para que así no de error al pasarlo por ajax
*/
        hab[0]=0;

/**
* Guardo todos los tipos en un array
*/
        for (i=0;i<num;i++){
            tipos[i]=document.getElementsByName("tipos[]")[i].value;
        }
/**
* Guardo si se ha elegido una habitación adaptada o no para cada uno de los tipos elegidos en un array
*/
        for (i=0;i<num;i++){
            if(document.getElementById("adsi"+i).checked){
                adaptada[i]=document.getElementById("adsi"+i).value;
            }
            else
            {
                adaptada[i]=document.getElementById("adno"+i).value;
            }
        }

        for(i=0;i<num;i++){
            if(adaptada[i]==1){
                numAdaptadas++;
            }
        }


        for (i=0;i<num;i++){
            /**
            * Convierto el array de habitaciones a string para pasarlo por url
             */
            var ocupadas=hab.join('-');
            $.ajax({
                url: "comprobarHab.php?tipo="+tipos[i]+"&fIn="+fIn+"&fFin="+fFin+"&ocupadas="+ocupadas+"&adaptada="+adaptada[i]+"&numAdaptadas="+numAdaptadas,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if(respuesta!=0){
                        hab[i]=respuesta;
                        cont++;
                    }

                }
            });
        }

        if(cont==num){
            for(i=0;i<num;i++)
            {

                document.getElementsByName("libres[]")[i].value=hab[i];
            }
            return true;
        }
        else
        {
            Swal.fire({
                title:"Error",
                icon:"error",
                text:"No hay habitaciones disponibles",
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
            return false;
        }

    }

</script>
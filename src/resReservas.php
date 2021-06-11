<?php
    session_start();
/**
 * Comprobación de perfiles de usuario
 */
    if(!isset($_SESSION["perfil"])){
        header("Location:index.php");
    }

    if($_SESSION["perfil"]!='u'){
        header("Location:index.php");
    }


/**
 * Ocultar botón de pago al realizarlo, si no se ha realizado se comprueba si ha recibido los datos
 */
    if(!isset($_POST["enviar3"])){

        if(!isset($_POST["fIn"]) || !isset($_POST["fFin"]) || !isset($_POST["num"]) || !isset($_POST["libres"])){
            header("Location:index.php");
        }

        if(empty($_POST["fIn"]) || empty($_POST["fFin"]) || empty($_POST["num"]) || empty($_POST["libres"])){
            header("Location:index.php");
        }
    }

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja resumen</title>
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
<main class="row" id="contenedor">
    <article class="row">
        <div class="col-12">
                <?php
                    require_once 'procesosApp.php';
                    $objProcesos=new procesosApp();

                    require_once 'metodos.php';
                    $objConexion=new metodos();


                        echo'<form action="'.$objProcesos->reserva().'" method="POST" id="hojaresumen">
                                <h3>Datos de reserva</h3>
                                <hr>
                                <h4>Fecha</h4>
                                <div class="form-group row">
                                    <label for="fIN" class="col-6">Fecha de inicio</label>
                                    <label for="fFin" class="col-6">Fecha de fin</label>
                                    <input type="text" class="col-6" id="fIn" name="fIn" value="'.$_POST["fIn"].'" required readonly/></br>
        
                                    <input type="text" class="col-6" id="fFin" name="fFin" value="'.$_POST["fFin"].'" required readonly/></br>
                                </div>
                                <input type="hidden" name="num" id="num" value="'.$_POST["num"].'" readonly>
                                <h4>Habitaciones</h4>';

                                $num=$_POST["num"];
                                $habitaciones = $_POST["libres"];

                        /**
                         * Conversión de fechas
                         */
                        $tfIn=explode("/", $_POST["fIn"]);
                        $fIn=$tfIn[2]."-".$tfIn[1]."-".$tfIn[0];
                        $fIn = date_create($fIn);
                        $fIn = date_format($fIn , 'Y-m-d');


                        $tfFin=explode("/", $_POST["fFin"]);
                        $fFin=$tfFin[2]."-".$tfFin[1]."-".$tfFin[0];
                        $fFin = date_create($fFin);
                        $fFin = date_format($fFin , 'Y-m-d');

                        $fecha = date_create($fIn);
                        $fecha = date_format($fecha , 'Y-m-d');

                        $tfecha2 = explode("-", $fecha);
                        $fecha2=$tfecha2[0]."".$tfecha2[1]."".$tfecha2[2];

                        $pTotal=0;

                        for($i=0;$i<$num;$i++){
                            $precio=0;
                            /**
                             * Obtener tipo de habitación de la habitación correspondiente
                             */
                                    $consulta="SELECT idTipo FROM habitaciones WHERE numHabitacion=".$habitaciones[$i];
                                    $objConexion->realizarConsultas($consulta);

                                    $tipo=$objConexion->extraerFilas();

                            /**
                             * Extraer precios de cada habitación según temporada, tipo y ofertas
                             */

                            while($fecha<$fFin){
                                $consulta="SELECT idTemporada FROM temporada WHERE ".$fecha2." BETWEEN fInicioTemp AND fFinTemp";

                                $objConexion->realizarConsultas($consulta);

                                $temporada=$objConexion->extraerFilas();

                                $consulta="SELECT precio FROM temporadatipo WHERE idTemporada=".$temporada[0]." AND idTipo=".$tipo[0];

                                $objConexion->realizarConsultas($consulta);

                                $precioTemp=$objConexion->extraerFilas();


                                $consulta="SELECT o.porcentaje 
                                FROM oferta o                   
                                WHERE o.idTipo=".$tipo[0]." AND ".$fecha2." BETWEEN o.fInicio AND o.fFin";

                                $objConexion->realizarConsultas($consulta);

                                /**
                                 * Comprueba si hay alguna oferta activa para el día en el que se encuentre el bucle para hacer el cálculo
                                 */
                                if($objConexion->comprobarSelect()>0){
                                    $porcentaje=$objConexion->extraerFilas();
                                    $porcentaje[0]=100-$porcentaje[0];

                                    $precioTemp[0]=$precioTemp[0]*($porcentaje[0]/100);
                                }
                                $precio=$precio+$precioTemp[0];


                                $fecha=date("Y-m-d",strtotime($fecha."+ 1 days"));

                                $tfecha2 = explode("-", $fecha);
                                $fecha2=$tfecha2[0]."".$tfecha2[1]."".$tfecha2[2];
                            }

                            echo'
                                    <label for="precios">Precio total habitación '.$habitaciones[$i].'</label>
                                    <input type="text" class="col-12" id="precios" name="precios[]" value="'.$precio.' €"  readonly>
                                    

                                    <input type="hidden" id="habitaciones" name="habitaciones[]" value="'.$habitaciones[$i].'">';

                            $pTotal=$pTotal+$precio;
                            $fecha = date_create($fIn);
                            $fecha = date_format($fecha , 'Y-m-d');

                            $tfecha2 = explode("-", $fecha);
                            $fecha2=$tfecha2[0]."".$tfecha2[1]."".$tfecha2[2];
                        }

                            echo '
                                    <h4>Total</h4>
                                    <label for="total"></label>
                                    <input type="text" id="total" class="col-12" name="total" value="'.$pTotal.' €" readonly>
                                    
                                    <div class="row justify-content-center">
                                      <a href="reservas.php" id="volver" class="btn btn-primary col-3"> Volver</a>
                                    </div>
                                                                   
                                    <input type="submit" name="enviar3" id="enviar3" value="Confirmar"/>
                                    <div id="smart-button-container">
                                        <div style="text-align: center;">
                                            <div id="paypal-button-container"></div>
                                        </div>
                                    </div>
                             </form>';
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
<script src="https://www.paypal.com/sdk/js?client-id=sb&currency=EUR" data-sdk-integration-source="button-factory"></script>
<script>

    $('#enviar3').hide();

    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'blue',
                layout: 'vertical',
                label: 'checkout',

            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{"description":"Habitaciones","amount":{"currency_code":"EUR","value":<?php echo $pTotal?>}}]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {

                    $('#paypal-button-container').hide();
                    $('#enviar3').click();
                    Swal.fire({
                        title:"Éxito",
                        icon:"success",
                        text:"La reserva se ha realizado correctamente",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(function(){ window.location.replace("reservas.php"); }, 1000);
                        }
                    });


                });
            },

            onError: function(err) {
                Swal.fire({
                    title:"Error",
                    icon:"error",
                    text:"Se ha producido un error al realizar la reserva",
                    confirmButtonText:"Aceptar",
                    confirmButtonColor: "#011d40",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    stopKeydownPropagation:false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(function(){ window.location.replace("reservas.php"); }, 1000);
                    }
                });
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton();
</script>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

    <script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
    if(!isset($_SESSION["perfil"]))
    {
        echo
        '
            <nav class="row">
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#donde">Donde estamos</a></div>
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#serv">Servicios</a></div>
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="habitaciones.php">Habitaciones</a></div>
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#contacto">Contáctenos</a></div>
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="iniciosesion.php">Inicio Sesión</a></div>
                <div id="logo" class="col-auto offset-auto d-none d-sm-block">
                    <img src="imagenes/logo2.PNG" alt="logo">
                </div>
            </nav>
        ';
    }
    else
    {
        if($_SESSION["perfil"]=='u' || $_SESSION["perfil"]=='t')
        {
            echo
            '
                <nav class="row">
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#donde">Donde estamos</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="index.php#serv">Servicios</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="habitaciones.php">Habitaciones</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="reservas.php">Reservas</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="gestionUsuarios.php">Usuario</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesión</a></div>
                    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
                        <img src="imagenes/logo2.PNG" alt="logo">
                    </div>
                </nav>
            ';
        }
    }

require_once  'metodos.php';
$objMetodos=new metodos();
    $consulta=
        "
            SELECT idTipo,nombre, descripcion
            FROM tipo;
        ";
    $objMetodos->realizarConsultas($consulta);
echo '

    <div class="containter" >
        <main class="row" id="contenedor">
    ';
            if($objMetodos->comprobarSelect()>0)
            {
                    $habitaciones=$objMetodos->comprobarSelect();
                  for ($i=0;$i<$habitaciones;$i++) {
                        $habitacion[$i]=$objMetodos->extraerFilas();
                      }
                    for($i=0;$i<$habitaciones;$i++)
                    {
                        $consulta2=
                            "
                                SELECT nombre FROM imagenes WHERE idTipo=".$habitacion[$i]["idTipo"].";
                            ";
                        $objMetodos->realizarConsultas($consulta2);
                        $imagen=$objMetodos->comprobarSelect();
                      echo '        
                    <article class="row">
                    <div class="habitacion border-3 rounded">
                    
                    <div id="carousel'.$i.'" class="carousel slide" data-bs-ride="carousel'.$i.'">
                     <div class="carousel-indicators">
                    ';
                      for($j=0;$j<$imagen;$j++)
                      {
                         echo '<button type="button" data-bs-target="#carousel'.$i.'" data-bs-slide-to="'.$j.'" class="active" aria-current="true" aria-label="Slide '.$j.'"></button>';
                      }
  /**
   * Extraer imagenes
   */
                echo '      
                </div>
                            <div class="carousel-inner">';
                                 for($j=0;$j<$imagen;$j++){
                                    $fila=$objMetodos->extraerFilas();

                                    if($j==0){
                                        echo'<div class="carousel-item active">';
                                    }
                                    else
                                    {
                                        echo'<div class="carousel-item">';
                                    }
                                     echo'                                
                                        <img src="'.$fila["nombre"].'" class="d-block w-100" alt="habitación">
                                    </div>';
                                }

                            echo'
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel'.$i.'" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel'.$i.'" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        
                    <h1>Habitación ' . $habitacion[$i]["nombre"] . '</h1>
    
                    <p class="text-break">' . $habitacion[$i]["descripcion"] . '</p>
                        <h5>Otros Servicios</h5>
                        <ul class="list-group list-group-horizontal row">
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Aire acondicionado</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Armario guardaropa</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4"> Insonorizada</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Parquet o suelo de madera</li>            
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Calefacción</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Escritorio</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Secador de pelo</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Baño privado</li>
                                       
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Ducha</li>
                       
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Articulos de aseo para el baño</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Aseo</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Televisión Satelite</li>
                        
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Internet wifi</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Telefono</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4"> Television de pantalla plana</li>
                      
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Hervidor electrico</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4">Despertador</li>
                            <li class="list-group-item flex-fill col-12 col-sm-6 col-md-4"> Tranfert Aeoropuerto</li>
                        </ul>
                        ';
/**
 * Obtención de fecha actual para la comprobación de ofertas existentes
 */
                        $hoy=getdate();
/**
 * getdate() devuelve los días y los meses sin 0 por ello se contatena el 0 para evitar error en la consulta
 */
                        if($hoy["mon"]<=9){
                            $hoy["mon"]="0".$hoy["mon"];
                        }

                        if($hoy["mday"]<=9){
                            $hoy["mday"]="0".$hoy["mday"];
                        }

                        $fhoy=$hoy["year"]."".$hoy["mon"]."".$hoy["mday"];
/**
 * Consulta para comprobar si hay alguna oferta para el día de hoy
 */
                        $consulta="SELECT o.fInicio, o.fFin, o.porcentaje 
                        FROM oferta o 
                        WHERE o.idTipo=".$habitacion[$i]["idTipo"]." && '".$fhoy."' BETWEEN o.fInicio AND o.fFin";
                        $objMetodos->realizarConsultas($consulta);
                        if($objMetodos->comprobarSelect()>0){
                            $oferta=$objMetodos->extraerFilas();

/**
 * Conversión de formato de fechas
 */

                            $tfIn=explode("-", $oferta["fInicio"]);
                            $fInicio=$tfIn[2]."/".$tfIn[1]."/".$tfIn[0];

                            $tfFin=explode("-", $oferta["fFin"]);
                            $fFin=$tfFin[2]."/".$tfFin[1]."/".$tfFin[0];

                         echo'   <div class="card-grid"> 
                          <div class="front">
                                <div>
                                    <img src="imagenes/ofertas.png" alt="ofertas">
                                </div>
                            </div> 
                          <div class="back">
                           
                            
                            <h3>Oferta del '.$oferta["porcentaje"].'% </h3>        
                            <hr>
                            <h5>Disponible del día '.$fInicio.' al '.$fFin.'</h5>     
                                          
                            ';

                         echo'   </div> 
                        </div>';
                        }

                echo' </article>';

                }
            }
            else
            {
                echo
                '
                    <script>
                        Swal.fire({
                    title:"Error",
                    icon: "error",
                    text:"No hay habitaciones disponibles.",
                    confirmButtonColor: "#011d40",
                    confirmButtonText:"Aceptar",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    stopKeydownPropagation:false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.top.location="index.php";
                    }
                })
                    </script>
                ';


            }
     echo'       
        </main>
        <footer class="row">

            <div class="col-12 center-block">
                <div class="logo2"><img src="imagenes/logo3.PNG" alt="logo"></div>
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
';
?>
</body>
</html>
<script>
    $(".card-grid").flip();
</script>
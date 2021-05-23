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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<?php
    if(!isset($_SESSION["perfil"]))
    {
        echo
        '
            <nav class="row">
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Quienes Somos</a></div>
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Noticias</a></div>
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Habitaciones</a></div>
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#"> Actividades</a></div>
                <div class="col-12 col-sm-1 d-flex align-items-center"><a href="iniciosesion.php">Inicio Sesión</a></div>
                <div id="logo" class="col-auto offset-auto d-none d-sm-block">
                    <img src="imagenes/logo2.PNG">
                </div>
            </nav>
        ';
    }
    else
    {
        if($_SESSION["perfil"]=='u')
        {
            echo
            '
                <nav class="row">
                    <div class="<col-12 col-sm-1> d-flex align-items-center"><a href="#">Quienes Somos</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Noticias</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Habitaciones</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#"> Actividades</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Reservar Habitaciones</a></div>
                    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
                    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
                        <img src="imagenes/logo2.PNG">
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
            FROM tipo
        ";
    $objMetodos->realizarConsultas($consulta);
echo '
<!--En el siguiente div es donde va toda la magia-->
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
                                SELECT i.nombre
                                FROM imagenes i
                                    INNER JOIN
                                    imagenesTipos it
                                    ON i.idImagen=it.idImagen
                                        INNER JOIN
                                        tipo t
                                        ON t.idTipo=it.idTipo
                                WHERE t.idTipo=".$habitacion[$i]["idTipo"].";
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
  /*
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
                                        <img src="'.$fila["nombre"].'" class="d-block w-100" alt="...">
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
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item flex-fill">Aire acondicionado</li>
                            <li class="list-group-item flex-fill">Armario guardaropa</li>
                            <li class="list-group-item flex-fill"> Insonorizada</li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item flex-fill">Parquet o suelo de madera</li>
                            <li class="list-group-item flex-fill">Calefacción</li>
                            <li class="list-group-item flex-fill">Escritorio</li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item flex-fill">Secador de pelo</li>
                            <li class="list-group-item flex-fill">Baño privado</li>
                            <li class="list-group-item flex-fill">Ducha</li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item flex-fill">Articulos de aseo para el baño</li>
                            <li class="list-group-item flex-fill">Aseo</li>
                            <li class="list-group-item flex-fill">Televisión Satelite</li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item flex-fill">Internet wifi</li>
                            <li class="list-group-item flex-fill">Telefono</li>
                            <li class="list-group-item flex-fill"> Television de pantalla plana</li>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item flex-fill">Hervidor electrico</li>
                            <li class="list-group-item flex-fill">Despertador/despertador por telefono</li>
                            <li class="list-group-item flex-fill"> Tranfert Aeoropuerto</li>
                        </ul>
                    </div>
                </article> 
     ';
              }
                }
                else
                    {
                        if($objMetodos->comprobarSelect()<0)
                            {
                                echo 'Se ha producido un error';
                            }
                        else
                            {
                                echo '<article class="row">
                                <p class="text-break">
                                    No hay habitaciones añadidas
                                </p>
                    ';
                            }
                    }
     echo'       
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
';
?>
</body>
</html>
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
</head>
<body>
<?php
session_start();
    /*
     * Compruba si se ha iniciado sesión
     */
    if(!isset($_SESSION["perfil"]))
    {
        echo
        '
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
        ';
    }
    else
    {
        /*
         * Comprueba si el usuario es un usuario normal
         */
        if($_SESSION["perfil"]=='u')
        {
            echo
            '
                <nav class="row">
                    <div class="col-1 d-flex align-items-center"><a href="#">Quienes Somos</a></div>
                    <div class="col-1 d-flex align-items-center"><a href="#">Noticias</a></div>
                    <div class="col-1 d-flex align-items-center"><a href="#">Habitaciones</a></div>
                    <div class="col-1 d-flex align-items-center"><a href="#"> Actividades</a></div>
                    <div class="col-1 d-flex align-items-center"><a href="gestionUsuarios.php">Gestión de usuario</a></div>
                    <div class="col-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
                    <div id="logo" class="col-auto offset-auto">
                        <img src="imagenes/logo2.PNG">
                    </div>
                </nav>
            ';
        }
    }
?>
<!--    En el siguiente div es donde va toda la magia-->
    <div class="containter" >
        <main class="row" id="contenedor">

            <article class="row">
                <div class="col-7">
                    <h1>
                        BIENVENIDOS!
                    </h1>
                    <p>
                        La "Antigua Casa de Aduanas" es un austero edificio que data de 1720. De 1859 a 1866 se utilizó como cuartel del Imperio Real
                        de Austria, sirviendo como aduana en una ciudad fronteriza: aún conserva la torreta desde la cual los gendarmes imperiales
                        controlaban el tráfico de frontera. Transformado en una residencia de verano por la noble familia de la Virgine, más tarde fue
                        requisado por las autoridades militares durante el período de guerra. A partir de 1948 comenzó una nueva tradición de taberna y
                        posada. Las renovaciones posteriores han transformado este edificio histórico en un hotel y restaurante.
                    </p>
                    <h2>
                        Quienes somos
                    </h2>
                    <p>
                        Se trata de una gestion familiar con una amplia tradicion hostelera y de reastauracion nos avalan mas de 50 años de experiencia
                        desde la transformacion en hotel baja la direcion de Rino Prestanizzi y su esposa Gabriella Biavati a la actulidad dirigido por su
                        hijo Max Prestanizzi su esposa Mariangela Carezzi con un grupo profesional de esperiencia en trabajo de la hosteleria y restauracion
                    </p>
                </div>
                <div class="col-5 imagenes">
                    <img src="imagenes/hotel2.jpg">
                </div>

                <div id="donde" class="row">
                    <div class="col-5">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2798.5870408708693!2d10.633891015557214!3d45.45797717910085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4781eb0e4a320b05%3A0xb41a5845027847b5!2sHotel%20Dogana!5e0!3m2!1ses!2ses!4v1618657893185!5m2!1ses!2ses" width="500" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <div class="col-7">
                        <p>
                        <h2>Donde Estamos</h2>
                        Nos encontramos en una posicion inmejorable para disfrutar del maravilloso Lago di Garda,
                        cocretamente nos encontramos en la zona de Punta Gro a pocos pasos del lago di Garda,
                        como para visitar los marvillosos pueblos cercanos del lago como son Sirmione el cual
                        esta considerado patrimono de la umanidad por la UNESCO o el pintoresco pueblo de Peschiera del Garda,
                        a los cuales puedes llegar facilmente con los autobuses urbanos que pasan delante de nuestras istalaciones, o con tan solo
                        5 minutos en coche<br>
                        </p>
                    </div>
                </div>
                <div id="servicios" class="row">
                    <div class="col-7">
                        <h2>Servicios</h2>
                        <ul>
                            <li>En Nuestra estructura Tenemos una gran variedad de servicios para nuestros clientes:</li>
                            <li>Recepcion disponible 24 Horas disponible para atenderle</li>
                            <li>Servicio Despertador</li>
                            <li>Desayuno a Buffet (Su usted no fuese aun nuestro hospite puede disfrutal de el por el modico de 15 euros)</li>
                            <li>Desayuno servido en la habitacion si ustes lo desea sin coste adiccional</li>
                            <li>Desayuno Para llevar</li>
                            <li>Piscina al externo</li>
                            <li>Alquiler de Bicicleta</li>
                            <li>Venta de entradas para el parque tematico Gardaland</li>
                            <li>Venta de entradas para el parque tematico Movieland</li>
                            <li>Tranfer para el Aeropuerto de Verona
                            <li>Cata de Vinos de la Zona</li>
                        </ul>
                    </div>
                    <div class="col-5 imagenes">
                        <img src="imagenes/sala.jpg">
                    </div>

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
<?php

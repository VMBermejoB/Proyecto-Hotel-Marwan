<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalación</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php

$servidor='localhost';
$usuario='root';
$password='';

$mysqli=new mysqli($servidor,$usuario,$password);
if (!isset($_POST["enviar"]))
{
    echo
    '
       <main class="row" id="contenedor">
        <article class="row">
            <div class="col-12 justify-content-center bienvenida"> 
                <div id="logoinicio">
                    <img src="imagenes/logo3.PNG">
                </div>
                    
                 <h1>Bienvenido a la página de Instalación</h1>                                
            </div>
        </article>
    </main>
                    <form action="#" method="POST">
                        <label for="enviar">Pulse el boton para empezar la Instalación</label></br>
                        <input type="submit" class="btn btn-primary" name="enviar" value="Iniciar la instalación"/>
                    </form>
                ';
}
else
{
    $consulta1=
        "
        CREATE USER 'HotelMarwan'@'localhost' IDENTIFIED BY '123456';
        ";
    $resultado=mysqli_query($mysqli,$consulta1);


    $consulta2=
        "
        CREATE DATABASE IF NOT EXISTS gestionhotel DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
        ";
    $resultad2=mysqli_query($mysqli,$consulta2);

    $consulta3=
        "
        GRANT ALL PRIVILEGES ON gestionhotel.* TO 'HotelMarwan'@'localhost';
        ";
    $resultad3=mysqli_query($mysqli,$consulta3);
    $consulta=
    "
        USE gestionhotel;
        -- Base de datos: gestionhotel
        
        USE gestionhotel;
        
        CREATE TABLE usuarios(
                         idUsuario INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                         nombre VARCHAR(80) NOT NULL,
                         correo VARCHAR(120) NOT NULL UNIQUE,
                         password VARCHAR(255) NOT NULL,
                         tlfno CHAR (9) NOT NULL,
                         perfil char(1) CHECK (perfil in ('u','t')),
                         pregunta VARCHAR (300) NOT NULL,
                         respuesta VARCHAR (300) NOT NULL
);

CREATE TABLE temporada(
                          idTemporada TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                          nombre VARCHAR (50) NOT NULL,
                          fInicioTemp DATE NOT NULL,
                          fFinTemp DATE NOT NULL,
                          anio CHAR (4)
);

CREATE TABLE tipo(
                     idTipo TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                     nombre VARCHAR(30) NOT NULL UNIQUE,
                     descripcion VARCHAR(300) NOT NULL
);

CREATE TABLE temporadaTipo(
                              idTipo TINYINT UNSIGNED NOT NULL,
                              idTemporada TINYINT UNSIGNED NOT NULL,
                              precio DECIMAL(5,2) NULL,
                              PRIMARY KEY(idTipo, idTemporada),
                              CONSTRAINT fk_tipoTempTipo FOREIGN KEY (idTipo) REFERENCES tipo (idTipo) ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT fk_temporadaTempTemporada FOREIGN KEY (idTemporada) REFERENCES temporada (idTemporada) ON DELETE CASCADE ON UPDATE CASCADE

);

CREATE TABLE oferta(
                       idOferta TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                       idTipo TINYINT UNSIGNED NOT NULL,
                       porcentaje TINYINT UNSIGNED NOT NULL CHECK(porcentaje BETWEEN 1 and 100),
                       fInicio DATE NOT NULL,
                       fFin date NOT NULL,
                       CONSTRAINT fk_tipoTipo FOREIGN KEY (idTipo) REFERENCES tipo (idTipo) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE habitaciones(
                             numHabitacion CHAR (3) PRIMARY KEY,
                             planta CHAR (1) NOT NULL,
                             capacidad CHAR(1) NOT NULL,
                             dimesiones TINYINT UNSIGNED NOT NULL,
                             idTipo TINYINT UNSIGNED NOT NULL,
                             adaptada BIT DEFAULT 0 NOT NULL,
                             CONSTRAINT fk_tipoHabitacion FOREIGN KEY (idTipo) REFERENCES tipo (idTipo) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE reservas(
                         idReserva INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                         fInicio DATE NOT NULL,
                         fFin DATE NOT NULL,
                         idUsuario INT UNSIGNED NOT NULL,
                         CONSTRAINT fk_usuarioReserva FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE reservasHab(
                            idReserva INT UNSIGNED NOT NULL,
                            numHabitacion CHAR(3) NOT NULL,
                            precioRes DECIMAL(5,2) NOT NULL,
                            PRIMARY KEY(idReserva, numHabitacion),
                            CONSTRAINT fk_habitacionHabitacion FOREIGN KEY (numHabitacion) REFERENCES habitaciones (numHabitacion) ON DELETE CASCADE ON UPDATE CASCADE,
                            CONSTRAINT fk_reservaReserva FOREIGN KEY (idReserva) REFERENCES reservas (idReserva) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE imagenes(
                         idImagen TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                         nombre varchar(200)  NOT NULL,
                         idTipo TINYINT UNSIGNED NOT NULL,
                         CONSTRAINT fk_tipoimagen FOREIGN KEY (idTipo) REFERENCES tipo (idTipo) ON DELETE CASCADE ON UPDATE CASCADE
);


/*Datos*/

    INSERT INTO usuarios (nombre, correo, password, tlfno, perfil, pregunta, respuesta)
    VALUES ('paco', 'paco@gmail.com', '$2y$10$5P.h7kToWxKzWZ0bTX3GVeXsWhUNZab9jHDCor3O632N3nyA3UIDi', '123456789', 'u', '¿El nombre de mi escuela?', 'evg'),
           ('victor', 'victor@gmail.com', '$2y$10$5P.h7kToWxKzWZ0bTX3GVeXsWhUNZab9jHDCor3O632N3nyA3UIDi', '123456789', 't', '¿El nombre de mi escuela?', 'evg'),
           ('isa', 'isa@gmail.com', '$2y$10$5P.h7kToWxKzWZ0bTX3GVeXsWhUNZab9jHDCor3O632N3nyA3UIDi', '123456789', 'u', '¿El nombre de mi escuela?', 'evg'),
           ('victor m', 'victor.bermejo@gmail.com', '$2y$10$5P.h7kToWxKzWZ0bTX3GVeXsWhUNZab9jHDCor3O632N3nyA3UIDi', '123456789', 't', '¿El nombre de mi escuela?', 'evg')
    ";
    $resultado=mysqli_multi_query($mysqli,$consulta);
    $mysqli->close();
    header("Location:AnadirGestor.php");
}
?>
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

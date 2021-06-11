CREATE DATABASE IF NOT EXISTS gestionhotel DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;

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
VALUES ('paco', 'paco@gmail.com', '$2y$10$5P.h7kToWxKzWZ0bTX3GVeXsWhUNZab9jHDCor3O632N3nyA3UIDi', '123456789', 'u', '多El nombre de mi escuela?', 'evg'),
       ('victor', 'victor@gmail.com', '$2y$10$5P.h7kToWxKzWZ0bTX3GVeXsWhUNZab9jHDCor3O632N3nyA3UIDi', '123456789', 't', '多El nombre de mi escuela?', 'evg'),
       ('isa', 'isa@gmail.com', '$2y$10$5P.h7kToWxKzWZ0bTX3GVeXsWhUNZab9jHDCor3O632N3nyA3UIDi', '123456789', 'u', '多El nombre de mi escuela?', 'evg'),
       ('victor m', 'victor.bermejo@gmail.com', '$2y$10$5P.h7kToWxKzWZ0bTX3GVeXsWhUNZab9jHDCor3O632N3nyA3UIDi', '123456789', 't', '多El nombre de mi escuela?', 'evg')
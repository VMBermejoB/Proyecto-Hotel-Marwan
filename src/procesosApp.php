<?php
    include_once 'metodos.php';
class procesosApp
{
    function __construct()
    {
        echo' <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        $this->objMetodos = new metodos();

    }
/**
 * Función para el inicio de sesión
 */

    function iniciosesion($correo, $password)
    {
        $sentencia = $this->objMetodos->mysqli->prepare("SELECT * FROM usuarios WHERE correo = ?;");
        $sentencia->bind_param("s", $correo);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        if ($fila = $resultado->fetch_array()) {
            if (password_verify($password, $fila["password"])) {

                $_SESSION["id"] = $fila["idUsuario"];
                $_SESSION["perfil"] = $fila["perfil"];

                return true;
            }
            else{
                return false;
            }
        }

        return false;
    }

/**
 * Funciones para el registro de usuario. Todos los usuarios que se registren tendrán perfil 'u'
 */
    function registro()
    {

        if (isset($_POST["enviar"])) {
            if (!isset($_POST["nombre"]) || empty($_POST["nombre"]) || !isset($_POST["correo"]) || empty($_POST["correo"]) || !isset($_POST["pass"]) || empty($_POST["pass"]) ||
                !isset($_POST["tlfno"]) || empty($_POST["tlfno"]) || !isset($_POST["pregunta"]) || empty($_POST["pregunta"]) || !isset($_POST["respuesta"]) || empty($_POST["respuesta"])) {

                echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Rellene todos los campos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';

            }
            else
            {


                $nombre = $_POST["nombre"];
                $correo = $_POST["correo"];
                $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
                $tlfno = $_POST["tlfno"];
                $pregunta = $_POST["pregunta"];
                $respuesta = $_POST["respuesta"];

                $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO usuarios(nombre, correo, password, tlfno, perfil, pregunta, respuesta) VALUES (?,?,?,?,'u',?,?);");
                $sentencia->bind_param("ssssss", $nombre, $correo, $pass, $tlfno, $pregunta, $respuesta);
                $sentencia->execute();

                if ($sentencia->affected_rows > 0) {

                    echo '<script>
                Swal.fire({
                    title:"Éxito",
                    icon:"success",
                    text:"Registro completado",
                    confirmButtonText:"Aceptar",
                    confirmButtonColor: "#011d40",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    stopKeydownPropagation:false,
                }).then((result) => {
                        if (result.isConfirmed) {
                            window.top.location="index.php";
                        }
                    })
                
     
                </script>';

                }
                else
                {
                    echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Error al realizar el registro, inténtelo de nuevo más tarde",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';
                }
            }



        }

    }
    /**
     * Modificación de datos de usuario
     * Se permitirá modificar en esta función el correo, el nombre y el teléfono
     */

    function modificarUsuario(){
        if (isset($_POST["enviar"])) {

            if (!isset($_POST["nombre"]) || empty($_POST["nombre"]) || !isset($_POST["correo"]) || empty($_POST["correo"]) ||
                !isset($_POST["tlfno"]) || empty($_POST["tlfno"]) ) {
                echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Rellene todos los campos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';
            }
            else {

                $nombre = $_POST["nombre"];
                $correo = $_POST["correo"];
                $tlfno = $_POST["tlfno"];

                $sentencia = $this->objMetodos->mysqli->prepare("UPDATE usuarios SET nombre=?, correo=?, tlfno=? WHERE idUsuario=" . $_SESSION["id"]);
                $sentencia->bind_param("sss", $nombre, $correo, $tlfno);
                $sentencia->execute();

                if ($sentencia->affected_rows >= 0) {
                    echo '<script> 
                   Swal.fire({
                                title:"Éxito",
                                icon:"success",
                                text:"Datos modificados con éxito",
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
                    </script>
                    ';
                }
            }

        }
    }
    /**
     * Modificación de contraseña del usuario
     * En esta función se modificará solo la contraseña del usuario, pidiendo anteriormente la contraseña actual
     */
    function modificarPass(){
        if(isset($_POST["enviar1"])){

            if (!isset($_POST["pass2"]) || empty($_POST["pass2"]) ) {
                echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Rellene todos los campos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';
            }
            $pass = password_hash($_POST["pass2"], PASSWORD_DEFAULT);

            $sentencia = $this->objMetodos->mysqli->prepare("UPDATE usuarios SET password=? WHERE idUsuario=".$_SESSION["id"]);
            $sentencia->bind_param("s", $pass);
            $sentencia->execute();

            if($sentencia->affected_rows>=0){
                echo'
               
             
                
                <script>
                  
                    Swal.fire({
                            title:"Éxito",
                            icon:"success",
                            text:"Contraseña modificada con éxito",
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
                </script>
               
                ';
            }
        }
    }
    /**
     * Baja de usuario
     * Función para eliminar a un usuario de la base de datos
     */
    function bajaUsuario(){

        if(isset($_POST["pass4"])){

            $sentencia = $this->objMetodos->mysqli->prepare("DELETE FROM usuarios WHERE idUsuario=".$_SESSION["id"]);
//            $sentencia->bind_param("s", $pass);
            $sentencia->execute();
            session_start();
            session_destroy();

            if($sentencia->affected_rows<0){
                echo'<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Error al realizar la baja, inténtelo de nuevo más tarde",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';
            }
            else
            {
                echo'<script>
                        Swal.fire({
                        title:"Éxito",
                        icon:"success",
                        text:"Se ha realizado la baja correctamente",
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
                });</script>';
            }

        }
    }

    /**
     * Función para añadir nuevas temporadas en la base de datos por parte del usuario trabajador
     */

    function anadirTemporadas(){
        if(isset($_POST["enviar"])){
            if (!isset($_POST["fIn1"]) || empty($_POST["fIn1"]) || !isset($_POST["fIn2"]) || empty($_POST["fIn2"]) ||
                !isset($_POST["fIn3"]) || empty($_POST["fIn3"]) || !isset($_POST["fFin1"]) || empty($_POST["fFin1"]) || !isset($_POST["fFin2"]) ||
                empty($_POST["fFin2"]) || !isset($_POST["anio"]) || empty($_POST["anio"]) ||
            !isset($_POST["fFin3"]) || empty($_POST["fFin3"])) {
                echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Rellene todos los campos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';
            }
            else {


                $anio = $_POST["anio"];

                if ($_POST["opcion"] == 1) {
                    $consulta = "DELETE FROM temporada WHERE anio=" . $anio;
                    $this->objMetodos->realizarConsultas($consulta);
                }

                /**
                 * Conversión de formatos de fechas
                 */

                $tfIn1 = explode("/", $_POST["fIn1"]);
                $fIn1 = $tfIn1[2] . "-" . $tfIn1[1] . "-" . $tfIn1[0];
                $fIn1 = date_create($fIn1);
                $fIn1 = date_format($fIn1, 'Y-m-d');

                $tfIn2 = explode("/", $_POST["fIn2"]);
                $fIn2 = $tfIn2[2] . "-" . $tfIn2[1] . "-" . $tfIn2[0];
                $fIn2 = date_create($fIn2);
                $fIn2 = date_format($fIn2, 'Y-m-d');

                $tfIn3 = explode("/", $_POST["fIn3"]);
                $fIn3 = $tfIn3[2] . "-" . $tfIn3[1] . "-" . $tfIn3[0];
                $fIn3 = date_create($fIn3);
                $fIn3 = date_format($fIn3, 'Y-m-d');

                $tfFinn1 = explode("/", $_POST["fFin1"]);
                $fFin1 = $tfFinn1[2] . "-" . $tfFinn1[1] . "-" . $tfFinn1[0];
                $fFin1 = date_create($fFin1);
                $fFin1 = date_format($fFin1, 'Y-m-d');

                $tfFinn2 = explode("/", $_POST["fFin2"]);
                $fFin2 = $tfFinn2[2] . "-" . $tfFinn2[1] . "-" . $tfFinn2[0];
                $fFin2 = date_create($fFin2);
                $fFin2 = date_format($fFin2, 'Y-m-d');

                $tfFinn3 = explode("/", $_POST["fFin3"]);
                $fFin3 = $tfFinn3[2] . "-" . $tfFinn3[1] . "-" . $tfFinn3[0];
                $fFin3 = date_create($fFin3);
                $fFin3 = date_format($fFin3, 'Y-m-d');


                $nombre1 = "Baja";
                $nombre2 = "Alta";
                $nombre3 = "Media";

                /**
                 * Inserción de datos de las temporadas en la base de datos
                 */
                $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO temporada(nombre, fInicioTemp, fFinTemp, anio) VALUES (?,?,?,?);");
                $sentencia->bind_param("ssss", $nombre1, $fIn1, $fFin1, $anio);
                $sentencia->execute();

                $idTemp1 = $sentencia->insert_id;

                $sentencia->bind_param("ssss", $nombre2, $fIn2, $fFin2, $anio);
                $sentencia->execute();

                $idTemp2 = $sentencia->insert_id;

                $sentencia->bind_param("ssss", $nombre3, $fIn3, $fFin3, $anio);
                $sentencia->execute();

                $idTemp3 = $sentencia->insert_id;

                //Comprobaciones

                $consulta = "SELECT * FROM tipo";
                $this->objMetodos->realizarConsultas($consulta);
                if ($this->objMetodos->comprobarSelect() > 0) {

                    $prueba = $this->objMetodos->comprobarSelect();

                    for ($i = 0; $i < $prueba; $i++) {
                        $fila[$i] = $this->objMetodos->extraerFilas();
                    }

                    $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO temporadaTipo(idTipo, idTemporada) VALUES (?,?);");

                    for ($i = 0; $i < $prueba; $i++) {
                        $sentencia->bind_param("ii", $fila[$i]["idTipo"], $idTemp1);
                        $sentencia->execute();

                        $sentencia->bind_param("ii", $fila[$i]["idTipo"], $idTemp2);
                        $sentencia->execute();

                        $sentencia->bind_param("ii", $fila[$i]["idTipo"], $idTemp3);
                        $sentencia->execute();
                    }

                    if ($sentencia->affected_rows > 0) {

                        echo '<script>
                    Swal.fire({
                        title:"Éxito",
                        icon:"success",
                        text:"Temporada añadida con éxito, Sera usted redirigido a añadir los precios para las habitaciones",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                            if (result.isConfirmed) {
                                window.top.location="precio.php";
                            }
                        })
                    
         
                    </script>';
                    }
                } else {
                    echo '<script>
                    Swal.fire({
                       title:"Éxito",
                        icon:"success",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        text:"Temporada añadida con éxito, pero no hay Tipos de habitaciones añadidos, sera redirigido a añadir tipos de habitaciones",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                            if (result.isConfirmed) {
                                window.top.location="anadirTipo.php";
                            }
                        })
                   </script>';
                }
            }
        }
    }

    /**
     * Función para la creación de reservas y generación de pdf por parte de los usuarios
     */
        function reserva(){

            if(isset($_POST["enviar3"])){
                if (!isset($_POST["precios"]) || empty($_POST["precios"]) || !isset($_POST["habitaciones"]) || empty($_POST["habitaciones"]) || !isset($_POST["total"]) || empty($_POST["total"]) ||
                    !isset($_POST["num"]) || empty($_POST["num"])){
                    echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Rellene todos los campos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';
                }
                else {


                    /**
                     * Obtención de datos del usuario para incluirlos en el pdf
                     */

                    $consulta = "SELECT nombre, correo, tlfno FROM usuarios WHERE idUsuario=" . $_SESSION["id"];

                    $this->objMetodos->realizarConsultas($consulta);
                    $fila = $this->objMetodos->extraerFilas();

                    $precios = $_POST["precios"];

                    for ($i = 0; $i < sizeof($precios); $i++) {
                        $aux = explode(" ", $precios[$i]);
                        $precios[$i] = $aux[0];
                    }

                    $total = $_POST["total"];
                    $aux = explode(" ", $total);
                    $total = $aux[0];


                    $num = $_POST["num"];

                    $habitaciones = $_POST["habitaciones"];

                    /**
                     * Creación de pdf
                     */


                    require('fpdf/fpdf.php');
                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'I', 16);

                    $pdf->Image('imagenes/logo3.PNG', 70, 10, -150);

                    $texto1 = "Nombre: " . $fila[0] . "\nCorreo: " . $fila[1] . "\nTeléfono: " . $fila[2] . "\nFecha de inicio de la reserva: " . $_POST["fIn"] . "\nFecha de fin de la reserva: " . $_POST["fFin"];
                    $pdf->SetXY(25, 50);
                    $pdf->MultiCell(155, 10, $texto1, 1, "L");

                    $pdf->SetFont('Arial', 'I', 16);

                    $pdf->SetXY(45, 120);
                    $pdf->SetFillColor(1, 29, 64);
                    $pdf->SetTextColor(255, 255, 255);
                    $pdf->Cell(80, 10, "Habitación", 1, 0, "C", true);
                    $pdf->Cell(30, 10, "Precio", 1, 1, "C", true);

                    $pdf->SetTextColor(0, 0, 0);

                    for ($i = 0; $i < $num; $i++) {

                        $pdf->SetX(45);
                        $pdf->Cell(80, 10, $habitaciones[$i], 1, 0, "C");
                        $pdf->Cell(30, 10, $precios[$i] . "€", 1, 1, "C");
                    }

                    $pdf->SetTextColor(255, 255, 255);
                    $pdf->SetXY(45, 140 + (10 * $i));
                    $pdf->Cell(80, 10, "Precio Total", 1, 0, "C", true);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->Cell(30, 10, $total . "€", 1, 0, "C");

                    ob_end_clean();
                    $pdf->Output("D", "DatosReserva.pdf");

                    /**
                     * Inserción de las reservas en la base de datos
                     */

                    $tfIn = explode("/", $_POST["fIn"]);
                    $fIn = $tfIn[2] . "-" . $tfIn[1] . "-" . $tfIn[0];
                    $fIn = date_create($fIn);
                    $fIn = date_format($fIn, 'Y-m-d');

                    $tFin = explode("/", $_POST["fFin"]);
                    $fFin = $tFin[2] . "-" . $tFin[1] . "-" . $tFin[0];
                    $fFin = date_create($fFin);
                    $fFin = date_format($fFin, 'Y-m-d');

                    $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO reservas(fInicio, fFin, idUsuario) VALUES (?,?,?);");
                    $sentencia2 = $this->objMetodos->mysqli->prepare("INSERT INTO reservasHab(idReserva, numHabitacion, precioRes) VALUES (?,?,?);");

                    /**
                     * Inserción de datos en la tabla reservas
                     */

                    $sentencia->bind_param("ssi", $fIn, $fFin, $_SESSION["id"]);
                    $sentencia->execute();

                    $idReserva = $sentencia->insert_id;

                    /**
                     * Inserción de datos en la tabla reservashab
                     */
                    for ($i = 0; $i < $num; $i++) {

                        $sentencia2->bind_param("isi", $idReserva, $habitaciones[$i], $precios[$i]);
                        $sentencia2->execute();
                    }
                }
            }

        }

    /**
     * Función para añadir nuevas ofertas en la base de datos por parte del usuario trabajador
     */
        function anadirOfertas(){
            if(isset($_POST["enviar"])){
                if (!isset($_POST["fIn"]) || empty($_POST["fIn"]) || !isset($_POST["fFin"]) || empty($_POST["fFin"]) || !isset($_POST["tipos"]) || empty($_POST["tipos"]) ||
                    !isset($_POST["porcentaje"]) || empty($_POST["porcentaje"])){
                    echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Rellene todos los campos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';
                }
                else {


                    /**
                     * Conversión de fechas
                     */
                    $tfIn = explode("/", $_POST["fIn"]);
                    $fIn = $tfIn[2] . "-" . $tfIn[1] . "-" . $tfIn[0];
                    $fIn = date_create($fIn);
                    $fIn = date_format($fIn, 'Y-m-d');

                    $tFin = explode("/", $_POST["fFin"]);
                    $fFin = $tFin[2] . "-" . $tFin[1] . "-" . $tFin[0];
                    $fFin = date_create($fFin);
                    $fFin = date_format($fFin, 'Y-m-d');

                    $tipo = $_POST["tipos"];
                    $porcentaje = $_POST["porcentaje"];
                    /**
                     * Inserción de datos
                     */
                    $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO oferta(idTipo, porcentaje, fInicio, fFin) VALUES (?,?,?,?);");
                    $sentencia->bind_param("iiss", $tipo, $porcentaje, $fIn, $fFin);
                    $sentencia->execute();

                    if ($sentencia->affected_rows > 0) {


                        echo '<script>
                                Swal.fire({
                                title:"Éxito",
                                icon:"success",
                                text:"Oferta creada con éxito",
                                confirmButtonText:"Aceptar",
                                confirmButtonColor: "#011d40",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                stopKeydownPropagation:false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                   window.top.location="mostrarOfertas.php";
                                }
                        });</script>';


                    } else {
                        echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Se ha producido un error al crear la oferta",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                           
                        }
                    });</script>';
                    }
                }
            }
        }

    /**
     * Función para modificar una oferta seleccionada previamente por parte del usuario trabajador
     */

        function modificarOferta(){

        if(isset($_POST["enviar"])) {

            if (!isset($_POST["fIn"]) || empty($_POST["fIn"]) || !isset($_POST["fFin"]) || empty($_POST["fFin"]) || !isset($_POST["ofertaAnterior"]) || empty($_POST["ofertaAnterior"]) ||
                !isset($_POST["tipos"]) || empty($_POST["tipos"]) || !isset($_POST["porcentaje"]) || empty($_POST["porcentaje"])) {
                echo '<script>
                        Swal.fire({
                        title:"Error",
                        icon:"error",
                        text:"Rellene todos los campos",
                        confirmButtonText:"Aceptar",
                        confirmButtonColor: "#011d40",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation:false,
                    });
                    </script>';

            } else {


                $tipoant = $_POST["tipoAnterior"];
                $ofertaant = $_POST["ofertaAnterior"];
                $tipo = $_POST["tipos"];
                $porcentaje = $_POST["porcentaje"];

                /**
                 * Conversión de fechas
                 */

                $tfIn = explode("/", $_POST["fIn"]);
                $fIn = $tfIn[2] . "" . $tfIn[1] . "" . $tfIn[0];
                //            $fIn = date_create($fIn);
                //            $fIn = date_format($fIn , 'Y-m-d');

                $tFin = explode("/", $_POST["fFin"]);
                $fFin = $tFin[2] . "" . $tFin[1] . "" . $tFin[0];
                //            $fFin = date_create($fFin);
                //            $fFin = date_format($fFin , 'Y-m-d');

                /**
                 * Inserción de datos
                 */

                $sentencia = $this->objMetodos->mysqli->prepare("UPDATE oferta SET idTipo=?, porcentaje=?, fInicio=?, fFin=? WHERE idOferta=?;");
                $sentencia->bind_param("iissi", $tipo, $porcentaje, $fIn, $fFin, $ofertaant);
                $sentencia->execute();

                if ($sentencia->affected_rows >= 0) {

                    echo '<script>
                            Swal.fire({
                            title:"Éxito",
                            icon:"success",
                            text:"Oferta modificada con éxito",
                            confirmButtonColor: "#011d40",
                            confirmButtonText: "Aceptar",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                               window.top.location="mostrarOfertas.php";
                            }
                        });</script>';

                } else {
                    echo '<script>
                            Swal.fire({
                            title:"Error",
                            icon:"error",
                            text:"Se ha producido un error al modificar la oferta",
                            confirmButtonColor: "#011d40",
                            confirmButtonText: "Aceptar",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            stopKeydownPropagation:false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                               
                            }
                        });</script>';
                }

            }

        }
    }
}







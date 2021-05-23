<?php
    include_once 'metodos.php';
class procesosApp
{
    function __construct()
    {

        $this->objMetodos = new metodos();

    }
/**
 * Funciones del inicio de sesión
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
     * Funciones del registro
     */
    function registro()
    {

        if (isset($_POST["enviar"])) {
            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];
            $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
            $tlfno = $_POST["tlfno"];
            $pregunta=$_POST["pregunta"];
            $respuesta=$_POST["respuesta"];

            $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO usuarios(nombre, correo, password, tlfno, perfil, pregunta, respuesta) VALUES (?,?,?,?,'u',?,?);");
            $sentencia->bind_param("ssssss", $nombre, $correo, $pass, $tlfno, $pregunta, $respuesta);
            $sentencia->execute();

            if($sentencia->affected_rows>=0){

               echo'<script>window.location.replace("iniciosesion.php");</script>';

            }
        }
    }
    /**
     * Modificar usuario
     */

    function modificarUsuario(){
        if (isset($_POST["enviar"])) {
            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];
            $tlfno = $_POST["tlfno"];

            $sentencia = $this->objMetodos->mysqli->prepare("UPDATE usuarios SET nombre=?, correo=?, tlfno=? WHERE idUsuario=".$_SESSION["id"]);
            $sentencia->bind_param("sss", $nombre, $correo, $tlfno);
            $sentencia->execute();

            if($sentencia->affected_rows>=0){
                echo'
               
               <div class="col-6 confirmacion" id="mensajeConf"><h3>Datos modificados correctamente</h3></div>
                
                <script>
                  
                    var el = document.getElementById("mensajeConf");
                    el.style.display="block";
                </script>
                ';
            }

        }
    }
    /**
     * Modificar contraseña
     */
    function modificarPass(){
        if(isset($_POST["enviar1"])){
            $pass = password_hash($_POST["pass2"], PASSWORD_DEFAULT);

            $sentencia = $this->objMetodos->mysqli->prepare("UPDATE usuarios SET password=? WHERE idUsuario=".$_SESSION["id"]);
            $sentencia->bind_param("s", $pass);
            $sentencia->execute();

            if($sentencia->affected_rows>=0){
                echo'
               
                <div class="col-6 confirmacion" id="mensajeConf"><h3>Contraseña modificada correctamente</h3>/div>
                
                <script>
                  
                    var el = document.getElementById("mensajeConf");
                    el.style.display="block";
                </script>
               
                ';
            }
        }
    }
    /**
     * Baja de usuario
     */
    function bajaUsuario(){

        if(isset($_POST["enviar2"])){
            $sentencia = $this->objMetodos->mysqli->prepare("DELETE FROM usuarios WHERE idUsuario=".$_SESSION["id"]);
//            $sentencia->bind_param("s", $pass);
            $sentencia->execute();
            session_start();
            session_destroy();
            echo'<script>window.location.replace("disenio.php");</script>';

        }
    }

    function anadirTemporadas(){
        if(isset($_POST["enviar"])){

            $anio=$_POST["anio"];

            /**
             * Conversión de formatos de fechas
             */
            $tfIn1=explode("/", $_POST["fIn1"]);
            $fIn1=$tfIn1[2]."-".$tfIn1[1]."-".$tfIn1[0];
            $fIn1 = date_create($fIn1);
            $fIn1 = date_format($fIn1 , 'Y-m-d');

            $tfIn2=explode("/", $_POST["fIn2"]);
            $fIn2=$tfIn2[2]."-".$tfIn2[1]."-".$tfIn2[0];
            $fIn2 = date_create($fIn2);
            $fIn2 = date_format($fIn2 , 'Y-m-d');

            $tfIn3=explode("/", $_POST["fIn3"]);
            $fIn3=$tfIn3[2]."-".$tfIn3[1]."-".$tfIn3[0];
            $fIn3 = date_create($fIn3);
            $fIn3 = date_format($fIn3 , 'Y-m-d');

            $tfFinn1=explode("/", $_POST["fFin1"]);
            $fFin1=$tfFinn1[2]."-".$tfFinn1[1]."-".$tfFinn1[0];
            $fFin1 = date_create($fFin1);
            $fFin1 = date_format($fFin1 , 'Y-m-d');

            $tfFinn2=explode("/", $_POST["fFin2"]);
            $fFin2=$tfFinn2[2]."-".$tfFinn2[1]."-".$tfFinn2[0];
            $fFin2 = date_create($fFin2);
            $fFin2 = date_format($fFin2 , 'Y-m-d');

            $tfFinn3=explode("/", $_POST["fFin3"]);
            $fFin3=$tfFinn3[2]."-".$tfFinn3[1]."-".$tfFinn3[0];
            $fFin3 = date_create($fFin3);
            $fFin3 = date_format($fFin3 , 'Y-m-d');


            $nombre1="Baja";
            $nombre2="Alta";
            $nombre3="Media";

            /**
             * Inserción de datos de las temporadas en la base de datos
             */
            $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO temporada(nombre, fInicioTemp, fFinTemp, anio) VALUES (?,?,?,?);");
            $sentencia->bind_param("ssss", $nombre1, $fIn1, $fFin1, $anio);
            $sentencia->execute();

            $idTemp1=$sentencia->insert_id;

            $sentencia->bind_param("ssss", $nombre2, $fIn2, $fFin2, $anio);
            $sentencia->execute();

            $idTemp2=$sentencia->insert_id;

            $sentencia->bind_param("ssss", $nombre3, $fIn3, $fFin3, $anio);
            $sentencia->execute();

            $idTemp3=$sentencia->insert_id;

            //Comprobaciones

            $consulta="SELECT * FROM tipo";
            $this->objMetodos->realizarConsultas($consulta);
            if($this->objMetodos->comprobarSelect()>0){

                $prueba=$this->objMetodos->comprobarSelect();

                for ($i=0;$i<$prueba;$i++)
                {
                    $fila[$i]=$this->objMetodos->extraerFilas();
                }

                $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO temporadatipo(idTipo, idTemporada) VALUES (?,?);");

                for ($i=0;$i<$prueba;$i++)
                {
                    $sentencia->bind_param("ii", $fila[$i]["idTipo"], $idTemp1);
                    $sentencia->execute();

                    $sentencia->bind_param("ii", $fila[$i]["idTipo"], $idTemp2);
                    $sentencia->execute();

                    $sentencia->bind_param("ii", $fila[$i]["idTipo"], $idTemp3);
                    $sentencia->execute();
                }

                if($sentencia->affected_rows>0){
                    echo'

                <div class="col-12 confirmacion" id="mensajeConf">Error al introducir la temporada, inténtelo de nuevo</div>
               <script>

                    var el = document.getElementById("mensajeConf");
                    el.style.display="block";
                </script>';
                }
                header("Location:precio.php");
            }
            else
            {
                header("Location:anadirTipo.php");
            }

            }
        }

        function reserva(){

            if(isset($_POST["enviar3"])){

                /**
                 * Obtención de datos del usuario para incluirlos en el pdf
                 */

                $consulta="SELECT nombre, correo, tlfno FROM usuarios WHERE idUsuario=".$_SESSION["id"];

                $this->objMetodos->realizarConsultas($consulta);
                $fila=$this->objMetodos->extraerFilas();

                $precios=$_POST["precios"];

                $total=$_POST["total"];

                $num=$_POST["num"];

                $habitaciones=$_POST["habitaciones"];

                /**
                 * Creación de pdf
                 */


                require('fpdf/fpdf.php');
                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial','I',16);

                $pdf->Image('imagenes/logo3.PNG',70,10,-150);

                $texto1="Nombre: ".$fila[0]."\nCorreo: ".$fila[1]."\nTeléfono: ".$fila[2]."\nFecha de inicio de la reserva: ".$_POST["fIn"]."\nFecha de fin de la reserva: ".$_POST["fFin"] ;
                $pdf->SetXY(25, 50);
                $pdf->MultiCell(155,10,$texto1,1,"L");

                $pdf->SetFont('Arial','I',16);

                $pdf->SetXY(45, 120);
                $pdf->SetFillColor(1,29,64);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell(80,10,"Habitación",1,0,"C",true);
                $pdf->Cell(30,10,"Precio",1,1,"C",true);

                $pdf->SetTextColor(0,0,0);

                for($i=0;$i<$num;$i++){
                    $pdf->SetX(45);
                    $pdf->Cell(80,10,$habitaciones[$i],1,0,"C");
                    $pdf->Cell(30,10,$precios[$i]."€",1,1,"C");
                }

                $pdf->SetTextColor(255,255,255);
                $pdf->SetXY(45, 140+(10*$i));
                $pdf->Cell(80,10,"Precio Total",1,0,"C",true);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(30,10,$total."€",1,0,"C");
                /**
                 * Inserción de las reservas en la base de datos
                 */
                ob_end_clean();
                $pdf->Output("D","DatosReserva.pdf");

                $tfIn=explode("/", $_POST["fIn"]);
                $fIn=$tfIn[2]."-".$tfIn[1]."-".$tfIn[0];
                $fIn = date_create($fIn);
                $fIn = date_format($fIn , 'Y-m-d');

                $tFin=explode("/", $_POST["fFin"]);
                $fFin=$tFin[2]."-".$tFin[1]."-".$tFin[0];
                $fFin = date_create($fFin);
                $fFin = date_format($fFin , 'Y-m-d');

                $sentencia = $this->objMetodos->mysqli->prepare("INSERT INTO reservas(fInicio, fFin, idUsuario) VALUES (?,?,?);");
                $sentencia2=$this->objMetodos->mysqli->prepare("INSERT INTO reservashab(idReserva, numHabitacion, precioRes) VALUES (?,?,?);");

                /**
                 * Inserción de datos en la tabla reservas
                 */

                $sentencia->bind_param("ssi", $fIn, $fFin, $_SESSION["id"]);
                $sentencia->execute();

                $idReserva=$sentencia->insert_id;

                /**
                 * Inserción de datos en la tabla reservashab
                 */
                for($i=0;$i<$num;$i++){

                    $sentencia2->bind_param("isi", $idReserva, $habitaciones[$i], $precios[$i]);
                    $sentencia2->execute();
                }





            }

        }


}







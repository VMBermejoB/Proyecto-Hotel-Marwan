<?php
    include_once 'metodos.php';
class procesosApp
{
    function __construct()
    {

        $this->objMetodos = new metodos();
    }
/*
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
//        alert("Usuario o contraseña incorrectps");
        return false;
    }

    /*
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
        }
    }
    /*
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

        }
    }
    /*
     * Modificar contraseña
     */
    function modificarPass(){
        if(isset($_POST["enviar1"])){
            $pass = password_hash($_POST["pass2"], PASSWORD_DEFAULT);

            $sentencia = $this->objMetodos->mysqli->prepare("UPDATE usuarios SET password=? WHERE idUsuario=".$_SESSION["id"]);
            $sentencia->bind_param("s", $pass);
            $sentencia->execute();
        }
    }
    /*
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
}







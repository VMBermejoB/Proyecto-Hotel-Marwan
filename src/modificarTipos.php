<?php
    /*
     * Comprueba que se ha iniciado sesión con perfil trabajador
     */
    session_start();
    if($_SESSION["perfil"]!="t"){
        header("Location:disenio.php");
    }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Tipos de habitaciones</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
<nav class="row">
    <div class="col-1 d-flex align-items-center"><a href="consultarTemporadas.php">Temporada</a></div>
    <div class="col-1 d-flex align-items-center"><a href="mostrarTipo.php">Tipo</a></div>
    <div class="col-1 d-flex align-items-center"><a href="#">Habitaciones </a></div>
    <div class="col-1 d-flex align-items-center"><a href="#">Ofertas</a></div>
    <div class="col-1 d-flex align-items-center"><a href="#">Reservas</a></div>
    <div class="col-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto">
        <img src="imagenes/logo2.PNG">
    </div>
</nav>
<div class="containter" >
    <main class="row" id="contenedor">

        <article class="row">
            <div class="col-6 confirmacion" id="mensajeConf">
                <h3 id="mensaje"></h3>
            </div>
            <div class="col-12">
<?php
require_once  'metodos.php';
$objMetodos=new metodos();

    /*
     * Extrae el tipo de la tabla tipos según el tipo seleccionado para modificar
     */
$consulta=
    "
            SELECT * FROM tipo
            WHERE idTipo= ".$_GET["idTipo"]."
    ";
$objMetodos->realizarConsultas($consulta);
    /*
     * Comprueba si ha encontrado algún resultado para mostrar el formulario
     */
if ($objMetodos->comprobarSelect()>0)
{
    $fila=$objMetodos->extraerFilas();

       echo '              
                <form  onsubmit="return validacion()" action="#" method="post">
                <h2>Modificar tipo de habitación</h2>
                <hr>
                                   
                <input type="hidden" class="form-control" name="idTipo"  value="'.$_GET["idTipo"].'" required/></br>
          
                <div class="form-group">
                     <label for="nombreBD" class="sr-only">Nombre</label>
                     <input type="hidden" id="nombreBD" class="form-control" name="nombreBD" placeholder="nombre" value="'.$fila["nombre"].'" required/></br>
                </div>
                <div class="form-group">
                     <label for="nombre">Tipo de habitación</label>
                     <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Tipo  de habitacion" value="'.$fila["nombre"].'" required/></br>
                </div>
                <div class="form-group">
                     <label for="descripcion">Descripcion</label>
                     <input type="text" class="form-control" name="descripcion" placeholder="Descripcion" value="'.$fila["descripcion"].'" required/></br>
                </div>
                     <input type="submit" class="btn btn-primary" name="enviar" value="Enviar"/>';
       echo'</form>

            ';

       if(isset($_POST["enviar"])){
           /*
            * Realiza el update para modificar los datos del tipo seleccionado
            */
           $consulta=
               "
                    UPDATE tipo 
                    SET nombre='".$_POST["nombre"]."',descripcion='".$_POST["descripcion"]."'
                    WHERE idTipo=".$_POST["idTipo"].";
               ";

           $objMetodos->realizarConsultas($consulta);

           if($objMetodos->comprobar()<=0){
               echo'<script>
                        document.getElementById("mensaje").innerHTML="Error al modificar el tipo, intentelo de nuevo más tarde";
                        var el = document.getElementById("mensajeConf");
                        el.style.display="block";
                    </script>';
           }
           else
            {
               echo'<script>
                        document.getElementById("mensaje").innerHTML="Tipo modificado correctamente";
                        var el = document.getElementById("mensajeConf");
                        el.style.display="block";
                    </script>
                ';
           }
       }


}
?>
            </div>
        </article>
    </main>
</div>
<script>
    /*
    * Valida los campos del formulario
    */
    function validacion()
    {
        let nombre = document.getElementById("nombre").value;
        let nombreBD = document.getElementById("nombreBD").value;
        /*
        * Comprueba si el nombre inroducido en el formulario coincide con alguno de la base de datos
        */
        if(nombre==nombreBD)
        {
            window.location="mostrarTipo.php";
            return true
        }
        else
        {
            let nombreBD = document.getElementById("nombreBD").value;
            let nombre = document.getElementById("nombre").value;
            var val=0;
            $.ajax({
                url: "comprobarTipo.php?nombre="+nombre,
                method: "get",
                async: false,
                dataType: "text",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        val=1;
                        alert("El tipo de habitacion "+nombre+" ya existe, inserte otro distinto");
                }
            });

            if(val==1){
                return false;
            }
            else
            {
                return true
            }
        }
    }
</script>
</body>
</html>
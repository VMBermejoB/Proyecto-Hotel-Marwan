<?php
require_once  'metodos.php';
$objMetodos=new metodos();

if(isset($_GET["del"]))
{
    $id=$_GET['del'];
    $consulta2=
        "
            DELETE  
            FROM habitaciones
            WHERE numHabitacion=".$id.";
       ";
    $objMetodos->realizarConsultas($consulta2);
    header("location:mostrarHabitaciones.php");
}
?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>Habitaciones</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilo.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>

<nav class="row">
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="consultarTemporadas.php">Temporada</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="mostrarTipo.php">Tipos</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Habitaciones </a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="#">Ofertas</a></div>
    <div class="col-12 col-sm-1 d-flex align-items-center"><a href="cerrarsesion.php">Cerrar Sesion</a></div>
    <div id="logo" class="col-auto offset-auto d-none d-sm-block">
        <img src="imagenes/logo2.PNG">
    </div>
</nav>

    <main class="row" id="contenedor">
        <article class="row">
            <div class="row">
<?php
$consulta=
       "
            SELECT numHabitacion,planta,capacidad,dimesiones,t.nombre AS tipo,adaptada 
            FROM habitaciones h
	            INNER JOIN tipo t
	            ON t.idTipo=h.idTipo
       ";
   $objMetodos->realizarConsultas($consulta);
   if ($objMetodos->comprobarSelect()>0)
   {
       echo
       '

        
            
          <table class="table table-striped table-hover" >
            <thead>
                <tr>
                  <th scope="col">Numero de Habitación</th>
                  <th scope="col">planta</th>
                  <th scope="col">capacidad</th>
                  <th scope="col">dinensiones</th>
                   <th scope="col">Tipo</th>
                   <th scope="col">Adaptada</th>
                  <th scope="col">Modificar</th>
                  <th scope="col">Eliminar</th>
                </tr>
            </thead>
            
       ';
            for($i=0;$i<$fila=$objMetodos->extraerFilas();$i++){
    echo'   
           <tbody class="table-striped">
              <tr>
                <th scope="row">'.$fila["numHabitacion"].'</th>
                <td>'.$fila["planta"].'</td>
                <td>'.$fila["capacidad"].'</td>
                <td>'.$fila["dimesiones"].'</td>
                <td>'.$fila["tipo"].'</td>
    ';            if($fila["adaptada"]==1)
                {
                   echo '<td>Si</td>';
                }
                else
                {
                    echo '<td>No</td>';
                }
echo'         
                <td><a href="modificarHabitaciones.php?numHabitacion='.$fila["numHabitacion"].'">Modificar habitación '.$fila["numHabitacion"].'</a></td>
                <td><a href="#" onclick="preguntar('.$fila["numHabitacion"].')">Eliminar habitación '.$fila["numHabitacion"].'</a></td>
              </tr>
       ';
           }
   echo '    
           </tbody>
        </table>
   
       ';
   }
   else
   {

           echo
           '
       
          <table class="table table-striped table-hover" >
           <thead>
                <tr>
                  <th scope="col">Numero de Habitación</th>
                  <th scope="col">Planta</th>
                  <th scope="col">Capacidad</th>
                  <th scope="col">Dimensiones</th>
                   <th scope="col">Tipo</th>
                   <th scope="col">Adaptada</th>
                  <th scope="col">Modificar</th>
                  <th scope="col">Eliminar</th>
                </tr>
            </thead>
           <tbody class="table-striped">
              <tr>
                <th scope="col">No hay habitaciones añadidas</th>
              </tr>
           </tbody>
          </table>
       ';

   }
?>
    </div>
</article>
</main>

</body>
</html>
<script>
    function preguntar(id)
    {
        if(confirm('¿Estás seguro que deseas borrar?'))
        {
            window.top.location="mostrarHabitaciones.php?del="+id;
        }
    }
</script>
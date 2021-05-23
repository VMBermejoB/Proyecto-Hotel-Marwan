<?php
    require_once 'metodos.php';
    $objMetodos = new metodos();

    $tipo=$_GET["tipo"];
    $adaptada=$_GET["adaptada"];

/*
 * Pasar la cadena que contiene las haboitaciones que ya ha encontrado como libres a array
 */
    $ocupadas=explode("-", $_GET["ocupadas"]);

/*
 * Conversión a formato fecha
 */
    $tfIn=explode("/", $_GET["fIn"]);
    $fIn=$tfIn[2]."-".$tfIn[1]."-".$tfIn[0];
    $fIn = date_create($fIn);
    $fIn = date_format($fIn , 'Y-m-d');


    $tfFin=explode("/", $_GET["fFin"]);
    $fFin=$tfFin[2]."-".$tfFin[1]."-".$tfFin[0];
    $fFin = date_create($fFin);
    $fFin = date_format($fFin , 'Y-m-d');

/*
 * Obtener todas las habitaciones del tipo seleccionado
 */
    if($adaptada==0){
        $consulta="SELECT numHabitacion FROM habitaciones WHERE idTipo=".$tipo;
    }
    else
    {
        $consulta="SELECT numHabitacion FROM habitaciones WHERE idTipo=".$tipo." AND adaptada=1";
    }


    $objMetodos->realizarConsultas($consulta);

    if($objMetodos->comprobarSelect()>0){
        $numHab=$objMetodos->comprobarSelect();
        for($i=0;$i<$numHab;$i++){
            $habitaciones[$i]=$objMetodos->extraerFilas();
        }

/*
 * Se comprueba si las habitaciones tienen reservas hechas una a una
 */
        for($i=0;$i<$numHab;$i++){

            $consulta="SELECT idReserva FROM reservashab WHERE numHabitacion=".$habitaciones[$i]["numHabitacion"];

            $objMetodos->realizarConsultas($consulta);

            $numRes=$objMetodos->comprobarSelect();

            if($objMetodos->comprobarSelect()>0){
                for($j=0;$j<$numRes;$j++){
                    $reservas[$j]=$objMetodos->extraerFilas();
                }

                $contFechas=0;
/*
 * Se buscan todas las reservas de la habitación
 */

                for($k=0;$k<$numRes;$k++){

                    $consulta="SELECT fInicio, fFin FROM reservas WHERE idReserva=".$reservas[$k]["idReserva"];

                    $objMetodos->realizarConsultas($consulta);

                    $numFechas=$objMetodos->comprobarSelect();

                    if($objMetodos->comprobarSelect()>0){
                        for($l=0;$l<$numFechas;$l++){
                            $fechas[$l]=$objMetodos->extraerFilas();
                        }
/*
 * Se comprueba con cada una de las reservas si las fechas coinciden con las fechas introducidas por el usuario
 */
                        for($m=0;$m<$numFechas;$m++){

                            $fecha = date_create($fIn);
                           $fecha = date_format($fecha , 'Y-m-d');

                            while($fecha<=$fFin && ($fecha<$fechas[$m]["fInicio"] || $fecha>$fechas[$m]["fFin"])){
                                $fecha=date("Y-m-d",strtotime($fecha."+ 1 days"));
                            }

                            if($fecha>$fFin){
/*
 * Comprobar si la habitación que se ha encontraxdo libre ya se ha encontrado anteriormente
 */
                                $n=0;
                                for($n=0;$n<sizeof($ocupadas)&&$habitaciones[$i]["numHabitacion"]!=$ocupadas[$n];$n++);

                                if($n>=sizeof($ocupadas)){
                                    $contFechas++;
                                }
                            }
                        }
                    }
                }
/*
 * Devuelve el número de habitación libre encontrada
 */
                if($contFechas==$numRes){
                    echo $habitaciones[$i]["numHabitacion"];
                    exit;
                }

            }
            else
            {
                echo $habitaciones[$i]["numHabitacion"];
                exit;
            }
        }
/*
 * Devuelve 0 si no se ha encontrado ninguna habitación libre
 */
        echo "0";

    }

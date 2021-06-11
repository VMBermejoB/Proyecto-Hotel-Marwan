<?php
    require_once 'metodos.php';
    $objMetodos = new metodos();
/**
 * Obiene el tipo de habitación
 */
    $tipo=$_GET["tipo"];
/**
 * Obtiene si la habitación que se quiere comprobar es adaptada o no
 */
    $adaptada=$_GET["adaptada"];
/**
 * Recoge el número de habitaciones adaptadas que se quiee
 */
    $numAdaptadas=$_GET["numAdaptadas"];
/**
 * Contador para el número de habitaciones adaptadas que ya se han encontrado
 */
    $contAdaptadas=0;

/**
 * Pasar la cadena que contiene las habitaciones que ya ha encontrado como libres a array
 */
    $ocupadas=explode("-", $_GET["ocupadas"]);

/**
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

/**
 * Obtener todas las habitaciones del tipo seleccionado
 */


    $consulta="SELECT anio FROM temporada WHERE anio=".$tfFin[2];

    $objMetodos->realizarConsultas($consulta);

    if($objMetodos->comprobarSelect()>0) {

    if($adaptada==0){
        $consulta="SELECT numHabitacion FROM habitaciones WHERE idTipo=".$tipo;
    }
    else
    {
        /**
         * Para las habitaciones adaptadas, comprueba si ya se ha llegado al número de adaptadas que quiere el usuario, en caso de que
         * se haya completado el número de adaptadas que quiere, significa que las restantes que se quieren comprobar ya son habitaciones
         * no adaptadas
         */
        for($i=0;$i<sizeof($ocupadas);$i++){

            $consulta="SELECT adaptada FROM habitaciones WHERE numHabitacion=".$ocupadas[$i];
            $objMetodos->realizarConsultas($consulta);
            if($objMetodos->comprobarSelect()>0){
                $fila=$objMetodos->extraerFilas();
                if($fila["adaptada"]==1){
                    $contAdaptadas++;
                }
            }

        }

        if($contAdaptadas==$numAdaptadas){
            $consulta="SELECT numHabitacion FROM habitaciones WHERE idTipo=".$tipo;
        }
        else
        {
            $consulta="SELECT numHabitacion FROM habitaciones WHERE idTipo=".$tipo." AND adaptada=1";
        }

    }


    $objMetodos->realizarConsultas($consulta);

    if($objMetodos->comprobarSelect()>0){
        $numHab=$objMetodos->comprobarSelect();
        for($i=0;$i<$numHab;$i++){
            $habitaciones[$i]=$objMetodos->extraerFilas();
        }

/**
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
/**
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
/**
 * Se comprueba con cada una de las reservas si las fechas coinciden con las fechas introducidas por el usuario
 */
                        for($m=0;$m<$numFechas;$m++){

                            $fecha = date_create($fIn);
                           $fecha = date_format($fecha , 'Y-m-d');

                            while($fecha<$fFin && (($fecha<$fechas[$m]["fInicio"] || $fFin == $fechas[$m]["fInicio"]) || $fecha>=$fechas[$m]["fFin"])){
                                $fecha=date("Y-m-d",strtotime($fecha."+ 1 days"));
                            }

                            if($fecha>=$fFin){
/**
 * Comprobar si la habitación que se ha encontrado libre ya se ha encontrado anteriormente
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

/**
 * Devuelve el número de habitación libres encontrada
 */

                if($contFechas==$numRes){
                    echo $habitaciones[$i]["numHabitacion"];
                    exit;
                }

            }
            else
            {
                for($n=0;$n<sizeof($ocupadas)&&$habitaciones[$i]["numHabitacion"]!=$ocupadas[$n];$n++);

                if($n>=sizeof($ocupadas)){
                    echo $habitaciones[$i]["numHabitacion"];
                    exit;
                }

            }
        }
/**
 * Devuelve 0 si no se ha encontrado ninguna habitación libre
 */
        echo "0";

        }
    }
    else
    {
        echo "0";
    }

<?php
/**
 * Comprobar si la oferta que se desea realizar se encuentra en una fecha libre para el tipo seleccionado
 */

 require_once 'metodos.php';
    $objConexion=new metodos();

    $tipo=$_GET["tipo"];
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
 * Comprobar si se accede a este archivo desde la pñagina de modificar
 */

    $consulta="SELECT o.idTipo, o. idOferta, o.fInicio, o.fFin 
                FROM oferta o   
                WHERE o.idTipo=".$tipo;

    $objConexion->realizarConsultas($consulta);

    if($objConexion->comprobarSelect()>0){

        $cont=0;

        while($fila=$objConexion->extraerFilas()){

            if(isset($_GET["tipoant"]) && isset($_GET["ofertaant"])){
                if($fila["idOferta"]==$_GET["ofertaant"] && $fila["idTipo"]==$_GET["tipoant"]){
                    $cont++;
                }
                else
                {
                    $fecha = date_create($fIn);
                    $fecha = date_format($fecha , 'Y-m-d');

                    while($fecha<=$fFin && ($fecha<$fila["fInicio"] || $fecha>$fila["fFin"])){
                        $fecha=date("Y-m-d",strtotime($fecha."+ 1 days"));
                    }

                    if($fecha>$fFin){
                        $cont++;
                    }
                }
            }
            else
            {
                $fecha = date_create($fIn);
                $fecha = date_format($fecha , 'Y-m-d');

                while($fecha<=$fFin && ($fecha<$fila["fInicio"] || $fecha>$fila["fFin"])){
                    $fecha=date("Y-m-d",strtotime($fecha."+ 1 days"));
                }

                if($fecha>$fFin){
                    $cont++;
                }
            }

        }

        if($cont>=$objConexion->comprobarSelect()){
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    else
    {
        echo 1;
    }
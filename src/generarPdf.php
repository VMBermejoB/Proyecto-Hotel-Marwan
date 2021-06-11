<?php

$reserva=$_GET["reserva"];

/**
 * Extraigo todos los datos de la reserva correspondiente de la base de datos para generar el pdf
 */

$consulta="SELECT u.nombre, u.correo, u.tlfno, r.fInicio, r.fFin, rh.numHabitacion, rh.precioRes FROM reservas r INNER JOIN usuarios u ON r.idUsuario = u.idUsuario INNER JOIN reservasHab rh ON r.idReserva = rh.idReserva WHERE r.idReserva=".$reserva;

    require_once 'metodos.php';
    $objMetodos = new metodos();

    $objMetodos->realizarConsultas($consulta);
    $num=$objMetodos->comprobarSelect();

    for($i=0;$i<$num;$i++){
        $fila[$i]=$objMetodos->extraerFilas();
    }

    $tfIn=explode("-", $fila[0]["fInicio"]);
    $fInicio=$tfIn[2]."/".$tfIn[1]."/".$tfIn[0];

    $tfFin=explode("-", $fila[0]["fFin"]);
    $fFin=$tfFin[2]."/".$tfFin[1]."/".$tfFin[0];

/**
 * Generación de Pdf
 */

    require('fpdf/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','I',16);
    $pdf->Image('imagenes/logo3.PNG',70,10,-150);


$texto1="Nombre: ".$fila[0]["nombre"]."\nCorreo: ".$fila[0]["correo"]."\nTeléfono: ".$fila[0]["tlfno"]."\nFecha de inicio de la reserva: ".$fInicio."\nFecha de fin de la reserva: ".$fFin ;
$pdf->SetXY(25, 50);
$pdf->MultiCell(155,10,$texto1,1,"L");

$pdf->SetFont('Arial','I',16);

$pdf->SetXY(45, 120);
$pdf->SetFillColor(1,29,64);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(80,10,"Habitación",1,0,"C",true);
$pdf->Cell(30,10,"Precio",1,1,"C",true);

$pdf->SetTextColor(0,0,0);

$total=0;

for($i=0;$i<$num;$i++){
    $pdf->SetX(45);
    $pdf->Cell(80,10,$fila[$i]["numHabitacion"],1,0,"C");
    $pdf->Cell(30,10,$fila[$i]["precioRes"]."€",1,1,"C");
    $total=$total+$fila[$i]["precioRes"];
}

$pdf->SetTextColor(255,255,255);
$pdf->SetXY(45, 140+(10*$i));
$pdf->Cell(80,10,"Precio Total",1,0,"C",true);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(30,10,$total."€",1,0,"C");

ob_end_clean();
$pdf->Output("D","DatosReserva.pdf");

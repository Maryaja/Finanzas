
<?php
require 'db/conexion.php';
require 'clases/ReporteBalance.php';
require 'fpdf/fpdf.php'; 


session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}


$reporte = new ReporteBalance($db);
$totalEntradas = $reporte->obtenerTotalEntradas();
$totalSalidas = $reporte->obtenerTotalSalidas();
$balance = $reporte->obtenerBalance();
$entradas = $reporte->obtenerEntradas();
$salidas = $reporte->obtenerSalidas();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Balance Financiero', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);
$pdf->Cell(0, 10, 'Total de Entradas: $' . number_format($totalEntradas, 2), 0, 1);
$pdf->Cell(0, 10, 'Total de Salidas: $' . number_format($totalSalidas, 2), 0, 1);
$pdf->Cell(0, 10, 'Balance: $' . number_format($balance, 2), 0, 1);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Entradas', 0, 1);

$pdf->SetFont('Arial', '', 10);
foreach ($entradas as $entrada) {
 $pdf->Cell(0, 8, "{$entrada['fecha']} - {$entrada['tipo']} - \$" . number_format($entrada['monto'], 2), 0, 1);
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Salidas', 0, 1);

$pdf->SetFont('Arial', '', 10);
foreach ($salidas as $salida) {
 $pdf->Cell(0, 8, "{$salida['fecha']} - {$salida['tipo']} - \$" . number_format($salida['monto'], 2), 0, 1);
}

$pdf->Output('D', 'balance_financiero.pdf');
exit;
?>

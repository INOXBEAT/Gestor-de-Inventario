<?php
require_once __DIR__ . '/vendor/autoload.php';
require 'vendor/autoload.php';

use FPDF as GlobalFPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Fpdf\Fpdf;

function generarExcel($productos) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Configurar encabezados de la tabla
    $sheet->fromArray([
        ['ID', 'Nombre', 'Descripción', 'Cantidad', 'Precio']
    ], NULL, 'A1');

    // Llenar la tabla con los datos de los productos
    $sheet->fromArray($productos, NULL, 'A2');

    // Configurar la respuesta para descargar el archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="listado_productos.xlsx"');
    header('Cache-Control: max-age=0');
    
    // Escribir el archivo de Excel
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}

function generarPDF($productos) {
    $pdf = new GlobalFPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Configurar el encabezado del PDF
    $pdf->Cell(40, 10, 'ID', 1);
    $pdf->Cell(40, 10, 'Nombre', 1);
    $pdf->Cell(60, 10, 'Descripción', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(30, 10, 'Precio', 1);
    $pdf->Ln();

    // Llenar el contenido del PDF con los datos de los productos
    foreach ($productos as $producto) {
        $pdf->Cell(40, 10, $producto['id'], 1);
        $pdf->Cell(40, 10, $producto['nombre'], 1);
        $pdf->Cell(60, 10, $producto['descripcion'], 1);
        $pdf->Cell(30, 10, $producto['cantidad'], 1);
        $pdf->Cell(30, 10, $producto['precio'], 1);
        $pdf->Ln();
    }

    // Configurar la respuesta para descargar el archivo
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="listado_productos.pdf"');
    header('Cache-Control: max-age=0');
    
    // Salida del PDF
    $pdf->Output();
}

// Obtener los productos (esto debería estar en otro archivo)
$productos = [
    ['id' => 1, 'nombre' => 'Producto 1', 'descripcion' => 'Descripción del producto 1', 'cantidad' => 10, 'precio' => 100],
    ['id' => 2, 'nombre' => 'Producto 2', 'descripcion' => 'Descripción del producto 2', 'cantidad' => 20, 'precio' => 200],
    ['id' => 3, 'nombre' => 'Producto 3', 'descripcion' => 'Descripción del producto 3', 'cantidad' => 30, 'precio' => 300],
    // Agrega más productos según sea necesario
];

// Procesar la solicitud de generación de reporte
if (isset($_GET['formato']) && $_GET['formato'] === 'excel') {
    generarExcel($productos);
} elseif (isset($_GET['formato']) && $_GET['formato'] === 'pdf') {
    generarPDF($productos);
} else {
    echo "Formato de reporte no válido";
}
?>

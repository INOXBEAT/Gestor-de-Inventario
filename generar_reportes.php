<?php 
require_once __DIR__ . '/vendor/autoload.php';
include 'conexion.php';


use FPDF as GlobalFPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Fpdf\Fpdf;

function obtenerProductosDesdeBaseDeDatos() {
    // Aquí debes incluir la lógica para conectarte a la base de datos y obtener los datos de los productos
    // Por ejemplo, puedes usar PDO para conectarte a la base de datos y ejecutar una consulta SQL
    // Asumiré que tienes una tabla llamada 'productos' con campos 'id', 'nombre', 'descripcion', 'cantidad' y 'precio'

    // Ejemplo con PDO
    $dsn = 'mysql:host=localhost;dbname=inventario';
    $usuario = 'root';
    $contrasena = '';

    try {
        $conexion = new PDO($dsn, $usuario, $contrasena);
        $consulta = $conexion->query("SELECT * FROM productos");
        $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    } catch (PDOException $e) {
        echo 'Error al conectarse a la base de datos: ' . $e->getMessage();
        return false;
    }
}

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
    $pdf = new GlobalFPDF('L', 'mm', 'Letter');
    $pdf->AddPage();
    $pdf->SetMargins(10,10,10);

    // Configurar el encabezado del PDF
    $pdf->SetFont('Arial', 'B', 12);
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


// Obtener los productos desde la base de datos
$productos = obtenerProductosDesdeBaseDeDatos();

// Verificar si se obtuvieron los productos correctamente
if ($productos !== false) {
    // Procesar la solicitud de generación de reporte
    if (isset($_GET['formato']) && $_GET['formato'] === 'excel') {
        generarExcel($productos);
    } elseif (isset($_GET['formato']) && $_GET['formato'] === 'pdf') {
        generarPDF($productos);
    } else {
        echo "Formato de reporte no válido";
    }
} else {
    // Manejar el caso en que no se pudieron obtener los productos
    echo "Error al obtener los productos desde la base de datos";

    echo "Error al obtener los productos desde la base de datos";
}
?>
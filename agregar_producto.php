<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Verifica si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    // Prepara la consulta SQL para insertar el nuevo producto
    $query = "INSERT INTO productos (nombre, descripcion, cantidad, precio) VALUES ('$nombre', '$descripcion', $cantidad, $precio)";
    // Ejecuta la consulta
    if (mysqli_query($conexion, $query)) {
        $mensaje = "Producto agregado correctamente";
        // Muestra un mensaje de alerta en JavaScript
        echo "<script>alert('Producto agregado correctamente');</script>";
    } else {
        echo "Error al agregar el producto: " . mysqli_error($conexion);
    }
}
// Redirecciona de nuevo al index.php después de agregar el producto
header("Location: productos.php?mensaje=" . $mensaje);
exit();
?>
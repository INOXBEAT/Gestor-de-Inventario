<?php
include 'conexion.php';

// Verificar si se ha enviado un ID válido para eliminar
if(isset($_POST['id']) && !empty($_POST['id'])) {
    $id_producto = $_POST['id'];

    // Preparar la consulta para eliminar el producto
    $query = "DELETE FROM productos WHERE id = $id_producto";

    // Ejecutar la consulta
    if(mysqli_query($conexion, $query)) {
        // Redireccionar a la página de productos después de eliminar
        header("Location: productos.php");
        exit();
    } else {
        // Si hay un error al eliminar, mostrar mensaje de error
        echo "Error al eliminar el producto: " . mysqli_error($conexion);
    }
} else {
    // Si no se recibe un ID válido, mostrar mensaje de error
    echo "ID de producto no válido";
}

// Cerrar la conexión
mysqli_close($conexion);
?>

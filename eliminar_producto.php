<?php
include 'conexion.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM productos WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al eliminar el producto: " . mysqli_error($conexion);
    }
} else {
    echo "ID de producto no válido";
}
?>

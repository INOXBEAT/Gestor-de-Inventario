<?php
include 'conexion.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM productos WHERE id = $id";

    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $producto = mysqli_fetch_assoc($resultado);
    } else {
        echo "Producto no encontrado";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];

        $query = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', cantidad = $cantidad, precio = $precio WHERE id = $id";

        if (mysqli_query($conexion, $query)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($conexion);
        }
    }
} else {
    echo "ID de producto no válido";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>
        
        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" required>
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" id="descripcion" value="<?php echo $producto['descripcion']; ?>">
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" value="<?php echo $producto['cantidad']; ?>" required>
            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" value="<?php echo $producto['precio']; ?>" required>
            <button type="submit">Actualizar Producto</button>
        </form>
    </div>
</body>
</html>

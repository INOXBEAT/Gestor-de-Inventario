<?php
include 'conexion.php';
include 'header.php';

// Variable para almacenar el mensaje de alerta
$alert_message = '';

// Verificar si se ha enviado un formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un ID válido para editar
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];

        // Realizar la actualización del producto en la base de datos
        $query = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', cantidad=$cantidad, precio=$precio WHERE id=$id";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            // Asignar el mensaje de éxito
            $alert_message = 'Producto actualizado correctamente';
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($conexion);
        }
    } else {
        // Si no se recibe un ID válido, mostrar mensaje de error
        echo "ID de producto no válido";
    }
}

// Obtener los datos del producto a editar si no se ha enviado un formulario de actualización
if ($_SERVER["REQUEST_METHOD"] != "POST" && isset($_GET['id']) && !empty($_GET['id'])) {
    $id_producto = $_GET['id'];

    $query = "SELECT * FROM productos WHERE id = $id_producto";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $producto = mysqli_fetch_assoc($resultado);
    } else {
        // Si no se encuentra el producto con el ID especificado, mostrar mensaje de error
        echo "No se encontró el producto con el ID especificado";
    }
}

// Cerrar la conexión
mysqli_close($conexion);
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
        <?php if (!empty($alert_message)) : ?>
            <script>
                // Mostrar alerta en JavaScript con el mensaje de actualización
                alert("<?php echo $alert_message; ?>");
                // Redirigir a la lista de productos después de mostrar el mensaje
                window.location.href = "productos.php";
            </script>
        <?php endif; ?>
        <form action="editar_producto.php" method="POST">
            <?php if (isset($producto)) : ?>
                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>"><br>
                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" id="descripcion" value="<?php echo $producto['descripcion']; ?>"><br>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" value="<?php echo $producto['cantidad']; ?>"><br>
                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio" value="<?php echo $producto['precio']; ?>"><br>
                <!-- Aquí puedes agregar más campos para editar otros atributos del producto -->
                <button type="submit">Actualizar Producto</button>
            <?php endif; ?>
        </form>

    </div>
</body>

</html>

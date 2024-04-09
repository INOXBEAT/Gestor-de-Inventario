<?php 
include 'conexion.php'; 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="container">
        <h1>Agregar Producto</h1>

        <form action="agregar_producto.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" id="descripcion">
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" required>
            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" required>
            <button type="submit">Agregar Producto</button>
        </form>
    </div>

<?php include 'footer.php';?>
</body>

</html>
<?php 
include 'conexion.php';

// Verificar si hay una conexión válida
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Realizar la consulta para obtener los productos
$query = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $query);

// Verificar si hay resultados
if (mysqli_num_rows($resultado) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Productos</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="container">
            <h1>Lista de Productos</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Iterar sobre los resultados y mostrarlos en la tabla
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>
                                <td>{$fila['nombre']}</td>
                                <td>{$fila['descripcion']}</td>
                                <td>{$fila['cantidad']}</td>
                                <td>{$fila['precio']}</td>
                                <td>
                                    <a href='editar_producto.php?id={$fila['id']}'>Editar</a>
                                    <a href='eliminar_producto.php?id={$fila['id']}'>Eliminar</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>
<?php 
} else {
    // Si no hay productos en la base de datos
    echo "No hay productos en la base de datos.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>

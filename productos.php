<?php
include 'conexion.php';
include 'header.php';

// Verificar si hay una conexión válida
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Realizar la consulta para obtener los productos
$query = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $query);

// Verificar si hay un mensaje de éxito en la URL
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';

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
                // Mostrar los productos
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['descripcion']}</td>
                        <td>{$fila['cantidad']}</td>
                        <td>{$fila['precio']}</td>
                        <td class='acciones'>
                            <form action='editar_producto.php' method='GET'>
                                <input type='hidden' name='id' value='{$fila['id']}'>
                                <button type='submit'>Editar</button>
                            </form>
                            <form action='eliminar_producto.php' method='POST' onsubmit='return confirm(\"¿Estás seguro de querer eliminar este producto?\")'>
                                <input type='hidden' name='id' value='{$fila['id']}'>
                                <button type='submit'>Eliminar</button>
                            </form>
                        </td>
                    </tr>";
                }

                // Liberar memoria
                mysqli_free_result($resultado);
                ?>
            </tbody>
        </table>
    </div>

<?php 
} else {
    // Mostrar mensaje si no hay productos
    echo "<div class='container'><p>No hay productos disponibles.</p></div>";
}

// Cerrar la conexión
mysqli_close($conexion);

include 'footer.php'; 
?>

</body>

</html>

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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#agregar_producto").click(function(e) {
        e.preventDefault(); // Evitar que el formulario se envíe automáticamente

        // Obtener valores de los campos
        var nombre = $("#nombre").val();
        var descripcion = $("#descripcion").val();
        var cantidad = $("#cantidad").val();
        var precio = $("#precio").val();

        // Verificar si todos los campos están llenos
        if (nombre !== '' && cantidad !== '' && precio !== '') {
          // Enviar el formulario
          $("form").submit();
          // Mostrar mensaje de éxito
          alert("Producto agregado correctamente");
        } else {
          // Mostrar mensaje de error si falta algún campo
          alert("Por favor, complete todos los campos antes de agregar el producto.");
        }
      });
    });
  </script>
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
      <button type="submit" id="agregar_producto">Agregar Producto</button>
    </form>
  </div>

  <?php include 'footer.php'; ?>
</body>

</html>

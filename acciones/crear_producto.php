<?php


include("../config/conexion.php");
$categorias = $conn->query("SELECT * FROM categorias");


?>



<!DOCTYPE html>
<html>

<head>
    <title>Crear producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    

    <div class="container mt-4">
        <h2>Crear nuevo producto</h2>

        <form action="guardar_producto.php" method="POST">

            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>

            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>

            <label>Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>

            <label>Stock</label>
            <input type="number" name="stock" class="form-control" required>

            <label>Seleccione Categoria</label>
            <select name="id_categoria" class="form-control" required>
                <?php while ($cat = $categorias->fetch_assoc()): ?>
                    <option value="<?= $cat['id_categoria'] ?>">
                        <?= $cat['nombre'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Imagen URL</label>
            <input type="text" name="imagen_url" class="form-control" required>

            <br>
            <button type="submit" class="btn btn-success">Guardar</button>

        </form>
    </div>

</body>

</html>
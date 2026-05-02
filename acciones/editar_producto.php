<?php
include("../config/conexion.php");

// Comprobar que viene el id
if (!isset($_GET['id'])) {
    die("ID no recibido");
}

$id = $_GET['id'];

// IMPORTANTE: usa el nombre real de tu columna en la BD
$sql = "SELECT * FROM productos WHERE id_producto = $id";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

$producto = $resultado->fetch_assoc();
?>

<head>
    <title>Editar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">

    <!-- FORMULARIO PRINCIPAL -->
    <form action="../acciones/actualizar_producto.php" method="POST">

        <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" class="form-control">

        <label>Precio</label>
        <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" class="form-control">

        <label>Stock</label>
        <input type="number" name="stock" value="<?= $producto['stock'] ?>" class="form-control">

        <label>Descripcion</label>
        <input type="text" name="descripcion" value="<?= $producto['descripcion'] ?>" class="form-control">

        <label>Imagen principal URL</label>
        <input type="text" name="imagen_url" value="<?= $producto['imagen_url'] ?>" class="form-control">

        <br>
        <button type="submit" class="btn btn-success">Guardar cambios</button>
    </form>


    <!-- ========================= -->
    <!-- GESTIÓN DE IMÁGENES -->
    <!-- ========================= -->

    <hr>
    <h5>Imágenes del producto (carousel)</h5>

    <?php
    $sql_imgs = "SELECT * FROM producto_imagenes WHERE id_producto = $id";
    $imagenes = $conn->query($sql_imgs);
    ?>

    <ul class="list-group mb-3">
        <?php while ($img = $imagenes->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <img src="<?= $img['imagen_url'] ?>" width="80">

                <form action="../acciones/eliminar_imagen.php" method="POST">
                    <input type="hidden" name="id_imagen" value="<?= $img['id_imagen'] ?>">
                    <button class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>


    <!-- FORMULARIO AÑADIR IMAGEN (SEPARADO) -->
    <form action="../acciones/agregar_imagen.php" method="POST">
        <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

        <label>Nueva imagen (URL)</label>
        <input type="text" name="imagen_url" class="form-control">

        <button class="btn btn-primary mt-2">Añadir imagen</button>
    </form>

</div>
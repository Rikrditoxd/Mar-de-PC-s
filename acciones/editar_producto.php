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
    <form action="../acciones/actualizar_producto.php" method="POST">

    <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

    <label>Nombre</label>
    <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" class="form-control">

    <label>Precio</label>
    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" class="form-control">

    <label>Stock</label>
    <input type="number" name="stock" value="<?= $producto['stock'] ?>" class="form-control">

    

    <label>Imagen URL</label>
    <input type="text" name="imagen_url" value="<?= $producto['imagen_url'] ?>" class="form-control">

    <br>
    <button type="submit" class="btn btn-success">Guardar cambios</button>

</form>
</div>

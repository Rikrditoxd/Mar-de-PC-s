<?php
include("config/conexion.php");

if (!isset($_GET['id'])) {
    die("Producto no encontrado");
}

$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id_producto = $id";
$resultado = $conn->query($sql);
$producto = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $producto['nombre'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">

    <div class="row">
        <div class="col-md-6">
            <img src="<?= $producto['imagen_url'] ?>" class="img-fluid">
        </div>

        <div class="col-md-6">
            <h1><?= $producto['nombre'] ?></h1>
            <p><?= $producto['descripcion'] ?></p>
            <h3><?= $producto['precio'] ?> €</h3>
            <p>Stock: <?= $producto['stock'] ?></p>

            <button class="btn btn-primary">Añadir al carrito</button>
        </div>
    </div>

</div>

</body>
</html>
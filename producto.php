<?php
session_start();
include("config/conexion.php");

if (!isset($_GET['id'])) {
    die("Producto no encontrado");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM productos WHERE id_producto = $id";
$resultado = $conn->query($sql);
$producto = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title><?= $producto['nombre'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include("includes/navbar.php"); ?>

    <div class="container mt-5">

        <div class="row">

            <!-- GALERÍA -->
            <div class="col-md-6">

                <?php
                $sql_imgs = "SELECT * FROM producto_imagenes WHERE id_producto = $id";
                $imagenes = $conn->query($sql_imgs);

                $imgs_array = [];

                if ($imagenes && $imagenes->num_rows > 0) {
                    while ($img = $imagenes->fetch_assoc()) {
                        $imgs_array[] = $img['imagen_url'];
                    }
                }

                // fallback imagen principal
                if (count($imgs_array) == 0) {
                    $imgs_array[] = $producto['imagen_url'];
                }
                ?>

                <!-- CAROUSEL -->
                <div id="carouselProducto" class="carousel slide mb-3" data-bs-ride="carousel">

                    <div class="carousel-inner">

                        <?php foreach ($imgs_array as $index => $img): ?>
                            <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                                <img src="<?= $img ?>" class="d-block w-100 main-image">
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <!-- CONTROLES -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>


            </div>

            <!-- INFO PRODUCTO -->
            <div class="col-md-6">

                <h1><?= $producto['nombre'] ?></h1>
                <p><?= $producto['descripcion'] ?></p>
                <h3><?= $producto['precio'] ?> €</h3>
                <p>Stock: <?= $producto['stock'] ?></p>

                <form action="acciones/agregar_carrito.php" method="POST">
                    <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">
                    <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
                    <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">

                    <button type="submit" class="btn btn-primary">
                        Añadir al carrito
                    </button>
                </form>
            </div>

        </div>

    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>
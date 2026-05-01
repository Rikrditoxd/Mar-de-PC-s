<?php

session_start();
include("config/conexion.php");


//sentencia para buscar productos

$sql = "SELECT * FROM productos WHERE 1=1";

// FILTRO POR CATEGORIA
if (isset($_GET['categoria']) && $_GET['categoria'] != "") {
    $categoria = intval($_GET['categoria']);
    $sql .= " AND id_categoria = $categoria";
}

$sql_cat = "SELECT * FROM categorias";
$categorias = $conn->query($sql_cat);

// BUSCADOR
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $buscar = $conn->real_escape_string($_GET['buscar']);
    $sql .= " AND nombre LIKE '%$buscar%'";
}

$resultado = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<?php include("includes/navbar.php"); ?>

<body>


    <div class="container-fluid mt-4">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3">
                <div class="card p-3">

                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <a href="catalogo.php">Todas</a>
                        </li>

                        <!-- busqueda por categoria de la bbdd -->
                        <?php while ($cat = $categorias->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <a href="catalogo.php?categoria=<?= $cat['id_categoria'] ?>">
                                    <?= $cat['nombre'] ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <h5>Buscar</h5>

                    <form method="GET" action="catalogo.php">
                        <input type="text" name="buscar" class="form-control mb-2" placeholder="Buscar producto...">
                        <button class="btn btn-primary w-100">Buscar</button>
                    </form>

                </div>
            </div>

            <div class="col-md-9">
    <h1>Catálogo de productos</h1>

    <div class="row">

        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($fila = $resultado->fetch_assoc()): ?>

                <div class="col-md-4 mb-4">
                    <a href="producto.php?id=<?= $fila['id_producto'] ?>" class="card-link">

                        <div class="card h-100">
                            <img src="<?= $fila['imagen_url'] ?>" class="card-img-top">

                            <div class="card-body">
                                <h5 class="card-title"><?= $fila['nombre'] ?></h5>
                                <p class="card-text"><?= $fila['descripcion'] ?></p>
                                <p><strong><?= $fila['precio'] ?> €</strong></p>
                            </div>
                        </div>

                    </a>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay productos.</p>
        <?php endif; ?>

    </div>
</div>

</body>

</html>
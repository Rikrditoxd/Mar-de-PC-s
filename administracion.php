<?php
session_start();
include("config/conexion.php");

// 🔒 seguridad admin
if (!isset($_SESSION['id_usuario']) || $_SESSION['administrador'] != 1) {
    header("Location: index.php");
    exit();
}

// ==========================
// CATEGORÍAS
// ==========================
$sql_cat = "SELECT * FROM categorias";
$categorias = $conn->query($sql_cat);

// ==========================
// SUBCATEGORÍAS
// ==========================
$sql_sub = "SELECT * FROM subcategorias";
$res_sub = $conn->query($sql_sub);

$subcategorias = [];
while ($row = $res_sub->fetch_assoc()) {
    $subcategorias[$row['id_categoria']][] = $row;
}

// ==========================
// QUERY BASE PRODUCTOS
// ==========================
$sql = "SELECT * FROM productos WHERE 1=1";

if (isset($_GET['categoria']) && $_GET['categoria'] != "") {
    $categoria = intval($_GET['categoria']);
    $sql .= " AND id_categoria = $categoria";
}

if (isset($_GET['subcategoria']) && $_GET['subcategoria'] != "") {
    $sub = intval($_GET['subcategoria']);
    $sql .= " AND id_subcategoria = $sub";
}

if (isset($_GET['buscar']) && $_GET['buscar'] != "") {
    $buscar = $conn->real_escape_string($_GET['buscar']);
    $sql .= " AND nombre LIKE '%$buscar%'";
}

$resultado = $conn->query($sql);

// ==========================
// GUARDAR PRODUCTOS Y URLs EN BASE64
// ==========================
$productos = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

$urls_base64 = base64_encode(json_encode(array_column($productos, 'imagen_url')));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include("includes/navbar.php"); ?>

    <div class="container-fluid mt-4">
        <div class="row">

            <!-- BUSCADOR -->
            <h5>Buscar</h5>
            <form method="GET" action="administracion.php">
                <input type="text" name="buscar" class="form-control mb-2" placeholder="Buscar producto...">
                <button class="btn btn-primary w-100">Buscar</button>
            </form>

            <br>

            <!-- SIDEBAR -->
            <div class="col-md-3">
                <div class="card p-3">
                    <h5>Categorías</h5>
                    <ul class="list-group mb-3">

                        <li class="list-group-item">
                            <a href="administracion.php">Todas</a>
                        </li>

                        <?php while ($cat = $categorias->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <a href="administracion.php?categoria=<?= htmlspecialchars($cat['id_categoria']) ?>">
                                    <?= htmlspecialchars($cat['nombre']) ?>
                                </a>

                                <?php if (isset($subcategorias[$cat['id_categoria']])): ?>
                                    <ul class="list-unstyled ms-3 mt-2">
                                        <?php foreach ($subcategorias[$cat['id_categoria']] as $sub): ?>
                                            <li>
                                                <a href="administracion.php?subcategoria=<?= htmlspecialchars($sub['id_subcategoria']) ?>">
                                                    <?= htmlspecialchars($sub['nombre']) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>

                    </ul>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="col-md-9">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Panel de Administración</h1>
                    <a href="acciones/crear_producto.php" class="btn btn-success">
                        + Añadir producto
                    </a>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (count($productos) > 0): ?>
                            <?php foreach ($productos as $i => $fila): ?>
                                <tr>
                                    <td><?= htmlspecialchars($fila['id_producto']) ?></td>
                                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                                    <td><?= htmlspecialchars($fila['precio']) ?> €</td>
                                    <td><?= htmlspecialchars($fila['stock']) ?></td>
                                    <td>
                                        <img id="img-<?= $i ?>" width="50" alt="<?= htmlspecialchars($fila['nombre']) ?>">
                                    </td>
                                    <td>
                                        <a href="acciones/editar_producto.php?id=<?= htmlspecialchars($fila['id_producto']) ?>" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>
                                        <form action="acciones/eliminar_producto.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($fila['id_producto']) ?>">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay productos</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>

    <script>
        const urls = JSON.parse(atob("<?= $urls_base64 ?>"));
        urls.forEach((url, i) => {
            const img = document.getElementById('img-' + i);
            if (img) img.src = url;
        });
    </script>

</body>
</html>
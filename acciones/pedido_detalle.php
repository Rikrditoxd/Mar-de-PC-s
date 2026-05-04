<?php
session_start();
include("../config/conexion.php");

// 🔒 Seguridad admin o usuario logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Pedido no encontrado");
}

$id_pedido = intval($_GET['id']);
$id_usuario = $_SESSION['id_usuario'];
$es_admin = $_SESSION['administrador'] ?? 0;

/*
   🔐 Seguridad:
   - Admin puede ver todos
   - Usuario solo los suyos
*/

if ($es_admin == 1) {
    $sql = "SELECT p.*, u.nombre 
            FROM pedidos p
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            WHERE p.id_pedido = $id_pedido";
} else {
    $sql = "SELECT p.*, u.nombre 
            FROM pedidos p
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            WHERE p.id_pedido = $id_pedido AND p.id_usuario = $id_usuario";
}

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Pedido no encontrado o no tienes acceso");
}

$pedido = $result->fetch_assoc();

// 🔎 productos del pedido
$sql_items = "SELECT pi.*, pr.nombre, pr.imagen_url
              FROM pedido_items pi
              JOIN productos pr ON pi.id_producto = pr.id_producto
              WHERE pi.id_pedido = $id_pedido";

$items = $conn->query($sql_items);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pedido #<?= $pedido['id_pedido'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>



<div class="container mt-5">

    <h2>📦 Pedido #<?= $pedido['id_pedido'] ?></h2>

    <div class="card p-3 mb-4">

        <p><strong>Cliente:</strong> <?= $pedido['nombre'] ?></p>
        <p><strong>Estado:</strong> <?= $pedido['estado'] ?></p>
        <p><strong>Fecha:</strong> <?= $pedido['creado_en'] ?></p>
        <p><strong>Dirección:</strong> <?= $pedido['direccion_envio'] ?></p>
        <p><strong>Total:</strong> <?= $pedido['total'] ?> €</p>

    </div>

    <h4>🛒 Productos</h4>

    <table class="table table-striped">

        <thead>
            <tr>
                <th>Producto</th>
                <th>Imagen</th>
                <th>Cantidad</th>
                <th>Precio unidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>

            <?php $total_calc = 0; ?>

            <?php while ($item = $items->fetch_assoc()): 
                $subtotal = $item['cantidad'] * $item['precio_unidad'];
                $total_calc += $subtotal;
            ?>

            <tr>
                <td><?= $item['nombre'] ?></td>

                <td>
                    <img src="<?= $item['imagen_url'] ?>" width="60">
                </td>

                <td><?= $item['cantidad'] ?></td>

                <td><?= $item['precio_unidad'] ?> €</td>

                <td><?= $subtotal ?> €</td>
            </tr>

            <?php endwhile; ?>

        </tbody>

    </table>

    <div class="text-end">
        <h4>Total calculado: <?= $total_calc ?> €</h4>
    </div>

    <a href="javascript:history.back()" class="btn btn-secondary mt-3">
        Volver
    </a>

</div>

</body>
</html>
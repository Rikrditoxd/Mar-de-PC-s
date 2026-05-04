<?php
session_start();
include("config/conexion.php");

// 🔒 Seguridad
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// 🧾 Obtener pedidos
$sql = "SELECT * FROM pedidos WHERE id_usuario = '$id_usuario' ORDER BY creado_en DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">

    <h1>📦 Mis pedidos</h1>

    <?php if ($resultado->num_rows == 0): ?>
        <p>No has realizado ningún pedido.</p>
    <?php else: ?>

        <?php while ($pedido = $resultado->fetch_assoc()): ?>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Pedido #<?= $pedido['id_pedido'] ?></span>
                    <span><?= $pedido['estado'] ?></span>
                </div>

                <div class="card-body">

                    <p><strong>Fecha:</strong> <?= $pedido['creado_en'] ?></p>
                    <p><strong>Total:</strong> <?= $pedido['total'] ?> €</p>
                    <p><strong>Dirección:</strong> <?= $pedido['direccion_envio'] ?></p>

                    <!-- PRODUCTOS -->
                    <h5>Productos:</h5>

                    <?php
                    $id_pedido = $pedido['id_pedido'];

                    $sql_items = "SELECT pi.*, p.nombre 
                                  FROM pedido_items pi
                                  JOIN productos p ON pi.id_producto = p.id_producto
                                  WHERE pi.id_pedido = '$id_pedido'";

                    $items = $conn->query($sql_items);
                    ?>

                    <ul class="list-group">

                        <?php while ($item = $items->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>
                                    <?= $item['nombre'] ?> (x<?= $item['cantidad'] ?>)
                                </span>
                                <span>
                                    <?= $item['precio_unidad'] ?> €
                                </span>
                            </li>
                        <?php endwhile; ?>

                    </ul>

                </div>
            </div>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

</body>
</html>
<?php

session_start();
include("config/conexion.php");

//si no es administrador, no estra en administracion
if (!isset($_SESSION['id_usuario']) || $_SESSION['administrador'] != 1) {
    header("Location: index.php");
    exit();
}

include("config/conexion.php");

$sql = "SELECT p.*, u.nombre 
        FROM pedidos p
        JOIN usuarios u ON p.id_usuario = u.id_usuario
        ORDER BY p.creado_en DESC";

$resultado = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include("includes/navbar.php"); ?>


    <div class="container mt-5">

    <h2>📦 Administración de pedidos</h2>

    <table class="table table-striped mt-3">

        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php while ($pedido = $resultado->fetch_assoc()): ?>

                <tr>
                    <td><?= $pedido['id_pedido'] ?></td>
                    <td><?= $pedido['nombre'] ?></td>

                    <td>
                        <span class="badge bg-secondary">
                            <?= $pedido['estado'] ?>
                        </span>
                    </td>

                    <td><?= $pedido['total'] ?> €</td>

                    <td><?= $pedido['creado_en'] ?></td>

                    <td>

                        <!-- VER DETALLE -->
                        <a href="acciones/pedido_detalle.php?id=<?= $pedido['id_pedido'] ?>" 
                           class="btn btn-sm btn-primary">
                            Ver
                        </a>

                        <!-- EDITAR ESTADO -->
                        <a href="acciones/editar_pedido.php?id=<?= $pedido['id_pedido'] ?>" 
                           class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <!-- ELIMINAR -->
                        <a href="acciones/eliminar_pedido.php?id=<?= $pedido['id_pedido'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('¿Eliminar pedido?')">
                            Eliminar
                        </a>

                    </td>
                </tr>

            <?php endwhile; ?>

        </tbody>

    </table>

</div>

<?php include("includes/footer.php"); ?>
</body>
</html>
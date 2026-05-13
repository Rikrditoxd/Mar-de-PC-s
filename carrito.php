<?php
session_start();
$carrito = $_SESSION['carrito'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Mar de PC's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">
    <h1 class="mb-4">Tu carrito</h1>

    <?php if (empty($carrito)): ?>
        <div class="alert alert-info">
            El carrito está vacío.
            <a href="catalogo.php" class="alert-link">Ver productos</a>
        </div>
    <?php else: ?>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($carrito as $id => $item):
                        $id_safe = (int)$id;
                        $subtotal = (float)$item['precio'] * (int)$item['cantidad'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td><?= number_format((float)$item['precio'], 2) ?> €</td>

                            <td>
                                <a href="acciones/actualizar_carrito.php?id=<?= $id_safe ?>&accion=restar"
                                    class="btn btn-sm btn-warning">-</a>
                                <span class="mx-2"><?= (int)$item['cantidad'] ?></span>
                                <a href="acciones/actualizar_carrito.php?id=<?= $id_safe ?>&accion=sumar"
                                    class="btn btn-sm btn-success">+</a>
                            </td>

                            <td><?= number_format($subtotal, 2) ?> €</td>

                            <td>
                                <a href="acciones/eliminar_carrito.php?id=<?= $id_safe ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar este producto del carrito?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total:</td>
                        <td class="fw-bold"><?= number_format($total, 2) ?> €</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="catalogo.php" class="btn btn-outline-secondary">Seguir comprando</a>
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <a href="checkout.php" class="btn btn-success btn-lg">Finalizar compra</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary btn-lg">Inicia sesión para comprar</a>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>

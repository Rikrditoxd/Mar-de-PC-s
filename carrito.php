<?php
session_start();
$carrito = $_SESSION['carrito'] ?? [];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include("includes/navbar.php"); ?>

    <div class="container mt-5">
        <h1>Tu carrito</h1>

        <?php if (empty($carrito)): ?>
            <p>El carrito está vacío</p>
        <?php else: ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $total = 0; ?>

                    <?php foreach ($carrito as $id => $item):
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><?= $item['nombre'] ?></td>
                            <td><?= $item['precio'] ?> €</td>

                            <!-- CANTIDAD -->
                            <td>
                                <a href="acciones/actualizar_carrito.php?id=<?= $id ?>&accion=restar"
                                    class="btn btn-sm btn-warning">-</a>
                                <?= $item['cantidad'] ?>
                                <a href="acciones/actualizar_carrito.php?id=<?= $id ?>&accion=sumar" class="btn btn-sm btn-success">+</a>
                            </td>

                            <td><?= $subtotal ?> €</td>

                            <!-- ELIMINAR -->
                            <td>
                                <a href="acciones/eliminar_carrito.php?id=<?= $id ?>" class="btn btn-sm btn-danger">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Total: <?= $total ?> €</h3>

            <a href="checkout.php" class="btn btn-success">
                Finalizar compra
            </a>

        <?php endif; ?>

        
    </div>
    DISCLAIMER: ESTA ES UNA PAGINA WEB CON FINES EDUCATIVOS Y NO COMERCIALES, LOS PROCESOS DE COMPRA SON UNA SIMULACION
<?php include("includes/footer.php"); ?>
</body>

</html>
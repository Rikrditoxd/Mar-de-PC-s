<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$carrito = $_SESSION['carrito'] ?? [];
if (empty($carrito)) {
    header("Location: carrito.php");
    exit();
}

$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar compra - Mar de PC's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container my-5">
    <h1 class="mb-4">Finalizar compra</h1>

    <div class="row g-4">

        <!-- Formulario -->
        <div class="col-md-7">
            <form action="acciones/procesar_compra.php" method="POST" id="formCheckout" novalidate>

                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Dirección de envío</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="nombre" class="form-control" required
                                placeholder="Nombre completo"
                                value="<?= htmlspecialchars($_SESSION['nombre'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección <span class="text-danger">*</span></label>
                            <input type="text" name="direccion" class="form-control" required placeholder="Calle, número, piso...">
                        </div>
                        <div class="row g-2">
                            <div class="col-md-8">
                                <label class="form-label">Ciudad <span class="text-danger">*</span></label>
                                <input type="text" name="ciudad" class="form-control" required placeholder="Ciudad">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Código postal <span class="text-danger">*</span></label>
                                <input type="text" name="cp" class="form-control" required placeholder="12345" pattern="\d{4,10}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Pago (simulado)</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <small>Esta es una tienda educativa. No introduzcas datos reales de tarjeta.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Titular</label>
                            <input type="text" name="titular" class="form-control" placeholder="Nombre en la tarjeta" maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número de tarjeta</label>
                            <input type="text" name="tarjeta" class="form-control" placeholder="1234 5678 9012 3456"
                                maxlength="19" pattern="[\d ]{13,19}">
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Caducidad</label>
                                <input type="text" name="caducidad" class="form-control" placeholder="MM/AA" maxlength="5" pattern="\d{2}/\d{2}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CVV</label>
                                <input type="text" name="cvv" class="form-control" placeholder="123" maxlength="4" pattern="\d{3,4}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="carrito.php" class="btn btn-outline-secondary flex-fill">Volver al carrito</a>
                    <button type="submit" class="btn btn-success flex-fill btn-lg">
                        Confirmar compra (<?= number_format($total, 2) ?> €)
                    </button>
                </div>

            </form>
        </div>

        <!-- Resumen del pedido -->
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del pedido</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($carrito as $item): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><?= htmlspecialchars($item['nombre']) ?> <span class="badge bg-secondary">x<?= (int)$item['cantidad'] ?></span></span>
                                <span><?= number_format($item['precio'] * $item['cantidad'], 2) ?> €</span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span><?= number_format($total, 2) ?> €</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>

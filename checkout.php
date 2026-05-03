<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <h1>Finalizar compra</h1>

    <form action="acciones/procesar_compra.php" method="POST">

        <h4>Dirección</h4>

        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre completo" required>
        <input type="text" name="direccion" class="form-control mb-2" placeholder="Dirección" required>
        <input type="text" name="ciudad" class="form-control mb-2" placeholder="Ciudad" required>
        <input type="text" name="cp" class="form-control mb-2" placeholder="Código postal" required>

        <h4>Pago</h4>

        <input type="text" name="tarjeta" class="form-control mb-2" placeholder="Número de tarjeta" required>
        <input type="text" name="caducidad" class="form-control mb-2" placeholder="MM/AA" required>
        <input type="text" name="cvv" class="form-control mb-2" placeholder="CVV" required>

        <button class="btn btn-primary mt-3">
            Comprar
        </button>

    </form>
</div>

</body>
</html>
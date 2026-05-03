<?php
session_start();

// Aquí podrías guardar en BD si quisieras

// Vaciar carrito
unset($_SESSION['carrito']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Compra completada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5 text-center">
    <h1>✅ Compra realizada</h1>
    <p>Gracias por tu pedido</p>

    <a href="../index.php" class="btn btn-primary">
        Volver a la tienda
    </a>
</div>

</body>
</html>
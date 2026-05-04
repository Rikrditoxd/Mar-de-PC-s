<?php
session_start();
include("../config/conexion.php");

$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    die("El carrito está vacío");
}

// ⚠️ IMPORTANTE: cambia esto por tu sesión real de usuario
$id_usuario = $_SESSION['id_usuario'] ?? 1;

// Datos del formulario
$direccion = $_POST['direccion'] . ", " . $_POST['ciudad'] . " (" . $_POST['cp'] . ")";

// 🔢 Calcular total
$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

// 🧾 1. Insertar pedido
$sql_pedido = "INSERT INTO pedidos (id_usuario, estado, total, direccion_envio, creado_en)
               VALUES ('$id_usuario', 'pendiente', '$total', '$direccion', NOW())";

if (!$conn->query($sql_pedido)) {
    die("Error al crear pedido: " . $conn->error);
}

// 📌 Obtener ID del pedido
$id_pedido = $conn->insert_id;

// 📦 2. Insertar productos
foreach ($carrito as $id_producto => $item) {

    $cantidad = $item['cantidad'];
    $precio = $item['precio'];

    $sql_item = "INSERT INTO pedido_items (id_pedido, id_producto, cantidad, precio_unidad)
                 VALUES ('$id_pedido', '$id_producto', '$cantidad', '$precio')";

    if (!$conn->query($sql_item)) {
        die("Error al insertar producto: " . $conn->error);
    }
}

// 🧹 3. Vaciar carrito
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
    <p>Tu pedido ha sido registrado correctamente</p>
    <?php 
        $conn->query("DELETE FROM carrito WHERE id_usuario = '$id_usuario'");
    ?>

    <a href="../index.php" class="btn btn-primary">
        Volver a la tienda
    </a>
</div>

</body>
</html>
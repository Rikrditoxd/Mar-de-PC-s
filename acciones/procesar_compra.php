<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    header("Location: ../carrito.php");
    exit();
}

$id_usuario = (int)$_SESSION['id_usuario'];

$dir = trim($_POST['direccion'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');
$cp = trim($_POST['cp'] ?? '');

if (empty($dir) || empty($ciudad) || empty($cp)) {
    echo "<script>
        alert('Por favor completa todos los campos de dirección');
        window.location.href = '../checkout.php';
    </script>";
    exit();
}

$direccion = htmlspecialchars($dir) . ", " . htmlspecialchars($ciudad) . " (" . htmlspecialchars($cp) . ")";

// Calcular total
$total = 0;
foreach ($carrito as $item) {
    $total += (float)$item['precio'] * (int)$item['cantidad'];
}

// 1. Insertar pedido
$stmt_pedido = $conn->prepare("INSERT INTO pedidos (id_usuario, estado, total, direccion_envio, creado_en) VALUES (?, 'pendiente', ?, ?, NOW())");
$stmt_pedido->bind_param("ids", $id_usuario, $total, $direccion);
if (!$stmt_pedido->execute()) {
    die("Error al crear pedido");
}
$id_pedido = $conn->insert_id;
$stmt_pedido->close();

// 2. Insertar líneas del pedido
$stmt_item = $conn->prepare("INSERT INTO pedido_items (id_pedido, id_producto, cantidad, precio_unidad) VALUES (?, ?, ?, ?)");

foreach ($carrito as $id_producto => $item) {
    $id_prod = (int)$id_producto;
    $cantidad = (int)$item['cantidad'];
    $precio = (float)$item['precio'];
    $stmt_item->bind_param("iiid", $id_pedido, $id_prod, $cantidad, $precio);
    if (!$stmt_item->execute()) {
        die("Error al insertar línea de pedido");
    }
}
$stmt_item->close();

// 3. Vaciar carrito
unset($_SESSION['carrito']);

$stmt_del = $conn->prepare("DELETE FROM carrito WHERE id_usuario = ?");
$stmt_del->bind_param("i", $id_usuario);
$stmt_del->execute();
$stmt_del->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra completada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include("../includes/navbar.php"); ?>

<div class="container mt-5 text-center">
    <div class="card shadow p-5 mx-auto" style="max-width:500px;">
        <h1 class="text-success mb-3">Compra realizada</h1>
        <p class="lead">Tu pedido #<?= $id_pedido ?> ha sido registrado correctamente.</p>
        <p class="text-muted">Recibirás confirmación en cuanto sea procesado.</p>
        <a href="../index.php" class="btn btn-primary mt-3">Volver a la tienda</a>
        <a href="../pedidos.php" class="btn btn-outline-secondary mt-2">Ver mis pedidos</a>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
</body>
</html>

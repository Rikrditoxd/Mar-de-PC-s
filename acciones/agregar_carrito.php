<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_usuario = (int)$_SESSION['id_usuario'];
$id = (int)($_POST['id_producto'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$precio = (float)($_POST['precio'] ?? 0);

if ($id <= 0) {
    header("Location: ../catalogo.php");
    exit();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad']++;
} else {
    $_SESSION['carrito'][$id] = [
        "nombre" => $nombre,
        "precio" => $precio,
        "cantidad" => 1
    ];
}

$stmt = $conn->prepare("INSERT INTO carrito (id_usuario, id_producto, cantidad)
    VALUES (?, ?, 1)
    ON DUPLICATE KEY UPDATE cantidad = cantidad + 1");
$stmt->bind_param("ii", $id_usuario, $id);
$stmt->execute();
$stmt->close();

header("Location: ../carrito.php");
exit();

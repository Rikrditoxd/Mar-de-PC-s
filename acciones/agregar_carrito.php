<?php
session_start();
include("../config/conexion.php");

$id_usuario = $_SESSION['id_usuario'] ?? 1;

$id = $_POST['id_producto'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];

// 🧠 SESSION
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

// 💾 BD → insertar o actualizar
$sql = "INSERT INTO carrito (id_usuario, id_producto, cantidad)
        VALUES ('$id_usuario', '$id', 1)
        ON DUPLICATE KEY UPDATE cantidad = cantidad + 1";

$conn->query($sql);

header("Location: ../carrito.php");
exit();
<?php
session_start();

$id = $_POST['id_producto'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];

// Si no existe carrito → crearlo
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Si ya existe el producto → sumar cantidad
if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad']++;
} else {
    $_SESSION['carrito'][$id] = [
        "nombre" => $nombre,
        "precio" => $precio,
        "cantidad" => 1
    ];
}

// Redirigir al carrito
header("Location: ../carrito.php");
exit();
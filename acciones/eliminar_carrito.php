<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_usuario = (int)$_SESSION['id_usuario'];
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: ../carrito.php");
    exit();
}

unset($_SESSION['carrito'][$id]);

$stmt = $conn->prepare("DELETE FROM carrito WHERE id_usuario = ? AND id_producto = ?");
$stmt->bind_param("ii", $id_usuario, $id);
$stmt->execute();
$stmt->close();

header("Location: ../carrito.php");
exit();

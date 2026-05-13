<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_usuario = (int)$_SESSION['id_usuario'];
$id = (int)($_GET['id'] ?? 0);
$accion = $_GET['accion'] ?? '';

if ($id <= 0 || !in_array($accion, ['sumar', 'restar'])) {
    header("Location: ../carrito.php");
    exit();
}

if (isset($_SESSION['carrito'][$id])) {

    if ($accion === "sumar") {
        $_SESSION['carrito'][$id]['cantidad']++;

        $stmt = $conn->prepare("UPDATE carrito SET cantidad = cantidad + 1 WHERE id_usuario = ? AND id_producto = ?");
        $stmt->bind_param("ii", $id_usuario, $id);
        $stmt->execute();
        $stmt->close();
    }

    if ($accion === "restar") {
        $_SESSION['carrito'][$id]['cantidad']--;

        if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {

            unset($_SESSION['carrito'][$id]);

            $stmt = $conn->prepare("DELETE FROM carrito WHERE id_usuario = ? AND id_producto = ?");
            $stmt->bind_param("ii", $id_usuario, $id);
            $stmt->execute();
            $stmt->close();

        } else {

            $stmt = $conn->prepare("UPDATE carrito SET cantidad = cantidad - 1 WHERE id_usuario = ? AND id_producto = ?");
            $stmt->bind_param("ii", $id_usuario, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

header("Location: ../carrito.php");
exit();

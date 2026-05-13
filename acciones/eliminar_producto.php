<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario']) || $_SESSION['administrador'] != 1) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST['id'])) {
    header("Location: ../administracion.php");
    exit();
}

$id = (int)$_POST['id'];

if ($id <= 0) {
    header("Location: ../administracion.php");
    exit();
}

$stmt = $conn->prepare("DELETE FROM productos WHERE id_producto = ?");
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Error al eliminar producto");
}
$stmt->close();

header("Location: ../administracion.php");
exit();
?>

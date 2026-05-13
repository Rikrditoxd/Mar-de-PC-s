<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario']) || $_SESSION['administrador'] != 1) {
    header("Location: ../index.php");
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = (float)($_POST['precio'] ?? 0);
$stock = (int)($_POST['stock'] ?? 0);
$imagen = trim($_POST['imagen_url'] ?? '');
$id_categoria = (int)($_POST['id_categoria'] ?? 0);

if (empty($nombre) || $precio <= 0 || $id_categoria <= 0) {
    echo "<script>
        alert('Nombre, precio y categoría son obligatorios');
        window.location.href = '../administracion.php';
    </script>";
    exit();
}

$stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, imagen_url, id_categoria) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $stock, $imagen, $id_categoria);

if (!$stmt->execute()) {
    die("Error al crear producto");
}
$stmt->close();

header("Location: ../administracion.php");
exit();
?>

<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario']) || $_SESSION['administrador'] != 1) {
    header("Location: ../index.php");
    exit();
}

$id = (int)($_POST['id_producto'] ?? 0);

if ($id <= 0) {
    header("Location: ../administracion.php");
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$precio = (float)($_POST['precio'] ?? 0);
$stock = (int)($_POST['stock'] ?? 0);
$descripcion = trim($_POST['descripcion'] ?? '');
$imagen = trim($_POST['imagen_url'] ?? '');
$id_categoria = (int)($_POST['id_categoria'] ?? 0);
$id_subcategoria = (isset($_POST['id_subcategoria']) && $_POST['id_subcategoria'] !== '')
    ? (int)$_POST['id_subcategoria']
    : null;

if (empty($nombre) || $precio <= 0) {
    echo "<script>
        alert('Nombre y precio son obligatorios');
        history.back();
    </script>";
    exit();
}

$stmt = $conn->prepare("UPDATE productos SET nombre=?, precio=?, stock=?, descripcion=?, imagen_url=?, id_categoria=?, id_subcategoria=? WHERE id_producto=?");
$stmt->bind_param("sdiissii", $nombre, $precio, $stock, $descripcion, $imagen, $id_categoria, $id_subcategoria, $id);

if (!$stmt->execute()) {
    die("Error al actualizar producto");
}
$stmt->close();

header("Location: ../administracion.php");
exit();
?>

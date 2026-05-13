<?php
include("../config/conexion.php");

$tipo = $_GET['tipo'] ?? '';
$id   = intval($_GET['id'] ?? 0);

if ($id <= 0 || !in_array($tipo, ['producto', 'adicional'])) {
    http_response_code(404);
    exit();
}

if ($tipo === 'producto') {
    $stmt = $conn->prepare("SELECT imagen_data, imagen_mime FROM productos WHERE id_producto = ?");
} else {
    $stmt = $conn->prepare("SELECT imagen_data, imagen_mime FROM producto_imagenes WHERE id_imagen = ?");
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row || empty($row['imagen_data'])) {
    http_response_code(404);
    exit();
}

header("Content-Type: " . ($row['imagen_mime'] ?: 'image/jpeg'));
header("Cache-Control: public, max-age=86400");
echo $row['imagen_data'];

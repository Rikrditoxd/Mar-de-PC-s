<?php
include("../config/conexion.php");

$id = intval($_POST['id_producto']);

$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$descripcion = $_POST['descripcion'];
$imagen = $_POST['imagen_url'];

$id_categoria = intval($_POST['id_categoria']);
$id_subcategoria = isset($_POST['id_subcategoria']) && $_POST['id_subcategoria'] != ""
    ? intval($_POST['id_subcategoria'])
    : "NULL";

/* =========================
   UPDATE
========================= */
$sql = "UPDATE productos 
        SET nombre = '$nombre',
            precio = '$precio',
            stock = '$stock',
            descripcion = '$descripcion',
            imagen_url = '$imagen',
            id_categoria = $id_categoria,
            id_subcategoria = $id_subcategoria
        WHERE id_producto = $id";

if (!$conn->query($sql)) {
    die("Error al actualizar: " . $conn->error);
}

header("Location: ../administracion.php");
exit();
?>
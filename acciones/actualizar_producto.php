<?php
include("../config/conexion.php");

$id = $_POST['id_producto'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$imagen = $_POST['imagen_url'];

$sql = "UPDATE productos 
        SET nombre='$nombre',
            precio='$precio',
            stock='$stock',
            imagen_url='$imagen'
        WHERE id_producto=$id";

if (!$conn->query($sql)) {
    die("Error al actualizar: " . $conn->error);
}

header("Location: ../administracion.php");
exit();
?>
<?php
include("../config/conexion.php");

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$imagen = $_POST['imagen_url'];
$id_categoria = $_POST['id_categoria'];

$sql = "INSERT INTO productos 
(nombre, descripcion, precio, stock, imagen_url, id_categoria)
VALUES 
('$nombre', '$descripcion', '$precio', '$stock', '$imagen', '$id_categoria')";

if (!$conn->query($sql)) {
    die("Error: " . $conn->error);
}

header("Location: ../administracion.php");
exit();
?>
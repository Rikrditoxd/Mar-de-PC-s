<?php
include("../config/conexion.php");

$id_imagen = $_POST['id_imagen'];

// obtener id_producto antes de borrar
$sql = "SELECT id_producto FROM producto_imagenes WHERE id_imagen = $id_imagen";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id_producto = $row['id_producto'];

$conn->query("DELETE FROM producto_imagenes WHERE id_imagen = $id_imagen");

header("Location: ../acciones/editar_producto.php?id=$id_producto");
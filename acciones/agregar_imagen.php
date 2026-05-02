<?php
include("../config/conexion.php");

$id_producto = $_POST['id_producto'];
$imagen_url = $_POST['imagen_url'];

$sql = "INSERT INTO producto_imagenes (id_producto, imagen_url)
        VALUES ($id_producto, '$imagen_url')";

$conn->query($sql);

header("Location: ../acciones/editar_producto.php?id=$id_producto");
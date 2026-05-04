<?php
session_start();
include("../config/conexion.php");

$id = $_POST['id'];
$estado = $_POST['estado'];

$conn->query("UPDATE pedidos SET estado = '$estado' WHERE id_pedido = $id");

header("Location: ../administracion_pedidos.php");
exit();
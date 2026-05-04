<?php
session_start();
include("../config/conexion.php");

// solo admin
if (!isset($_SESSION['administrador']) || $_SESSION['administrador'] != 1) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// borrar items primero (clave foránea)
$conn->query("DELETE FROM pedido_items WHERE id_pedido = $id");

// borrar pedido
$conn->query("DELETE FROM pedidos WHERE id_pedido = $id");

header("Location: ../administracion_pedidos.php");
exit();
<?php
session_start();
include("../config/conexion.php");

$id_usuario = $_SESSION['id_usuario'] ?? 1;
$id = $_GET['id'];

// SESSION
unset($_SESSION['carrito'][$id]);

// BD
$conn->query("
    DELETE FROM carrito 
    WHERE id_usuario = '$id_usuario' AND id_producto = '$id'
");

header("Location: ../carrito.php");
exit();
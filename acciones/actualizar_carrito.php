<?php
session_start();
include("../config/conexion.php");

$id_usuario = $_SESSION['id_usuario'] ?? 1;

$id = $_GET['id'];
$accion = $_GET['accion'];

if (isset($_SESSION['carrito'][$id])) {

    if ($accion == "sumar") {
        $_SESSION['carrito'][$id]['cantidad']++;

        $conn->query("
            UPDATE carrito 
            SET cantidad = cantidad + 1 
            WHERE id_usuario = '$id_usuario' AND id_producto = '$id'
        ");
    }

    if ($accion == "restar") {
        $_SESSION['carrito'][$id]['cantidad']--;

        if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {

            unset($_SESSION['carrito'][$id]);

            $conn->query("
                DELETE FROM carrito 
                WHERE id_usuario = '$id_usuario' AND id_producto = '$id'
            ");

        } else {

            $conn->query("
                UPDATE carrito 
                SET cantidad = cantidad - 1 
                WHERE id_usuario = '$id_usuario' AND id_producto = '$id'
            ");
        }
    }
}

header("Location: ../carrito.php");
exit();
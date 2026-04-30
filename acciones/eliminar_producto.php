<?php
include("../config/conexion.php");

// Comprobar que viene el ID
if (!isset($_POST['id'])) {
    die("ID no recibido");
}

$id = $_POST['id'];

// Consulta para eliminar
$sql = "DELETE FROM productos WHERE id_producto = $id";

if (!$conn->query($sql)) {
    die("Error al eliminar: " . $conn->error);
}

// Redirigir de vuelta al admin
header("Location: ../administracion.php");
exit();
?>
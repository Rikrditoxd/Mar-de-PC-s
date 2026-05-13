<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_producto = (int)($_POST['id_producto'] ?? 0);
$puntuacion  = (int)($_POST['puntuacion']  ?? 0);
$comentario  = trim($_POST['comentario']   ?? '');
$id_usuario  = (int)$_SESSION['id_usuario'];

if ($id_producto <= 0 || $puntuacion < 1 || $puntuacion > 5 || empty($comentario)) {
    echo "<script>alert('Por favor rellena todos los campos correctamente.'); history.back();</script>";
    exit();
}

// Evitar duplicados (también cubierto por UNIQUE KEY en BD)
$chk = $conn->prepare("SELECT id_resena FROM resenas WHERE id_producto=? AND id_usuario=? LIMIT 1");
$chk->bind_param("ii", $id_producto, $id_usuario);
$chk->execute();
$chk->store_result();
if ($chk->num_rows > 0) {
    header("Location: ../producto.php?id=$id_producto#resenas");
    exit();
}
$chk->close();

$stmt = $conn->prepare(
    "INSERT INTO resenas (id_producto, id_usuario, puntuacion, comentario) VALUES (?,?,?,?)"
);
$stmt->bind_param("iiis", $id_producto, $id_usuario, $puntuacion, $comentario);
$stmt->execute();
$stmt->close();

header("Location: ../producto.php?id=$id_producto#resenas");
exit();

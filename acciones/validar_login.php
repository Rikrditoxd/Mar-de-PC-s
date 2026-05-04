<?php
session_start();
include("../config/conexion.php");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>
        alert('Usuario no encontrado');
        window.location.href = '../login.php';
    </script>";
    exit();
}

$user = $result->fetch_assoc();

/* Verificar contraseña encriptada */
if (!password_verify($password, $user['password'])) {
    echo "<script>
        alert('Contraseña incorrecta');
        window.location.href = '../login.php';
    </script>";
    exit();
}

/* Guardar sesión */
$_SESSION['id_usuario'] = $user['id_usuario'];
$_SESSION['nombre'] = $user['nombre'];
$_SESSION['administrador'] = $user['administrador'];

/* 🔄 CARGAR CARRITO DESDE BD */
$id_usuario = $user['id_usuario'];

$sql_carrito = "SELECT c.*, p.nombre, p.precio 
                FROM carrito c
                JOIN productos p ON c.id_producto = p.id_producto
                WHERE c.id_usuario = '$id_usuario'";

$result_carrito = $conn->query($sql_carrito);

// Reiniciar carrito en sesión
$_SESSION['carrito'] = [];

while ($row = $result_carrito->fetch_assoc()) {
    $_SESSION['carrito'][$row['id_producto']] = [
        "nombre" => $row['nombre'],
        "precio" => $row['precio'],
        "cantidad" => $row['cantidad']
    ];
}

/* Redirigir */
if ($user['administrador'] == 1) {
    header("Location: ../administracion.php");
} else {
    header("Location: ../index.php");
}

exit();
?>
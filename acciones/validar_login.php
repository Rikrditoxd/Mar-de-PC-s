<?php
session_start();
include("../config/conexion.php");

if (empty($_POST['email']) || empty($_POST['password'])) {
    echo "<script>
        alert('Email y contraseña son obligatorios');
        window.location.href = '../login.php';
    </script>";
    exit();
}

$email = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>
        alert('Usuario no encontrado');
        window.location.href = '../login.php';
    </script>";
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

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

/* CARGAR CARRITO DESDE BD */
$id_usuario = $user['id_usuario'];

$stmt_carrito = $conn->prepare("SELECT c.*, p.nombre, p.precio
                FROM carrito c
                JOIN productos p ON c.id_producto = p.id_producto
                WHERE c.id_usuario = ?");
$stmt_carrito->bind_param("i", $id_usuario);
$stmt_carrito->execute();
$result_carrito = $stmt_carrito->get_result();

// Reiniciar carrito en sesión
$_SESSION['carrito'] = [];

$stmt_carrito->close();

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
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

/* Redirigir */
if ($user['administrador'] == 1) {
    header("Location: ../administracion.php");
} else {
    header("Location: ../index.php");
}

exit();
?>
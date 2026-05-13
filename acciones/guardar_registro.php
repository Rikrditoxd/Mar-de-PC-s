<?php
session_start();
include("../config/conexion.php");

$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$email = trim($_POST['email'] ?? '');
$password_raw = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');
$codigo_postal = trim($_POST['codigo_postal'] ?? '');

// Validaciones básicas
if (empty($nombre) || empty($apellidos) || empty($email) || empty($password_raw)) {
    echo "<script>
        alert('Los campos Nombre, Apellidos, Email y Contraseña son obligatorios');
        window.location.href = '../registro.php';
    </script>";
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
        alert('El correo electrónico no es válido');
        window.location.href = '../registro.php';
    </script>";
    exit();
}

if (strlen($password_raw) < 6) {
    echo "<script>
        alert('La contraseña debe tener al menos 6 caracteres');
        window.location.href = '../registro.php';
    </script>";
    exit();
}

if ($password_raw !== $password_confirm) {
    echo "<script>
        alert('Las contraseñas no coinciden');
        window.location.href = '../registro.php';
    </script>";
    exit();
}

// Comprobar si ya existe
$stmt_check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    $stmt_check->close();
    echo "<script>
        alert('Este correo ya está registrado, intente con otro');
        window.location.href = '../registro.php';
    </script>";
    exit();
}
$stmt_check->close();

$password = password_hash($password_raw, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios
    (nombre, apellidos, email, password, telefono, direccion, ciudad, codigo_postal, administrador, activo)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 1)");
$stmt->bind_param("ssssssss", $nombre, $apellidos, $email, $password, $telefono, $direccion, $ciudad, $codigo_postal);

if (!$stmt->execute()) {
    die("Error al registrar usuario");
}

$id_nuevo = $conn->insert_id;
$stmt->close();

// Iniciar sesión automáticamente tras el registro
$_SESSION['id_usuario'] = $id_nuevo;
$_SESSION['nombre'] = $nombre;
$_SESSION['administrador'] = 0;
$_SESSION['carrito'] = [];

echo "<script>
    alert('Usuario registrado correctamente. ¡Bienvenido!');
    window.location.href = '../index.php';
</script>";
exit();
?>

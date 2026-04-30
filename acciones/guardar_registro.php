<?php
include("../config/conexion.php");

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$codigo_postal = $_POST['codigo_postal'];

// comprobar si ya existe
$check = "SELECT id_usuario FROM usuarios WHERE email = '$email'";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    echo "<script>
        alert('Este correo ya está registrado, intente con otro');
        window.location.href = '../registro.php';
    </script>";
    exit();
}

/* INSERT si no existe */
$sql = "INSERT INTO usuarios 
(nombre, apellidos, email, password, telefono, direccion, ciudad, codigo_postal, administrador, activo)
VALUES 
('$nombre', '$apellidos', '$email', '$password', '$telefono', '$direccion', '$ciudad', '$codigo_postal', 0, 1)";

if (!$conn->query($sql)) {
    die("Error: " . $conn->error);
}

echo "<script>
    alert('Usuario registrado correctamente');
    window.location.href = '../index.php';
</script>";
exit();
?>
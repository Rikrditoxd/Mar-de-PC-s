<?php
include("../config/conexion.php");

$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$asunto = $_POST['asunto'] ?? '';
$mensaje = trim($_POST['mensaje'] ?? '');

// Validaciones
if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
    echo "<script>
        alert('Por favor rellena todos los campos obligatorios');
        window.location.href = '../contacto.php';
    </script>";
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
        alert('El correo electrónico no es válido');
        window.location.href = '../contacto.php';
    </script>";
    exit();
}

$asuntos_validos = ['consulta', 'soporte', 'pedido', 'otro'];
if (!in_array($asunto, $asuntos_validos)) {
    echo "<script>
        alert('Asunto no válido');
        window.location.href = '../contacto.php';
    </script>";
    exit();
}

$stmt = $conn->prepare("INSERT INTO contactos (nombre, email, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $email, $telefono, $asunto, $mensaje);

if ($stmt->execute()) {
    $stmt->close();
    echo "<script>
        alert('Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.');
        window.location.href = '../contacto.php';
    </script>";
} else {
    $stmt->close();
    echo "<script>
        alert('Error al enviar el mensaje. Inténtalo de nuevo.');
        window.location.href = '../contacto.php';
    </script>";
}
?>

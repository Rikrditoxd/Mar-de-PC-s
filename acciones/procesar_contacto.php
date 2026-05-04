<?php
include("../config/conexion.php");

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

$sql = "INSERT INTO contactos (nombre, email, telefono, asunto, mensaje)
        VALUES ('$nombre', '$email', '$telefono', '$asunto', '$mensaje')";

if ($conn->query($sql)) {
    echo "<script>
        alert('Mensaje enviado correctamente');
        window.location.href = '../contacto.php';
    </script>";
} else {
    echo "Error: " . $conn->error;
}
?>
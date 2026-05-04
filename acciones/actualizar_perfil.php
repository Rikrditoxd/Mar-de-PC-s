<?php
session_start();
include("../config/conexion.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

$sql = "UPDATE usuarios 
        SET nombre='$nombre',
            email='$email',
            telefono='$telefono',
            direccion='$direccion'
        WHERE id_usuario=$id";

$conn->query($sql);

$_SESSION['nombre'] = $nombre;

header("Location: ../perfil.php");
exit();
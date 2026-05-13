<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario']) || $_SESSION['administrador'] != 1) {
    header("Location: ../index.php");
    exit();
}

$id_producto = (int)($_POST['id_producto'] ?? 0);

if ($id_producto <= 0) {
    header("Location: ../administracion.php");
    exit();
}

$imagen_url  = trim($_POST['imagen_url'] ?? '');
$imagen_data = null;
$imagen_mime = null;
$usar_blob   = false;

if (
    isset($_FILES['imagen_file']) &&
    $_FILES['imagen_file']['error'] === UPLOAD_ERR_OK &&
    !empty($_FILES['imagen_file']['tmp_name'])
) {
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $mime = mime_content_type($_FILES['imagen_file']['tmp_name']);

    if (!in_array($mime, $tipos_permitidos)) {
        echo "<script>alert('Tipo de imagen no permitido. Use JPG, PNG, GIF o WEBP.'); history.back();</script>";
        exit();
    }
    if ($_FILES['imagen_file']['size'] > 5 * 1024 * 1024) {
        echo "<script>alert('La imagen supera el límite de 5 MB.'); history.back();</script>";
        exit();
    }

    $imagen_data = file_get_contents($_FILES['imagen_file']['tmp_name']);
    $imagen_mime = $mime;
    $usar_blob   = true;
}

// Si no hay ni archivo ni URL, volver sin hacer nada
if (!$usar_blob && empty($imagen_url)) {
    header("Location: ../acciones/editar_producto.php?id=$id_producto");
    exit();
}

if ($usar_blob) {
    // 1. INSERT para obtener el id_imagen
    $stmt = $conn->prepare("INSERT INTO producto_imagenes (id_producto, imagen_url) VALUES (?, '')");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $id_imagen = $conn->insert_id;
    $stmt->close();

    // 2. Construir URL de servicio con el id recién creado
    $base = rtrim(dirname($_SERVER['PHP_SELF']), '/');
    $imagen_url = $base . '/servir_imagen.php?tipo=adicional&id=' . $id_imagen;

    // 3. UPDATE con BLOB e imagen_url
    $stmt2 = $conn->prepare(
        "UPDATE producto_imagenes SET imagen_url=?, imagen_data=?, imagen_mime=? WHERE id_imagen=?"
    );
    $null = null;
    $stmt2->bind_param("sbsi", $imagen_url, $null, $imagen_mime, $id_imagen);
    $stmt2->send_long_data(1, $imagen_data);
    $stmt2->execute();
    $stmt2->close();
} else {
    // Solo URL
    $stmt = $conn->prepare("INSERT INTO producto_imagenes (id_producto, imagen_url) VALUES (?, ?)");
    $stmt->bind_param("is", $id_producto, $imagen_url);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../acciones/editar_producto.php?id=$id_producto");

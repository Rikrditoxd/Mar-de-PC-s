<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario']) || $_SESSION['administrador'] != 1) {
    header("Location: ../index.php");
    exit();
}

$id = (int)($_POST['id_producto'] ?? 0);

if ($id <= 0) {
    header("Location: ../administracion.php");
    exit();
}

$nombre      = trim($_POST['nombre']      ?? '');
$precio      = (float)($_POST['precio']   ?? 0);
$stock       = (int)($_POST['stock']      ?? 0);
$descripcion = trim($_POST['descripcion'] ?? '');
$id_categoria = (int)($_POST['id_categoria'] ?? 0);
$id_subcategoria = (isset($_POST['id_subcategoria']) && $_POST['id_subcategoria'] !== '')
    ? (int)$_POST['id_subcategoria']
    : null;

if (empty($nombre) || $precio <= 0) {
    echo "<script>alert('Nombre y precio son obligatorios'); history.back();</script>";
    exit();
}

// --- Imagen: el archivo tiene prioridad sobre la URL ---
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
    // URL raíz-relativa: funciona desde cualquier página del proyecto
    $base = rtrim(dirname($_SERVER['PHP_SELF']), '/');
    $imagen_url = $base . '/servir_imagen.php?tipo=producto&id=' . $id;
    $usar_blob  = true;
}

// --- UPDATE ---
if ($usar_blob) {
    // Guardar BLOB + nueva URL de servicio
    $stmt = $conn->prepare(
        "UPDATE productos
         SET nombre=?, precio=?, stock=?, descripcion=?,
             imagen_url=?, imagen_data=?, imagen_mime=?,
             id_categoria=?, id_subcategoria=?
         WHERE id_producto=?"
    );
    $null = null;
    $stmt->bind_param(
        "sdissbsiii",
        $nombre, $precio, $stock, $descripcion,
        $imagen_url, $null, $imagen_mime,
        $id_categoria, $id_subcategoria, $id
    );
    $stmt->send_long_data(5, $imagen_data);
} else {
    // Solo URL (o sin cambio de imagen): limpia cualquier blob anterior
    $stmt = $conn->prepare(
        "UPDATE productos
         SET nombre=?, precio=?, stock=?, descripcion=?,
             imagen_url=?, imagen_data=NULL, imagen_mime=NULL,
             id_categoria=?, id_subcategoria=?
         WHERE id_producto=?"
    );
    $stmt->bind_param(
        "sdissiii",
        $nombre, $precio, $stock, $descripcion,
        $imagen_url, $id_categoria, $id_subcategoria, $id
    );
}

if (!$stmt->execute()) {
    die("Error al actualizar producto: " . $stmt->error);
}
$stmt->close();

header("Location: ../administracion.php");
exit();

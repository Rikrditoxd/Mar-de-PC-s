<?php
session_start();
include("config/conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id_usuario'];

$sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
$user = $conn->query($sql)->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mi perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">

    <h2>Mi perfil</h2>

    <form action="acciones/actualizar_perfil.php" method="POST">

        <input type="hidden" name="id" value="<?= $user['id_usuario'] ?>">

        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?= $user['nombre'] ?>">

        <label class="mt-2">Email</label>
        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>">

        <label class="mt-2">Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="<?= $user['telefono'] ?>">

        <label class="mt-2">Dirección</label>
        <input type="text" name="direccion" class="form-control" value="<?= $user['direccion'] ?>">

        <br>

        <button class="btn btn-success">
            Guardar cambios
        </button>

    </form>

</div>

<br>
<?php include("includes/footer.php"); ?>
</body>
</html>
<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Mar de PC's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-center">Iniciar sesión</h4>
        </div>
        <div class="card-body">
            <form action="acciones/validar_login.php" method="POST" novalidate>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required
                        placeholder="tu@email.com" autocomplete="email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required
                        autocomplete="current-password">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>

            </form>

            <hr>
            <p class="text-center mb-0">
                ¿No tienes cuenta?
                <a href="registro.php">Regístrate aquí</a>
            </p>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>

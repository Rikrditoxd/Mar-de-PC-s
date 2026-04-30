<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4">Iniciar sesión</h2>

    <form action="acciones/validar_login.php" method="POST">

        <label>Email</label>
        <input type="email" name="email" class="form-control" required>

        <label class="mt-2">Contraseña</label>
        <input type="password" name="password" class="form-control" required>

        <br>

        <button type="submit" class="btn btn-primary w-100">
            Entrar
        </button>

    </form>

</div>

</body>
</html>
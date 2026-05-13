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
    <title>Registro - Mar de PC's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container my-5" style="max-width: 700px;">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0 text-center">Crear cuenta</h4>
        </div>
        <div class="card-body">
            <form action="acciones/guardar_registro.php" method="POST" novalidate id="formRegistro">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required
                            placeholder="Tu nombre" maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" required
                            placeholder="Tus apellidos" maxlength="150">
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" required
                            placeholder="tu@email.com" autocomplete="email">
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" name="telefono" id="telefono" class="form-control"
                            placeholder="600 000 000" maxlength="20">
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" required
                            minlength="6" placeholder="Mínimo 6 caracteres" autocomplete="new-password">
                        <div class="form-text">Al menos 6 caracteres.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirm" class="form-label">Repetir contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control" required
                            minlength="6" placeholder="Repite la contraseña" autocomplete="new-password">
                    </div>

                    <div class="col-12">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control"
                            placeholder="Calle, número, piso..." maxlength="200">
                    </div>

                    <div class="col-md-6">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" class="form-control"
                            placeholder="Tu ciudad" maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label for="codigo_postal" class="form-label">Código Postal</label>
                        <input type="text" name="codigo_postal" id="codigo_postal" class="form-control"
                            placeholder="12345" maxlength="10" pattern="\d{4,10}">
                    </div>

                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-success btn-lg">Registrarse</button>
                </div>

            </form>

            <hr>
            <p class="text-center mb-0">
                ¿Ya tienes cuenta?
                <a href="login.php">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
</div>

<script>
document.getElementById('formRegistro').addEventListener('submit', function(e) {
    const pass = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirm').value;
    if (pass !== confirm) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
        document.getElementById('password_confirm').focus();
    }
});
</script>

<?php include("includes/footer.php"); ?>
</body>
</html>

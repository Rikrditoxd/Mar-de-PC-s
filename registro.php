<?php include("config/conexion.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <h2>Registro de usuario</h2>

    <form action="acciones/guardar_registro.php" method="POST">

        <div class="row">

            <div class="col-md-6">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label>Apellidos</label>
                <input type="text" name="apellidos" class="form-control" required>
            </div>

            <div class="col-md-6 mt-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6 mt-2">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>

            <div class="col-md-6 mt-2">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-md-6 mt-2">
                <label>Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </div>

            <div class="col-md-6 mt-2">
                <label>Ciudad</label>
                <input type="text" name="ciudad" class="form-control">
            </div>

            <div class="col-md-6 mt-2">
                <label>Código Postal</label>
                <input type="text" name="codigo_postal" class="form-control">
            </div>

        </div>

        <br>

        <button type="submit" class="btn btn-success w-100">
            Registrarse
        </button>

    </form>
</div>

</body>
</html>
<?php

session_start();
include("config/conexion.php");

$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include("includes/navbar.php"); ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Panel de Administración</h1>

            <a href="acciones/crear_producto.php" class="btn btn-success">
                + Añadir producto
            </a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $fila['id_producto'] ?></td>
                        <td><?= $fila['nombre'] ?></td>
                        <td><?= $fila['precio'] ?> €</td>
                        <td><?= $fila['stock'] ?></td>
                        <td>
                            <img src="<?= $fila['imagen_url'] ?>" width="50">
                        </td>
                        <td>
                            <a href="acciones/editar_producto.php?id=<?= $fila['id_producto'] ?>" class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="acciones/eliminar_producto.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $fila['id_producto'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>
<?php
include("conexion.php");

$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("navbar.php"); ?>

<div class="container mt-4">
    <h1>Panel de Administración</h1>

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
            <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $fila['id_producto'] ?></td>
                    <td><?= $fila['nombre'] ?></td>
                    <td><?= $fila['precio'] ?> €</td>
                    <td><?= $fila['stock'] ?></td>
                    <td>
                        <img src="<?= $fila['imagen_url'] ?>" width="50">
                    </td>
                    <td>
                        <a href="editar_producto.php?id=<?= $fila['id_producto'] ?>" class="btn btn-warning btn-sm">
                            Editar
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
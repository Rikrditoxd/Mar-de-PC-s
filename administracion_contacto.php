<?php
session_start();
include("config/conexion.php");

// SOLO ADMIN
if (!isset($_SESSION['administrador']) || $_SESSION['administrador'] != 1) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM contactos ORDER BY fecha DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .mensaje-largo {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;

    max-height: 400px;
    overflow-y: auto;
}
    </style>
</head>
<?php include("includes/navbar.php"); ?>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Mensajes de contacto</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nombre'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['telefono'] ?></td>
                        <td><?= $row['asunto'] ?></td>

                        <!-- si el mensaje es muy largo "ver mas" -->
                        <td>
                            <?= substr($row['mensaje'], 0, 50) ?>...
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal<?= $row['id_contacto'] ?>">
                                Ver
                            </button>
                        </td>
                        <td><?= $row['fecha'] ?></td>
                    </tr>

                    <!-- modal para mostrar el mensaje -->

                    <div class="modal fade" id="modal<?= $row['id_contacto'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Mensaje completo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body mensaje-largo">
                                    <?= nl2br($row['mensaje']) ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>




<?php include("includes/footer.php"); ?>
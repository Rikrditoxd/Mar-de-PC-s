<?php
session_start();
include("../config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM pedidos WHERE id_pedido = $id";
$result = $conn->query($sql);
$pedido = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Editar estado del pedido #<?= $pedido['id_pedido'] ?></h2>

    <form action="actualizar_pedido.php" method="POST">

        <input type="hidden" name="id" value="<?= $pedido['id_pedido'] ?>">

        <label>Estado</label>

        <select name="estado" class="form-control">

            <option value="pendiente" <?= $pedido['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="pagado" <?= $pedido['estado'] == 'pagado' ? 'selected' : '' ?>>Pagado</option>
            <option value="enviado" <?= $pedido['estado'] == 'enviado' ? 'selected' : '' ?>>Enviado</option>
            <option value="entregado" <?= $pedido['estado'] == 'entregado' ? 'selected' : '' ?>>Entregado</option>

        </select>

        <br>

        <button class="btn btn-success">Guardar</button>

    </form>

</div>

</body>
</html>
<?php

include("conexion.php");

$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="style.css">
</head>
 <?php include("navbar.php"); ?>
<body>


<div class="container mt-4">
    <h1>Catálogo de productos</h1>

    <div class="row">
        <?php while($fila = $resultado->fetch_assoc()): ?>
            
            <div class="col-md-4 mb-4">
                <div class="card">
                    
                    <!-- Si tienes imagen -->
                    <img src="<?= $fila['imagen_url'] ?>" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title"><?= $fila['nombre'] ?></h5>
                        <p class="card-text"><?= $fila['descripcion'] ?></p>
                        <p><strong><?= $fila['precio'] ?> €</strong></p>
                    </div>

                     <!-- BOTÓN COMPRAR
                    <form action="carrito.php" method="POST">
                        <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                        <button type="submit" class="btn btn-primary w-100">
                            Añadir al carrito
                        </button>
                    </form> -->
                    
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
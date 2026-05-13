<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION['id_usuario']) || $_SESSION['administrador'] != 1) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../administracion.php");
    exit();
}

$id = intval($_GET['id']);

// producto
$sql = "SELECT * FROM productos WHERE id_producto = $id";
$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error: " . $conn->error);
}

$producto = $resultado->fetch_assoc();


// categorías
$sql_cat = "SELECT * FROM categorias";
$categorias = $conn->query($sql_cat);

// subcategorías
$sql_sub = "SELECT * FROM subcategorias";
$res_sub = $conn->query($sql_sub);

$subcategorias = [];

while ($row = $res_sub->fetch_assoc()) {
    $subcategorias[$row['id_categoria']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto - Mar de PC's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container mt-4">

    <h2>Editar producto</h2>

    <!-- FORMULARIO PRINCIPAL -->
    <form action="../acciones/actualizar_producto.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id_producto" value="<?= (int)$producto['id_producto'] ?>">

        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" class="form-control" required>

        <label>Precio</label>
        <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>" class="form-control" required min="0">

        <label>Stock</label>
        <input type="number" name="stock" value="<?= htmlspecialchars($producto['stock']) ?>" class="form-control" min="0">

        <label>Descripción</label>
        <input type="text" name="descripcion" value="<?= htmlspecialchars($producto['descripcion']) ?>" class="form-control">

        <!-- ========================= -->
        <!-- IMAGEN PRINCIPAL -->
        <!-- ========================= -->
        <label class="mt-3">Imagen principal</label>

        <?php if (!empty($producto['imagen_url'])): ?>
            <div class="mb-2">
                <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" width="120" class="img-thumbnail" alt="Imagen actual">
                <small class="text-muted d-block mt-1">Imagen actual</small>
            </div>
        <?php endif; ?>

        <label class="form-label small mt-2">Subir nueva imagen desde archivo <span class="text-muted">(JPG, PNG, GIF, WEBP · máx 5 MB)</span></label>
        <input type="file" name="imagen_file" class="form-control mb-2" accept="image/jpeg,image/png,image/gif,image/webp">

        <label class="form-label small">O indicar URL externa</label>
        <input type="text" name="imagen_url" value="<?= htmlspecialchars($producto['imagen_url']) ?>" class="form-control" placeholder="https://...">
        <small class="text-muted">Si subes un archivo, la URL se ignorará.</small>

        <!-- ========================= -->
        <!-- CATEGORÍA -->
        <!-- ========================= -->
        <label class="mt-3">Categoría</label>
        <select name="id_categoria" id="categoria" class="form-control">

            <?php while ($cat = $categorias->fetch_assoc()): ?>
                <option value="<?= (int)$cat['id_categoria'] ?>"
                    <?= ($producto['id_categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nombre']) ?>
                </option>
            <?php endwhile; ?>

        </select>

        <!-- ========================= -->
        <!-- SUBCATEGORÍA -->
        <!-- ========================= -->
        <label class="mt-3">Subcategoría</label>

        <select name="id_subcategoria" id="subcategoria" class="form-control">

            <option value="">-- Selecciona --</option>

            <?php foreach ($subcategorias as $id_cat => $subs): ?>
                <?php foreach ($subs as $sub): ?>
                    <option value="<?= (int)$sub['id_subcategoria'] ?>"
                        data-cat="<?= (int)$sub['id_categoria'] ?>"
                        <?= ($producto['id_subcategoria'] == $sub['id_subcategoria']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sub['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endforeach; ?>

        </select>

        <br>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
    </form>

    <hr>

    <!-- ========================= -->
    <!-- IMÁGENES -->
    <!-- ========================= -->

    <h5>Imágenes del producto</h5>

    <?php
    $sql_imgs = "SELECT * FROM producto_imagenes WHERE id_producto = $id";
    $imagenes = $conn->query($sql_imgs);
    ?>

    <ul class="list-group mb-3">
        <?php while ($img = $imagenes->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <img src="<?= htmlspecialchars($img['imagen_url']) ?>" width="80" alt="Imagen producto">

                <form action="../acciones/eliminar_imagen.php" method="POST">
                    <input type="hidden" name="id_imagen" value="<?= (int)$img['id_imagen'] ?>">
                    <button class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- añadir imagen -->
    <form action="../acciones/agregar_imagen.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

        <label class="form-label small">Subir imagen desde archivo <span class="text-muted">(JPG, PNG, GIF, WEBP · máx 5 MB)</span></label>
        <input type="file" name="imagen_file" class="form-control mb-2" accept="image/jpeg,image/png,image/gif,image/webp">

        <label class="form-label small">O indicar URL externa</label>
        <input type="text" name="imagen_url" class="form-control" placeholder="https://...">
        <small class="text-muted">Si subes un archivo, la URL se ignorará.</small>

        <button class="btn btn-primary mt-2">Añadir imagen</button>
    </form>

    <a href="../administracion.php" class="btn btn-secondary mt-3">Volver</a>

</div>

<?php include("../includes/footer.php"); ?>

<!-- JS FILTRO SUBCATEGORÍA -->
<script>
const subcategorias = <?= json_encode($subcategorias); ?>;

const categoria = document.getElementById("categoria");
const subSelect = document.getElementById("subcategoria");

function filtrarSub() {
    const id = categoria.value;

    subSelect.innerHTML = '<option value="">-- Selecciona --</option>';

    if (subcategorias[id]) {
        subcategorias[id].forEach(sub => {

            const option = document.createElement("option");
            option.value = sub.id_subcategoria;
            option.textContent = sub.nombre;

            subSelect.appendChild(option);
        });
    }
}

categoria.addEventListener("change", filtrarSub);
</script>
</body>
</html>
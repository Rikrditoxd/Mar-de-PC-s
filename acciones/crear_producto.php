<?php


include("../config/conexion.php");

$categorias = $conn->query("SELECT * FROM categorias");

// traer subcategorias
$sql = "SELECT * FROM subcategorias";
$result = $conn->query($sql);

$subcategorias = [];

while ($row = $result->fetch_assoc()) {
    $subcategorias[$row['id_categoria']][] = $row;
}
?>






<!DOCTYPE html>
<html>

<head>
    <title>Crear producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>



    <div class="container mt-4">
        <h2>Crear nuevo producto</h2>

        <form action="guardar_producto.php" method="POST">

            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>

            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>

            <label>Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>

            <label>Stock</label>
            <input type="number" name="stock" class="form-control" required>

            <label>Seleccione Categoria</label>
            <select name="id_categoria" id="categoria" class="form-control" required>
                <option value="">-- Selecciona --</option>
                <?php while ($cat = $categorias->fetch_assoc()): ?>
                    <option value="<?= $cat['id_categoria'] ?>">
                        <?= $cat['nombre'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <br>

            <!-- SUBCATEGORÍA (OCULTA AL INICIO) -->
            <div id="subcategoria-box" style="display:none;">
                <label>Subcategoría</label>
                <select name="id_subcategoria" id="subcategoria" class="form-control">
                    <option value="">-- Selecciona subcategoría --</option>
                </select>
            </div>

            <label>Imagen URL</label>
            <input type="text" name="imagen_url" class="form-control" required>

            <br>
            <button type="submit" class="btn btn-success">Guardar</button>

        </form>
    </div>



    <!-- script para el formulario con subcategorias -->

    <script>
const subcategorias = <?= json_encode($subcategorias); ?>;

const categoriaSelect = document.getElementById("categoria");
const subBox = document.getElementById("subcategoria-box");
const subSelect = document.getElementById("subcategoria");

categoriaSelect.addEventListener("change", function() {

    const id = parseInt(this.value);

    subSelect.innerHTML = '<option value="">-- Selecciona subcategoría --</option>';

    if (subcategorias[id]) {

        subcategorias[id].forEach(sub => {
            const option = document.createElement("option");
            option.value = sub.id_subcategoria;
            option.textContent = sub.nombre;
            subSelect.appendChild(option);
        });

        subBox.style.display = "block";

    } else {
        subBox.style.display = "none";
    }
});
</script>
</body>

</html>
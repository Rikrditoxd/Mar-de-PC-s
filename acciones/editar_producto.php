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
$guardado_ok = isset($_GET['ok']);

$sql = "SELECT * FROM productos WHERE id_producto = $id";
$resultado = $conn->query($sql);

if (!$resultado || $resultado->num_rows === 0) {
    header("Location: ../administracion.php");
    exit();
}
$producto = $resultado->fetch_assoc();

// Categorías
$categorias = $conn->query("SELECT * FROM categorias ORDER BY nombre ASC");

// Subcategorías agrupadas
$res_sub = $conn->query("SELECT * FROM subcategorias ORDER BY nombre ASC");
$subcategorias = [];
while ($row = $res_sub->fetch_assoc()) {
    $subcategorias[$row['id_categoria']][] = $row;
}

// URL de preview con cache-busting si es imagen servida desde BD
$preview_url = $producto['imagen_url'] ?? '';
if ($preview_url && strpos($preview_url, 'servir_imagen.php') !== false) {
    // Reemplazamos el ?t= anterior si lo tiene, o añadimos uno nuevo
    $preview_url = preg_replace('/([&?])t=\d+/', '$1t=' . time(), $preview_url);
    if (strpos($preview_url, '&t=') === false && strpos($preview_url, '?t=') === false) {
        $preview_url .= '&t=' . time();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar: <?= htmlspecialchars($producto['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        #preview-principal {
            max-width: 100%;
            max-height: 260px;
            object-fit: contain;
            border-radius: 6px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 6px;
        }
        .img-adicional {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 4px;
        }
        .card-adicional {
            height: auto;   /* anula el height:100% global para este contexto */
        }
    </style>
</head>
<body>



<div class="container my-4">

    <!-- Cabecera -->
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h2 class="mb-0">Editar producto</h2>
            <small class="text-muted"><?= htmlspecialchars($producto['nombre']) ?></small>
        </div>
        <a href="../administracion.php" class="btn btn-outline-secondary btn-sm">← Volver</a>
    </div>

    <?php if ($guardado_ok): ?>
        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
            Cambios guardados correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════ -->
    <!--  FORMULARIO PRINCIPAL                         -->
    <!-- ══════════════════════════════════════════════ -->
    <form action="../acciones/actualizar_producto.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_producto" value="<?= (int)$producto['id_producto'] ?>">

        <div class="row g-4">

            <!-- Col izquierda: datos del producto -->
            <div class="col-lg-7">
                <div class="card shadow-sm h-auto">
                    <div class="card-header bg-dark text-white py-2">
                        <strong>Datos del producto</strong>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre"
                                   value="<?= htmlspecialchars($producto['nombre']) ?>"
                                   class="form-control" required maxlength="255">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">Precio (€) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="precio"
                                       value="<?= htmlspecialchars($producto['precio']) ?>"
                                       class="form-control" required min="0">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">Stock</label>
                                <input type="number" name="stock"
                                       value="<?= htmlspecialchars($producto['stock']) ?>"
                                       class="form-control" min="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3"
                                      maxlength="1000"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">Categoría</label>
                                <select name="id_categoria" id="categoria" class="form-select">
                                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                                        <option value="<?= (int)$cat['id_categoria'] ?>"
                                            <?= ($producto['id_categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['nombre']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">Subcategoría</label>
                                <select name="id_subcategoria" id="subcategoria" class="form-select">
                                    <option value="">— Ninguna —</option>
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
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Guardar cambios
                        </button>

                    </div>
                </div>
            </div>

            <!-- Col derecha: imagen principal -->
            <div class="col-lg-5">
                <div class="card shadow-sm h-auto">
                    <div class="card-header bg-dark text-white py-2">
                        <strong>Imagen principal</strong>
                    </div>
                    <div class="card-body">

                        <!-- Preview -->
                        <div class="text-center mb-3">
                            <?php if (!empty($preview_url)): ?>
                                <img id="preview-principal"
                                     src="<?= htmlspecialchars($preview_url) ?>"
                                     alt="Imagen actual">
                                <p class="text-muted small mt-1 mb-0" id="preview-label">Imagen actual</p>
                            <?php else: ?>
                                <div id="preview-placeholder"
                                     class="d-flex align-items-center justify-content-center bg-light border rounded"
                                     style="height:160px; color:#aaa;">
                                    Sin imagen
                                </div>
                                <img id="preview-principal"
                                     src="" alt="Vista previa" style="display:none;">
                                <p class="text-muted small mt-1 mb-0" id="preview-label" style="display:none;"></p>
                            <?php endif; ?>
                        </div>

                        <hr class="my-2">

                        <!-- Subir archivo -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Subir archivo</label>
                            <input type="file" name="imagen_file" id="imagen_file"
                                   class="form-control form-control-sm"
                                   accept="image/jpeg,image/png,image/gif,image/webp">
                            <div class="form-text">JPG, PNG, GIF o WEBP · máx 5 MB</div>
                        </div>

                        <!-- URL externa -->
                        <div class="mb-0">
                            <label class="form-label small fw-semibold">O URL externa</label>
                            <input type="text" name="imagen_url"
                                   value="<?= htmlspecialchars($producto['imagen_url'] ?? '') ?>"
                                   class="form-control form-control-sm"
                                   placeholder="https://...">
                            <div class="form-text">Si subes un archivo, la URL se ignora.</div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>

    <hr class="my-4">

    <!-- ══════════════════════════════════════════════ -->
    <!--  IMÁGENES ADICIONALES                         -->
    <!-- ══════════════════════════════════════════════ -->
    <h5 class="mb-3">Imágenes adicionales</h5>

    <?php
    $sql_imgs = "SELECT * FROM producto_imagenes WHERE id_producto = $id";
    $imagenes = $conn->query($sql_imgs);
    $imgs_list = [];
    if ($imagenes) while ($img = $imagenes->fetch_assoc()) $imgs_list[] = $img;
    ?>

    <?php if (!empty($imgs_list)): ?>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3 mb-4">
            <?php foreach ($imgs_list as $img): ?>
                <div class="col">
                    <div class="card card-adicional text-center p-2">
                        <img src="<?= htmlspecialchars($img['imagen_url']) ?>"
                             class="img-adicional mx-auto d-block mb-2"
                             alt="Imagen adicional">
                        <form action="../acciones/eliminar_imagen.php" method="POST">
                            <input type="hidden" name="id_imagen" value="<?= (int)$img['id_imagen'] ?>">
                            <input type="hidden" name="id_producto" value="<?= $id ?>">
                            <button class="btn btn-danger btn-sm w-100">Eliminar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted small mb-3">No hay imágenes adicionales.</p>
    <?php endif; ?>

    <!-- Añadir imagen adicional -->
    <div class="card shadow-sm h-auto" style="max-width:500px;">
        <div class="card-header bg-dark text-white py-2">
            <strong>Añadir imagen adicional</strong>
        </div>
        <div class="card-body">
            <form action="../acciones/agregar_imagen.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_producto" value="<?= (int)$producto['id_producto'] ?>">

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Subir archivo</label>
                    <input type="file" name="imagen_file" class="form-control form-control-sm"
                           accept="image/jpeg,image/png,image/gif,image/webp">
                    <div class="form-text">JPG, PNG, GIF o WEBP · máx 5 MB</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">O URL externa</label>
                    <input type="text" name="imagen_url" class="form-control form-control-sm"
                           placeholder="https://...">
                    <div class="form-text">Si subes un archivo, la URL se ignora.</div>
                </div>

                <button class="btn btn-primary w-100">Añadir imagen</button>
            </form>
        </div>
    </div>

    <div class="mt-4 mb-2">
        <a href="../administracion.php" class="btn btn-outline-secondary btn-sm">← Volver al panel</a>
    </div>

</div>

<?php include("../includes/footer.php"); ?>

<script>
// ── Preview instantáneo al seleccionar archivo ────────────────
document.getElementById('imagen_file').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const img    = document.getElementById('preview-principal');
        const label  = document.getElementById('preview-label');
        const holder = document.getElementById('preview-placeholder');

        img.src              = e.target.result;
        img.style.display    = 'block';
        label.textContent    = 'Vista previa — ' + file.name;
        label.style.display  = 'block';
        if (holder) holder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});

// ── Filtro subcategorías ──────────────────────────────────────
const subcategorias = <?= json_encode($subcategorias) ?>;
const catSelect = document.getElementById('categoria');
const subSelect = document.getElementById('subcategoria');

function filtrarSub() {
    const id  = catSelect.value;
    const sel = subSelect.value; // mantener selección actual si encaja

    subSelect.innerHTML = '<option value="">— Ninguna —</option>';

    if (subcategorias[id]) {
        subcategorias[id].forEach(sub => {
            const opt      = document.createElement('option');
            opt.value      = sub.id_subcategoria;
            opt.textContent = sub.nombre;
            if (String(sub.id_subcategoria) === sel) opt.selected = true;
            subSelect.appendChild(opt);
        });
    }
}

catSelect.addEventListener('change', filtrarSub);
</script>
</body>
</html>

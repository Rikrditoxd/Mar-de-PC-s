<?php
session_start();
include("config/conexion.php");

if (!isset($_GET['id'])) {
    header("Location: catalogo.php");
    exit();
}

$id = intval($_GET['id']);

// Producto + categoría
$sql = "SELECT p.*, c.nombre AS cat_nombre
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
        WHERE p.id_producto = $id";
$resultado = $conn->query($sql);

if (!$resultado || $resultado->num_rows === 0) {
    header("Location: catalogo.php");
    exit();
}
$producto = $resultado->fetch_assoc();

// Imágenes
$imgs_array = [];
$res_imgs = $conn->query("SELECT imagen_url FROM producto_imagenes WHERE id_producto = $id");
if ($res_imgs && $res_imgs->num_rows > 0) {
    while ($img = $res_imgs->fetch_assoc()) {
        $imgs_array[] = $img['imagen_url'];
    }
}
if (empty($imgs_array)) {
    $imgs_array[] = $producto['imagen_url'];
}

// Reseñas
$sql_res = "SELECT r.puntuacion, r.comentario, r.creado_en, u.nombre AS nombre_usuario
            FROM resenas r
            LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario
            WHERE r.id_producto = $id
            ORDER BY r.creado_en DESC";
$res_resenas = $conn->query($sql_res);
$resenas = [];
$suma = 0;
if ($res_resenas) {
    while ($r = $res_resenas->fetch_assoc()) {
        $resenas[] = $r;
        $suma += $r['puntuacion'];
    }
}
$num_resenas = count($resenas);
$media = $num_resenas > 0 ? round($suma / $num_resenas, 1) : 0;

// Distribución por estrellas
$dist = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
foreach ($resenas as $r) {
    $dist[(int)$r['puntuacion']]++;
}

// ¿Ya reseñó este usuario?
$ya_reseno = false;
if (isset($_SESSION['id_usuario'])) {
    $uid = (int)$_SESSION['id_usuario'];
    $chk = $conn->query("SELECT id_resena FROM resenas WHERE id_producto=$id AND id_usuario=$uid LIMIT 1");
    $ya_reseno = ($chk && $chk->num_rows > 0);
}

// Productos relacionados (misma categoría)
$id_cat = (int)$producto['id_categoria'];
$res_rel = $conn->query(
    "SELECT * FROM productos
     WHERE id_categoria=$id_cat AND id_producto!=$id AND activo=1
     LIMIT 4"
);
$relacionados = [];
if ($res_rel) {
    while ($p = $res_rel->fetch_assoc()) $relacionados[] = $p;
}

function renderEstrellas(float $n, string $extra = ''): string {
    $r = round($n);
    $html = '<span class="text-warning ' . $extra . '">';
    for ($i = 1; $i <= 5; $i++) $html .= $i <= $r ? '★' : '☆';
    return $html . '</span>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($producto['nombre']) ?> - Mar de PC's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* ── Galería ── */
        #carouselProducto .carousel-item img {
            height: 420px;
            object-fit: contain;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .thumb-strip {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 6px 0 10px;
            scrollbar-width: thin;
            scrollbar-color: #ced4da transparent;
        }
        .thumb-item {
            flex-shrink: 0;
            width: 70px;
            height: 70px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            overflow: hidden;
            transition: border-color .15s;
            background: #f8f9fa;
        }
        .thumb-item img { width: 100%; height: 100%; object-fit: cover; }
        .thumb-item:hover, .thumb-item.active { border-color: #0d6efd; }

        /* ── Info ── */
        .precio-producto { font-size: 2rem; font-weight: 700; color: #0d6efd; }

        /* ── Reseñas ── */
        .review-card { border-left: 3px solid #0d6efd; }
        .rating-bar-bg   { height: 8px; background: #e9ecef; border-radius: 4px; flex: 1; }
        .rating-bar-fill { height: 8px; background: #ffc107; border-radius: 4px;
                           transition: width .4s ease; }

        /* ── Star input ── */
        .star-input span {
            font-size: 2rem;
            color: #ced4da;
            cursor: pointer;
            line-height: 1;
            transition: color .1s;
            user-select: none;
        }
        .star-input span.active { color: #ffc107; }

        /* ── Relacionados ── */
        .related-img {
            height: 150px;
            object-fit: contain;
            padding: 8px;
            background: #f8f9fa;
        }

        /* ── Fix: el .card global tiene height:100% para el catálogo,
              pero en la sección de reseñas eso provoca desbordamiento
              sobre los elementos siguientes. Se resetea aquí. ── */
        .resenas-section .card { height: auto; }
    </style>
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-4 mb-5">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="catalogo.php">Productos</a></li>
            <?php if (!empty($producto['cat_nombre'])): ?>
                <li class="breadcrumb-item">
                    <a href="catalogo.php?categoria=<?= (int)$producto['id_categoria'] ?>">
                        <?= htmlspecialchars($producto['cat_nombre']) ?>
                    </a>
                </li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page">
                <?= htmlspecialchars($producto['nombre']) ?>
            </li>
        </ol>
    </nav>

    <!-- ══════════════════════════════════════════ -->
    <!--  GALERÍA  +  INFO                         -->
    <!-- ══════════════════════════════════════════ -->
    <div class="row g-4 align-items-start mb-5">

        <!-- GALERÍA -->
        <div class="col-md-6">

            <div id="carouselProducto" class="carousel slide mb-2" data-bs-ride="false">
                <div class="carousel-inner">
                    <?php foreach ($imgs_array as $i => $img): ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars($img) ?>"
                                 class="d-block w-100"
                                 alt="<?= htmlspecialchars($producto['nombre']) ?> — imagen <?= $i + 1 ?>">
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($imgs_array) > 1): ?>
                    <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselProducto" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselProducto" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Miniaturas (estilo Amazon) -->
            <?php if (count($imgs_array) > 1): ?>
                <div class="thumb-strip">
                    <?php foreach ($imgs_array as $i => $img): ?>
                        <div class="thumb-item <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>">
                            <img src="<?= htmlspecialchars($img) ?>" alt="Vista <?= $i + 1 ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- INFO -->
        <div class="col-md-6">

            <h1 class="h2 mb-1"><?= htmlspecialchars($producto['nombre']) ?></h1>

            <!-- Valoración media (enlace a reseñas) -->
            <div class="d-flex align-items-center gap-2 mb-3">
                <?php if ($num_resenas > 0): ?>
                    <?= renderEstrellas($media, 'fs-5') ?>
                    <span class="fw-semibold"><?= number_format($media, 1) ?></span>
                    <a href="#resenas" class="text-muted text-decoration-none small">
                        (<?= $num_resenas ?> <?= $num_resenas === 1 ? 'reseña' : 'reseñas' ?>)
                    </a>
                <?php else: ?>
                    <span class="text-warning fs-5">☆☆☆☆☆</span>
                    <a href="#resenas" class="text-muted text-decoration-none small">Sin reseñas aún</a>
                <?php endif; ?>
            </div>

            <hr class="my-2">

            <!-- Precio -->
            <div class="precio-producto my-2">
                <?= number_format((float)$producto['precio'], 2, ',', '.') ?> €
            </div>

            <!-- Stock -->
            <?php if ($producto['stock'] > 0): ?>
                <div class="mb-3">
                    <?php if ($producto['stock'] <= 5): ?>
                        <span class="badge bg-warning text-dark">
                            ¡Solo quedan <?= (int)$producto['stock'] ?>!
                        </span>
                    <?php else: ?>
                        <span class="badge bg-success">En stock</span>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="mb-3">
                    <span class="badge bg-danger">Sin stock</span>
                </div>
            <?php endif; ?>

            <!-- Descripción -->
            <?php if (!empty($producto['descripcion'])): ?>
                <p class="text-muted mb-4"><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
            <?php endif; ?>

            <!-- Carrito -->
            <div class="mt-4">
                <?php if ($producto['stock'] > 0): ?>
                    <form action="acciones/agregar_carrito.php" method="POST"
                          class="d-flex flex-wrap align-items-center gap-3">
                        <input type="hidden" name="id_producto" value="<?= (int)$producto['id_producto'] ?>">
                        <input type="hidden" name="nombre"      value="<?= htmlspecialchars($producto['nombre']) ?>">
                        <input type="hidden" name="precio"      value="<?= (float)$producto['precio'] ?>">

                        <!-- Selector cantidad -->
                        <div class="input-group" style="width: 120px;">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnMenos">−</button>
                            <input type="number" name="cantidad" id="cantidad"
                                   value="1" min="1" max="<?= (int)$producto['stock'] ?>"
                                   class="form-control form-control-sm text-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnMas">+</button>
                        </div>

                        <button type="submit" class="btn btn-primary px-4">
                            🛒 Añadir al carrito
                        </button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-secondary px-4" disabled>Sin stock</button>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!--  RESEÑAS                                  -->
    <!-- ══════════════════════════════════════════ -->
    <hr class="my-4">
    <div class="row g-4 align-items-start resenas-section" id="resenas">

        <!-- Lista -->
        <div class="col-lg-8">
            <h4 class="mb-4">Reseñas de clientes</h4>

            <?php if (empty($resenas)): ?>
                <p class="text-muted">Todavía no hay reseñas para este producto.</p>
            <?php else: ?>
                <?php foreach ($resenas as $r): ?>
                    <div class="card review-card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div>
                                    <strong><?= htmlspecialchars($r['nombre_usuario'] ?? 'Usuario') ?></strong>
                                    <span class="ms-2 text-warning">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?= $i <= (int)$r['puntuacion'] ? '★' : '☆' ?>
                                        <?php endfor; ?>
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <?= date('d/m/Y', strtotime($r['creado_en'])) ?>
                                </small>
                            </div>
                            <p class="mb-0 mt-2 text-muted">
                                <?= nl2br(htmlspecialchars($r['comentario'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Resumen + formulario -->
        <div class="col-lg-4" style="position: sticky; top: 80px; align-self: flex-start;">

            <!-- Puntuación global -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="display-4 fw-bold text-warning lh-1 mb-1">
                        <?= $num_resenas > 0 ? number_format($media, 1) : '—' ?>
                    </div>
                    <div class="text-warning fs-4 mb-1">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?= $i <= round($media) ? '★' : '☆' ?>
                        <?php endfor; ?>
                    </div>
                    <small class="text-muted">
                        <?= $num_resenas ?> <?= $num_resenas === 1 ? 'reseña' : 'reseñas' ?>
                    </small>

                    <?php if ($num_resenas > 0): ?>
                        <div class="mt-3 text-start">
                            <?php foreach ([5, 4, 3, 2, 1] as $e): ?>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <small class="text-muted fw-semibold" style="width:10px"><?= $e ?></small>
                                    <span class="text-warning" style="font-size:.75rem; width:12px">★</span>
                                    <div class="rating-bar-bg">
                                        <div class="rating-bar-fill"
                                             style="width:<?= $num_resenas > 0 ? round($dist[$e] / $num_resenas * 100) : 0 ?>%">
                                        </div>
                                    </div>
                                    <small class="text-muted" style="width:16px; text-align:right">
                                        <?= $dist[$e] ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Formulario reseña -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Escribe una reseña</h6>

                    <?php if (!isset($_SESSION['id_usuario'])): ?>
                        <p class="text-muted small mb-0">
                            <a href="login.php">Inicia sesión</a> para dejar una reseña.
                        </p>
                    <?php elseif ($ya_reseno): ?>
                        <p class="text-success small mb-0">✓ Ya has reseñado este producto.</p>
                    <?php else: ?>
                        <form action="acciones/guardar_resena.php" method="POST">
                            <input type="hidden" name="id_producto" value="<?= (int)$id ?>">

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Tu puntuación</label>
                                <div class="star-input d-flex gap-1" id="starInput">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span data-val="<?= $i ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="puntuacion" id="puntuacionInput" value="0">
                                <div id="starError" class="text-danger small mt-1" style="display:none">
                                    Selecciona una puntuación.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Tu comentario</label>
                                <textarea name="comentario" class="form-control" rows="4"
                                          placeholder="Cuéntanos tu experiencia..."
                                          maxlength="1000" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"
                                    id="btnResena">Publicar reseña</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!--  PRODUCTOS RELACIONADOS                   -->
    <!-- ══════════════════════════════════════════ -->
    <?php if (!empty($relacionados)): ?>
        <hr class="my-5">
        <h4 class="mb-4">Productos relacionados</h4>
        <div class="row row-cols-2 row-cols-md-4 g-3">
            <?php foreach ($relacionados as $rel): ?>
                <div class="col">
                    <a href="producto.php?id=<?= (int)$rel['id_producto'] ?>" class="card-link">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($rel['imagen_url']) ?>"
                                 class="card-img-top related-img"
                                 alt="<?= htmlspecialchars($rel['nombre']) ?>">
                            <div class="card-body p-2">
                                <p class="card-text small fw-semibold mb-1 lh-sm">
                                    <?= htmlspecialchars($rel['nombre']) ?>
                                </p>
                                <p class="card-text text-primary fw-bold mb-0">
                                    <?= number_format((float)$rel['precio'], 2, ',', '.') ?> €
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include("includes/footer.php"); ?>

<script>
// ── Miniaturas ──────────────────────────────────────────────
const thumbItems = document.querySelectorAll('.thumb-item');
const carouselEl = document.getElementById('carouselProducto');

if (carouselEl && thumbItems.length) {
    const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);

    thumbItems.forEach(t => {
        t.addEventListener('click', () => bsCarousel.to(parseInt(t.dataset.index)));
    });

    carouselEl.addEventListener('slid.bs.carousel', e => {
        thumbItems.forEach(t =>
            t.classList.toggle('active', parseInt(t.dataset.index) === e.to)
        );
    });
}

// ── Selector de cantidad ─────────────────────────────────────
const qInput  = document.getElementById('cantidad');
const btnMenos = document.getElementById('btnMenos');
const btnMas   = document.getElementById('btnMas');

btnMenos?.addEventListener('click', () => {
    if (parseInt(qInput.value) > 1) qInput.value = parseInt(qInput.value) - 1;
});
btnMas?.addEventListener('click', () => {
    if (parseInt(qInput.value) < parseInt(qInput.max)) qInput.value = parseInt(qInput.value) + 1;
});

// ── Star input ───────────────────────────────────────────────
const starSpans = document.querySelectorAll('#starInput span');
const punInput  = document.getElementById('puntuacionInput');
const starError = document.getElementById('starError');

function paintStars(val) {
    starSpans.forEach(s => s.classList.toggle('active', parseInt(s.dataset.val) <= val));
}

starSpans.forEach(s => {
    s.addEventListener('mouseover', () => paintStars(parseInt(s.dataset.val)));
    s.addEventListener('click',     () => {
        punInput.value = s.dataset.val;
        paintStars(parseInt(s.dataset.val));
        starError?.style && (starError.style.display = 'none');
    });
});

document.getElementById('starInput')?.addEventListener('mouseleave',
    () => paintStars(parseInt(punInput.value)));

document.getElementById('btnResena')?.addEventListener('click', function(e) {
    if (parseInt(punInput.value) < 1) {
        e.preventDefault();
        starError.style.display = 'block';
    }
});
</script>
</body>
</html>

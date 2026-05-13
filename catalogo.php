<?php
session_start();
include("config/conexion.php");

$sql = "SELECT * FROM productos WHERE activo = 1";

$active_cat = isset($_GET['categoria'])    ? intval($_GET['categoria'])    : 0;
$active_sub = isset($_GET['subcategoria']) ? intval($_GET['subcategoria']) : 0;
$buscar     = isset($_GET['buscar'])       ? trim($_GET['buscar'])         : '';

if ($active_cat > 0) {
    $sql .= " AND id_categoria = $active_cat";
}
if ($active_sub > 0) {
    $sql .= " AND id_subcategoria = $active_sub";
}
if ($buscar !== '') {
    $b = $conn->real_escape_string($buscar);
    $sql .= " AND nombre LIKE '%$b%'";
}

$sql .= " ORDER BY nombre ASC";

$resultado = $conn->query($sql);

$sql_cat = "SELECT * FROM categorias ORDER BY nombre ASC";
$categorias = $conn->query($sql_cat);

$sql_sub = "SELECT * FROM subcategorias ORDER BY nombre ASC";
$result_sub = $conn->query($sql_sub);

$subcategorias = [];
while ($row = $result_sub->fetch_assoc()) {
    $subcategorias[$row['id_categoria']][] = $row;
}

$productos = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Mar de PC's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: contain;
            padding: 10px;
            background-color: #f8f9fa;
        }

        .card-desc {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            font-size: .875rem;
            color: #6c757d;
            min-height: 2.6em;
        }

        /* Sidebar hamburguesa en móvil */
        #sidebar-toggle { display: none; }

        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 1040;
        }

        @media (max-width: 767px) {
            #sidebar-toggle {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 1rem;
            }
            #sidebar-col {
                position: fixed;
                top: 0; left: -280px;
                width: 280px; height: 100%;
                z-index: 1050;
                background: #fff;
                box-shadow: 2px 0 12px rgba(0,0,0,.15);
                transition: left .3s ease;
                overflow-y: auto;
                padding: 1rem;
            }
            #sidebar-col.open  { left: 0; }
            #sidebar-overlay.open { display: block; }
            #sidebar-close { display: flex; }
        }

        #sidebar-close { display: none; }

        /* Links del sidebar */
        .cat-link {
            display: block;
            padding: .35rem .5rem;
            border-radius: .25rem;
            color: #212529;
            text-decoration: none;
            transition: background .15s;
            font-size: .9rem;
        }
        .cat-link:hover { background: #f0f0f0; color: #0d6efd; }
        .cat-link.active { background: #e7f0ff; color: #0d6efd; font-weight: 600; }

        .subcat-link {
            display: block;
            padding: .25rem .5rem .25rem 1rem;
            border-radius: .25rem;
            color: #555;
            text-decoration: none;
            font-size: .82rem;
            transition: background .15s;
        }
        .subcat-link:hover { background: #f0f0f0; color: #0d6efd; }
        .subcat-link.active { color: #0d6efd; font-weight: 600; }
    </style>
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container-fluid mt-4 mb-5">
    <div class="row">

        <!-- BOTÓN HAMBURGUESA (solo móvil) -->
        <div class="col-12">
            <button id="sidebar-toggle" class="btn btn-outline-secondary btn-sm">
                &#9776; Categorías
            </button>
        </div>

        <!-- OVERLAY -->
        <div id="sidebar-overlay"></div>

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2" id="sidebar-col">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <strong>Categorías</strong>
                <button id="sidebar-close" class="btn btn-sm btn-outline-secondary">&times;</button>
            </div>

            <div class="p-2">
                <a href="catalogo.php" class="cat-link <?= ($active_cat === 0 && $active_sub === 0 && $buscar === '') ? 'active' : '' ?>">
                    Todos los productos
                </a>

                <?php
                // Reiniciamos el puntero del resultado
                $categorias->data_seek(0);
                while ($cat = $categorias->fetch_assoc()):
                    $isActiveCat = ($active_cat === (int)$cat['id_categoria']);
                ?>
                    <div class="mt-2">
                        <a href="catalogo.php?categoria=<?= (int)$cat['id_categoria'] ?>"
                           class="cat-link <?= $isActiveCat ? 'active' : '' ?>">
                            <?= htmlspecialchars($cat['nombre']) ?>
                        </a>

                        <?php if (isset($subcategorias[$cat['id_categoria']])): ?>
                            <div class="mt-1">
                                <?php foreach ($subcategorias[$cat['id_categoria']] as $sub): ?>
                                    <a href="catalogo.php?subcategoria=<?= (int)$sub['id_subcategoria'] ?>"
                                       class="subcat-link <?= $active_sub === (int)$sub['id_subcategoria'] ? 'active' : '' ?>">
                                        — <?= htmlspecialchars($sub['nombre']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="col-md-9 col-lg-10">

            <!-- Barra de búsqueda -->
            <form method="GET" action="catalogo.php" class="mb-4">
                <?php if ($active_cat > 0): ?>
                    <input type="hidden" name="categoria" value="<?= $active_cat ?>">
                <?php endif; ?>
                <?php if ($active_sub > 0): ?>
                    <input type="hidden" name="subcategoria" value="<?= $active_sub ?>">
                <?php endif; ?>
                <div class="input-group" style="max-width: 450px;">
                    <input type="text" name="buscar" class="form-control"
                           placeholder="Buscar producto..."
                           value="<?= htmlspecialchars($buscar) ?>">
                    <button class="btn btn-primary">Buscar</button>
                    <?php if ($buscar !== ''): ?>
                        <a href="catalogo.php<?= $active_cat ? '?categoria='.$active_cat : '' ?>"
                           class="btn btn-outline-secondary">✕</a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Cabecera con contador -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-muted fw-normal">
                    <?php if ($buscar !== ''): ?>
                        Resultados para <strong>"<?= htmlspecialchars($buscar) ?>"</strong>
                    <?php elseif ($active_sub > 0): ?>
                        Subcategoría seleccionada
                    <?php elseif ($active_cat > 0): ?>
                        Categoría seleccionada
                    <?php else: ?>
                        Todos los productos
                    <?php endif; ?>
                </h5>
                <small class="text-muted"><?= count($productos) ?> resultado<?= count($productos) !== 1 ? 's' : '' ?></small>
            </div>

            <!-- GRID DE PRODUCTOS -->
            <?php if (count($productos) > 0): ?>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                    <?php foreach ($productos as $fila): ?>
                        <div class="col">
                            <a href="producto.php?id=<?= (int)$fila['id_producto'] ?>" class="card-link">
                                <div class="card h-100">
                                    <img src="<?= htmlspecialchars($fila['imagen_url']) ?>"
                                         class="card-img-top"
                                         alt="<?= htmlspecialchars($fila['nombre']) ?>"
                                         loading="lazy">
                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-1 lh-sm">
                                            <?= htmlspecialchars($fila['nombre']) ?>
                                        </h6>
                                        <p class="card-desc mb-2">
                                            <?= htmlspecialchars($fila['descripcion']) ?>
                                        </p>
                                        <p class="mb-0 fw-bold text-primary">
                                            <?= number_format((float)$fila['precio'], 2, ',', '.') ?> €
                                        </p>
                                    </div>
                                    <?php if ($fila['stock'] <= 0): ?>
                                        <div class="card-footer py-1 bg-danger bg-opacity-10 border-0">
                                            <small class="text-danger">Sin stock</small>
                                        </div>
                                    <?php elseif ($fila['stock'] <= 5): ?>
                                        <div class="card-footer py-1 bg-warning bg-opacity-10 border-0">
                                            <small class="text-warning">Quedan <?= (int)$fila['stock'] ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <div style="font-size:3rem;">🔍</div>
                    <h5 class="mt-3">No se encontraron productos</h5>
                    <p class="small">Prueba con otros términos o
                        <a href="catalogo.php">ver todos los productos</a>.
                    </p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script>
const toggle   = document.getElementById('sidebar-toggle');
const sidebar  = document.getElementById('sidebar-col');
const overlay  = document.getElementById('sidebar-overlay');
const closeBtn = document.getElementById('sidebar-close');

function openSidebar()  { sidebar.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }

toggle?.addEventListener('click', openSidebar);
closeBtn?.addEventListener('click', closeSidebar);
overlay?.addEventListener('click', closeSidebar);
</script>
</body>
</html>

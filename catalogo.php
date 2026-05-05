<?php
session_start();
include("config/conexion.php");

$sql = "SELECT * FROM productos WHERE 1=1";

if (isset($_GET['categoria']) && $_GET['categoria'] != "") {
    $categoria = intval($_GET['categoria']);
    $sql .= " AND id_categoria = $categoria";
}

if (isset($_GET['subcategoria']) && $_GET['subcategoria'] != "") {
    $sub = intval($_GET['subcategoria']);
    $sql .= " AND id_subcategoria = $sub";
}

if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $buscar = $conn->real_escape_string($_GET['buscar']);
    $sql .= " AND nombre LIKE '%$buscar%'";
}

$resultado = $conn->query($sql);

$sql_cat = "SELECT * FROM categorias";
$categorias = $conn->query($sql_cat);

$sql_sub = "SELECT * FROM subcategorias";
$result_sub = $conn->query($sql_sub);

$subcategorias = [];
while ($row = $result_sub->fetch_assoc()) {
    $subcategorias[$row['id_categoria']][] = $row;
}

$productos = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

$urls_base64 = base64_encode(json_encode(array_column($productos, 'imagen_url')));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: contain;
            padding: 10px;
            background-color: #f8f9fa;
        }

        /* Botón hamburguesa: solo visible en móvil */
        #sidebar-toggle {
            display: none;
        }

        /* Overlay oscuro detrás del sidebar en móvil */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1040;
        }

        /* Sidebar en móvil: drawer deslizante desde la izquierda */
        @media (max-width: 767px) {
            #sidebar-toggle {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 1rem;
            }

            #sidebar-col {
                position: fixed;
                top: 0;
                left: -280px;
                width: 280px;
                height: 100%;
                z-index: 1050;
                background: #fff;
                box-shadow: 2px 0 12px rgba(0,0,0,0.15);
                transition: left 0.3s ease;
                overflow-y: auto;
                padding: 1rem;
            }

            #sidebar-col.open {
                left: 0;
            }

            #sidebar-overlay.open {
                display: block;
            }

            #sidebar-close {
                display: flex;
            }
        }

        /* En escritorio, el botón cerrar del drawer no se muestra */
        #sidebar-close {
            display: none;
        }
    </style>
</head>
<?php include("includes/navbar.php"); ?>

<body>
    <div class="container-fluid mt-4">
        <div class="row">

            <!-- BOTÓN HAMBURGUESA (solo móvil) -->
            <div class="col-12">
                <button id="sidebar-toggle" class="btn btn-outline-secondary">
                    <span>&#9776;</span> Categorías
                </button>
            </div>

            <!-- OVERLAY -->
            <div id="sidebar-overlay"></div>

            <!-- SIDEBAR -->
            <div class="col-md-3" id="sidebar-col">

                <!-- Botón cerrar (solo visible en móvil dentro del drawer) -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <strong>Categorías</strong>
                    <button id="sidebar-close" class="btn btn-sm btn-outline-secondary">&times; Cerrar</button>
                </div>

                <div class="card p-3">
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <a href="catalogo.php">Todas</a>
                        </li>

                        <?php while ($cat = $categorias->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <a href="catalogo.php?categoria=<?= htmlspecialchars($cat['id_categoria']) ?>">
                                    <?= htmlspecialchars($cat['nombre']) ?>
                                </a>

                                <?php if (isset($subcategorias[$cat['id_categoria']])): ?>
                                    <ul class="list-unstyled ms-3 mt-2">
                                        <?php foreach ($subcategorias[$cat['id_categoria']] as $sub): ?>
                                            <li>
                                                <a href="catalogo.php?subcategoria=<?= htmlspecialchars($sub['id_subcategoria']) ?>">
                                                    <?= htmlspecialchars($sub['nombre']) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="col-md-9">
                <br>
                <div>
                    <h5>Buscar</h5>
                    <form method="GET" action="catalogo.php">
                        <input type="text" name="buscar" class="form-control mb-2" placeholder="Buscar producto...">
                        <button class="btn btn-primary w-100">Buscar</button>
                    </form>
                </div>

                <br>

                <div class="row" id="productos-container">
                    <?php if (count($productos) > 0): ?>
                        <?php foreach ($productos as $i => $fila): ?>
                            <div class="col-md-4 mb-4">
                                <a href="producto.php?id=<?= htmlspecialchars($fila['id_producto']) ?>" class="card-link">
                                    <div class="card h-100">
                                        <img id="img-<?= $i ?>" class="card-img-top" alt="<?= htmlspecialchars($fila['nombre']) ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($fila['nombre']) ?></h5>
                                            <p class="card-text"><?= htmlspecialchars($fila['descripcion']) ?></p>
                                            <p><strong><?= htmlspecialchars($fila['precio']) ?> €</strong></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay productos.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <?php include("includes/footer.php"); ?>

    <script>
        // Cargar imágenes
        const urls = JSON.parse(atob("<?= $urls_base64 ?>"));
        urls.forEach((url, i) => {
            const img = document.getElementById('img-' + i);
            if (img) {
                img.style.height = '200px';
                img.style.objectFit = 'contain';
                img.style.padding = '10px';
                img.style.backgroundColor = '#f8f9fa';
                img.style.width = '100%';
                img.style.display = 'block';
                img.src = url;
            }
        });

        // Lógica del sidebar hamburguesa
        const toggle    = document.getElementById('sidebar-toggle');
        const sidebar   = document.getElementById('sidebar-col');
        const overlay   = document.getElementById('sidebar-overlay');
        const closeBtn  = document.getElementById('sidebar-close');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden'; // evita scroll del fondo
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        toggle.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
    </script>

</body>
</html>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAR DE PC's - Ordenadores, Mantenimiento y Más</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<!-- ── HERO ── -->
<section class="hero">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">Bienvenido a Mar de PC's</h1>
        <p class="lead mb-4">Tu tienda de confianza en ordenadores, mantenimiento, asesoría y piezas en Asturias.</p>
        <a href="catalogo.php" class="btn btn-light btn-lg me-2">Ver productos</a>
        <a href="contacto.php" class="btn btn-outline-light btn-lg">Contáctanos</a>
        <p class="mt-4 mb-0" style="opacity:.65;">
            <small>Página con fines educativos · Los procesos de compra son una simulación.</small>
        </p>
    </div>
</section>

<!-- ── TARJETAS DESTACADAS ── -->
<section class="py-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">

            <div class="col">
                <div class="card h-100">
                    <img class="card-img-top" src="https://tse1.explicit.bing.net/th/id/OIP.iGv5cxLIKkIXxkAbkQEWowHaE8?r=0&rs=1&pid=ImgDetMain&o=7&rm=3"
                         alt="Catálogo" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title">Todo lo que necesitas</h5>
                        <p class="card-text text-muted">Un amplio catálogo de piezas, periféricos y más para tu ordenador.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <a href="catalogo.php" class="btn btn-outline-primary btn-sm">Ver catálogo →</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img class="card-img-top" src="https://tse3.mm.bing.net/th/id/OIP.X3MMi46-xNl6XQXtQsMOHgHaE7?r=0&rs=1&pid=ImgDetMain&o=7&rm=3"
                         alt="Asistencia" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title">La mejor asistencia</h5>
                        <p class="card-text text-muted">Técnicos expertos disponibles para resolver cualquier problema con tu equipo.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <a href="contacto.php" class="btn btn-outline-primary btn-sm">Contactar →</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img class="card-img-top" src="https://asesorias-iso.cl/wp-content/uploads/2023/09/Agregar-un-titulo-1.png"
                         alt="Cursos" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title">Cursos y formación</h5>
                        <p class="card-text text-muted">Amplía tus conocimientos con nuestros cursos de TIC, impartidos por profesionales.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <a href="contacto.php" class="btn btn-outline-primary btn-sm">Más información →</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ── SERVICIOS ── -->
<section class="py-5 bg-light" id="servicios">
    <div class="container">
        <h2 class="text-center mb-5">Nuestros Servicios</h2>
        <div class="row g-4 text-center">

            <div class="col-6 col-md-3">
                <div class="mb-3" style="font-size:2.5rem;">💻</div>
                <h5>Ordenadores</h5>
                <p class="text-muted small">Venta y montaje de PCs personalizados según tus necesidades y presupuesto.</p>
            </div>

            <div class="col-6 col-md-3">
                <div class="mb-3" style="font-size:2.5rem;">🔧</div>
                <h5>Mantenimiento</h5>
                <p class="text-muted small">Reparaciones rápidas y diagnósticos para que tu equipo funcione al máximo.</p>
            </div>

            <div class="col-6 col-md-3">
                <div class="mb-3" style="font-size:2.5rem;">🎓</div>
                <h5>Asesoría</h5>
                <p class="text-muted small">Consejos expertos para elegir los componentes o soluciones más adecuados.</p>
            </div>

            <div class="col-6 col-md-3">
                <div class="mb-3" style="font-size:2.5rem;">📦</div>
                <h5>Piezas</h5>
                <p class="text-muted small">Componentes originales y compatibles con garantía y al mejor precio.</p>
            </div>

        </div>
    </div>
</section>

<!-- ── SOBRE NOSOTROS ── -->
<section class="py-5" id="sobre-nosotros">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <h2 class="mb-3">Sobre Nosotros</h2>
                <p class="text-muted">En <strong>MAR DE PC's</strong> somos apasionados por la tecnología. Llevamos años ofreciendo soluciones integrales a particulares y empresas de Asturias, con un trato cercano y profesional.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── CTA CONTACTO ── -->
<section class="hero">
    <div class="container">
        <h2 class="fw-bold mb-3">¿Tienes alguna pregunta?</h2>
        <p class="mb-4" style="opacity:.8;">Estaremos encantados de ayudarte.</p>
        <a href="contacto.php" class="btn btn-light btn-lg">Envíanos un mensaje</a>
    </div>
</section>

<?php include("includes/footer.php"); ?>
</body>
</html>

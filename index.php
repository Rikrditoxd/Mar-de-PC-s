<?php

session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAR DE PC´S - Ordenadores, Mantenimiento y Más</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Barra de navegación -->
    <?php include("includes/navbar.php"); ?>

    <!-- Sección Hero -->
    <section class="hero">
        <div class="container">
            <h1>Bienvenido a Mar de PC`s</h1>
            <p>Tu aliado en ordenadores, mantenimiento, asesoría y piezas de calidad en Asturias.</p>
            <a href="#contacto" class="btn btn-light btn-lg">Contáctanos</a>
        </div>
    </section>

    <br><br>

    <section class="catalogo">
        <div class="container">
            <div class="row g-4 justify-content-start gap-5">

                <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="https://tse1.explicit.bing.net/th/id/OIP.iGv5cxLIKkIXxkAbkQEWowHaE8?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">Todo lo que necesitas para tu ordenador</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
        </div>

        <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="https://tse3.mm.bing.net/th/id/OIP.X3MMi46-xNl6XQXtQsMOHgHaE7?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">La mejor asistencia de Asturias</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
        </div>

        <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="https://asesorias-iso.cl/wp-content/uploads/2023/09/Agregar-un-titulo-1.png" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">Cursos y gestiones al mejor precio</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
        </div>

        
        </div>
    </div>
        </div>
    </section>

    <br><br>
    <!-- Sección Servicios -->
    <section id="servicios" class="services">
        <div class="container">
            <h2 class="text-center mb-4">Nuestros Servicios</h2>
            <div class="row">
                <div class="col-md-3 text-center">
                    <h4>Ordenadores</h4>
                    <p>Venta y configuración de PCs personalizados.</p>
                </div>
                <div class="col-md-3 text-center">
                    <h4>Mantenimiento</h4>
                    <p>Reparaciones rápidas y eficientes para tu equipo.</p>
                </div>
                <div class="col-md-3 text-center">
                    <h4>Asesoría</h4>
                    <p>Consejos expertos para optimizar tu tecnología.</p>
                </div>
                <div class="col-md-3 text-center">
                    <h4>Piezas</h4>
                    <p>Componentes originales y compatibles.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Sobre Nosotros -->
    <section id="sobre-nosotros" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Sobre Nosotros</h2>
            <p class="text-center">En MAR DE PC´S, somos apasionados por la tecnología. Ofrecemos soluciones integrales para particulares y empresas, con años de experiencia en el sector.</p>
        </div>
    </section>

    <!-- Sección Contacto -->
    <section id="contacto" class="contact">
        <div class="container">
            <h2 class="text-center mb-4">Contáctanos</h2>
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="message" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </section>

    <!-- Pie de página -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2026 MAR DE PC´s. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
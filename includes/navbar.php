<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Solo en pantallas grandes */
        @media (min-width: 992px) {
            .navbar-center-desktop {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">

        <div class="container-fluid position-relative">

            <!-- LOGO (izquierda) -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/imagenes/minimalista.png" height="40" class="me-2">
            </a>

            <!-- BOTÓN RESPONSIVE -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContenido">

                <!-- 🔥 CENTRO REAL -->
                <ul class="navbar-nav navbar-center-desktop">

                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="catalogo.php">Nuestros Productos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>

                    <?php if (isset($_SESSION['administrador']) && $_SESSION['administrador'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="administracion.php">Admin</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="administracion_pedidos.php">Pedidos</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="administracion_contacto.php">Mensajes</a>
                        </li>
                    <?php endif; ?>

                </ul>

                <!-- DERECHA -->
                <ul class="navbar-nav ms-auto">

                    <?php if (isset($_SESSION['id_usuario'])): ?>

                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light" href="carrito.php">
                                Carrito 🛒
                            </a>
                        </li>

                        <li class="nav-item dropdown me-2">
                            <a class="nav-link dropdown-toggle text-white"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown">
                                👤 <?= $_SESSION['nombre'] ?>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="pedidos.php">📦 Mis pedidos</a></li>
                                <li><a class="dropdown-item" href="perfil.php">👤 Mi perfil</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="logout.php">Salir</a>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="login.php">Login</a>
                            <a class="btn btn-outline-light" href="registro.php">Registro</a>
                        </li>

                    <?php endif; ?>

                </ul>

            </div>
        </div>
    </nav>
</body>

</html>
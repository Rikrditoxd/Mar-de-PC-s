<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid position-relative">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/imagenes/minimalista.png" height="40" class="me-2" alt="Mar de PC's">
        </a>

        <!-- Botón responsive -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarContenido"
                aria-controls="navbarContenido" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContenido">

            <!-- Centro -->
            <ul class="navbar-nav navbar-center-desktop">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catalogo.php">Productos</a>
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

            <!-- Derecha -->
            <ul class="navbar-nav ms-auto align-items-center gap-1">

                <?php if (isset($_SESSION['id_usuario'])): ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="carrito.php">🛒 Carrito</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#"
                           role="button" data-bs-toggle="dropdown">
                            👤 <?= htmlspecialchars($_SESSION['nombre']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="pedidos.php">📦 Mis pedidos</a></li>
                            <li><a class="dropdown-item" href="perfil.php">👤 Mi perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Salir</a></li>
                        </ul>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="registro.php">Registro</a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

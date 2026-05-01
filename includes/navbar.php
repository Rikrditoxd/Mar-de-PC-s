<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top px-4">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="assets/imagenes/minimalista.png" height="40" class="me-2">
        
    </a>

    <div class="collapse navbar-collapse">

        <!-- CENTRO -->
        <ul class="navbar-nav mx-auto">
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
            <?php endif; ?>
        </ul>

        <!-- DERECHA -->
        <ul class="navbar-nav ms-auto">

            <?php if (isset($_SESSION['id_usuario'])): ?>

                <!-- USUARIO LOGUEADO -->
                <li class="nav-item d-flex align-items-center text-white me-3">
                    👤 <?= $_SESSION['nombre'] ?>
                </li>

                <li class="nav-item">
                    <a class="btn btn-outline-light" href="logout.php">
                        Salir
                    </a>
                </li>

            <?php else: ?>

                <!-- NO LOGUEADO -->
                <li class="nav-item">
                    <a class="btn btn-outline-light" href="login.php">
                        Login
                    </a>

                    <a class="btn btn-outline-light" href="registro.php">
                        Registro
                    </a>
                </li>

            <?php endif; ?>

        </ul>

    </div>
</nav>
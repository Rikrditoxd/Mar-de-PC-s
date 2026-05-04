<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="assets/css/style.css">
</head>
 
<?php include("includes/navbar.php"); ?>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0 text-center">Contáctanos</h3>
                    </div>
                    <div class="card-body">
                        <form action="acciones/procesar_contacto.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ingresa tu nombre">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="tu@email.com">
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono (opcional)</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="1234567890">
                            </div>
                            <div class="mb-3">
                                <label for="asunto" class="form-label">Asunto</label>
                                <select class="form-select" id="asunto" name="asunto" required>
                                    <option value="" selected disabled>Selecciona un asunto</option>
                                    <option value="consulta">Consulta general</option>
                                    <option value="soporte">Soporte técnico</option>
                                    <option value="pedido">Información de pedido</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required placeholder="Escribe tu mensaje aquí..."></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar mensaje</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/footer.php"); ?>
</body>
</html>
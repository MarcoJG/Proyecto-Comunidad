<?php
    $basePath = '/Proyecto-Comunidad/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad de Vecinos</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="<?= $basePath ?>web/src/header/cabecera.css">
</head>

<body>
    <header>
        <div class="header-container">
            <a class="logo" href="<?= $basePath ?>web/src/home/index.php" target="_top">
                <img src="<?= $basePath ?>assets/img/LOGO_2.png" alt="logo comunidad">
            </a>

            <nav class="nav-container">
                <a href="<?= $basePath ?>web/src/home/index.php" class="nav-link" target="_top">INICIO</a>
                <a href="<?= $basePath ?>web/src/eventos/index.php" class="nav-link" target="_top">EVENTOS</a>
                <a href="<?= $basePath ?>web/src/noticias/index.php" class="nav-link" target="_top">NOTICIAS</a>
                <a href="<?= $basePath ?>web/src/foro/index.php" class="nav-link" target="_top">FORO</a>
                <a href="#" class="nav-link">VOTACIONES</a>
                <a href="<?= $basePath ?>web/src/reservas/reservas.php" class="nav-link" target="_top">RESERVAS</a>
                <a href="<?= $basePath ?>web/src/contacto/index.php" class="nav-link" target="_top">SOPORTE</a>
                
            </nav>

            <div class="buttons-container">
                <button onclick="navToLogin()" id="boton-login" class="boton-login">Iniciar Sesión</button>
            </div>

            <div class="user-info-container" style="display: none;">
                <span id="welcome-message" class="welcome-message"></span>
                <div class="user-dropdown">
                    <button class="user-dropdown-btn">&#9660;</button>
                    <div class="user-dropdown-content">
                        <p id="user-email" class="user-email"></p>
                        <a href="<?= $basePath ?>backend/src/login/logout.php" id="logout-link" class="logout-link">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- JavaScript -->
    <script src="<?= $basePath ?>web/src/header/cabecera.js"></script>
</body>
</html>
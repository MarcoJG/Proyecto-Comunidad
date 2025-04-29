<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cabecera.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="header-container">
            <a class="logo" href="../home/index.php" target="_top">
                <img src="../../../assets/img/LOGO_2.png" alt="logo comunidad">
            </a>

            <nav class="nav-container">
                <a href="../home/index.php" class="nav-link" target="_top">INICIO</a>
                <a href="../eventos/index.php" class="nav-link" target="_top">EVENTOS</a>
                <a href="#" class="nav-link">NOTICIAS</a>
                <a href="../foro/index.php" class="nav-link" target="_top">FORO</a>
                <a href="#" class="nav-link">VOTACIONES</a>
                <a href="../contacto/Contacto.html" class="nav-link" target="_top">SOPORTE</a>
            </nav>

            <div class="buttons-container">
                <button onclick="navToLogin()" id="boton-login" class="boton-login">Iniciar Sesion</button>
            </div>

            <div class="user-info-container" style="display: none;">
                <span id="welcome-message" class="welcome-message"></span>
                <div class="user-dropdown">
                    <button class="user-dropdown-btn">&#9660;</button>
                    <div class="user-dropdown-content">
                        <p id="user-email" class="user-email"></p>
                        <a href="../../../backend/src/login/logout.php" id="logout-link" class="logout-link">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script src="cabecera.js"></script>
</body>

</html>
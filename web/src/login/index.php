<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicie sesión en la plataforma de la Comunidad de Vecinos. Acceda con su correo y contraseña.">

    <meta name="keywords" content="login, acceso, comunidad de vecinos, iniciar sesión">
    <meta name="author" content="Comunidad de vecinos">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <a class="logo" href="../home/index.php" target="_top"> <img src="../../../assets/img/LOGO_2.png" alt="Imagen de logo de la comunidad de vecinos."></a>
    </header>
    <main>
        <section class="login-container">
            <h1>Iniciar Sesión</h1>

            <form action="../../../backend/src/login/login.php" method="POST">
            <div class="mb-3">
                <label for="correo" class="form-label">Su dirección de correo electrónico:</label>
                <input type="text" class="form-control" name="correo" placeholder="Correo Electrónico..." required aria-label="Correo electrónico">
            </div>
                <label for="contrasenya">Su contraseña:</label>
                <input type="password" name="contrasenya" placeholder="Contraseña..." required aria-label="Contraseña">

                <button type="submit" class="btn btn-dark">Acceder</button>
            </form>
            <p>¿No tienes cuenta? <a class="registro" href="../register/index.php">Regístrate aquí</a></p>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Comunidad de Vecinos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
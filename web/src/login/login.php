<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Meta descripción para SEO-->
    <meta name="description" content="Inicie sesión en la plataforma de la Comunidad de Vecinos. Acceda con su correo y contraseña.">

    <!--keywords-->
    <meta name="keywords" content="login, acceso, comunidad de vecinos, iniciar sesión">
    <meta name="author" content="Comunidad de vecinos">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <img src="../assets/LOGO 2.png" alt="Imagen de logo de la comunidad de vecinos.">
    </header>
    <main>
        <section class="login-container">
            <h1>Iniciar Sesión</h1>

            <form action="../PHP/login.php" method="POST">
                <label for="correo">Su dirección de correo electrónico:</label>
                <input type="text" name="correo" placeholder="Correo Electrónico..." required aria-label="Correo electrónico">

                <label for="contrasenya">Su contraseña:</label>
                <input type="password" name="contrasenya" placeholder="Contraseña..." required aria-label="Contraseña">

                <button type="submit">Acceder</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Comunidad de Vecinos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
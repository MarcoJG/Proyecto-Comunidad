<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Regístrese en la plataforma de la Comunidad de Vecinos. Introduzca las credenciales requeridas.">

    <meta name="keywords" content="registro, acceso, comunidad de vecinos, registrar usuario, usuario">
    <meta name="author" content="Comunidad de vecinos">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title>Registro de usuario</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <main>
        <section class="register-container">
            <h1>Registro de Usuario</h1>
            <div id="registration-message"></div>  <form id="registration-form" action="../../../backend/src/register/register.php" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Su nombre completo:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: José Rodriguez" required aria-label="Nombre completo">
                </div>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Nombre de usuario:</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario..." required aria-label="Nombre de usuario">
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Su dirección de correo electrónico:</label>
                    <input type="email" id="correo" name="correo" placeholder="Ejemplo: pepito@gmail.com" required aria-label="Correo electrónico">
                </div>
                <div class="mb-3">
                    <label for="contrasenya" class="form-label">Su contraseña:</label>
                    <input type="password" id="contrasenya" name="contrasenya" placeholder="Contraseña..." required aria-label="Contraseña">
                </div>
                <div class="mb-3">
                    <label for="confirm_contrasenya" class="form-label">Confirme su contraseña:</label>
                    <input type="password" id="confirm_contrasenya" name="confirm_contrasenya" placeholder="Confirmar contraseña..." required aria-label="Confirmar contraseña">
                </div>
                <button type="submit" class="boton-registro-dorado">Registrarse</button>
            </form>
        </section>
    </main>
    <script src="register.js"></script>
</body>
</html>
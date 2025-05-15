<?php
// Capturamos el mensaje de error desde la URL
//$mensaje = $_GET['mensaje'] ?? "Ha ocurrido un error inesperado.";


$mensajes_validos = [
    'campos_vacios' => 'Por favor, complete todos los campos.',
    'contrasenas_no_coinciden' => 'Las contraseñas no coinciden.',
    'correo_invalido' => 'El correo no es válido.',
    'usuario_existente' => 'El nombre de usuario ya está en uso.',
    'correo_existente' => 'El correo ya está registrado.',
    'correo_no_enviado' => 'Registro exitoso, pero no se pudo enviar el correo de verificación.',
    'error_bd' => 'Error interno de base de datos.',
    'error_inesperado' => 'Ha ocurrido un error inesperado.'
];

$codigo = $_GET['mensaje'] ?? '';
$mensaje = $mensajes_validos[$codigo] ?? 'Ha ocurrido un error inesperado.';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mensaje de error de la Comunidad de Vecinos.">

    <meta name="keywords" content="error, registro, comunidad de vecinos">
    <meta name="author" content="Comunidad de vecinos">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title>Error en el Registro</title>
    <link rel="stylesheet" href="login.css"> <!-- Reutiliza tu CSS si es el mismo diseño -->
    <style>
        /* Si no usas login.css, aquí van estilos equivalentes */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            /*
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            */
        }

        header img {
            max-height: 135px;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            background-color: #243D51;
            color: white;
            font-weight: bold;
            padding: 2rem;
            /*
            border-radius: 10px;
            */
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .login-container p {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .login-container a {
            padding: 10px 20px;
            background-color: #786247;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1rem;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .login-container a:hover {
            background-color: #5e4c37;
        }

        footer {
            background-color: #f5f5f5;;
            padding: 10px;
            text-align: center;
            color: #757575;
            /*
            font-size: 0.9rem;
            color: #333;
            */
        }
    </style>
</head>
<body>
    <header>
        <a class="logo" href="../home/index.php" target="_top">
            <img src="../../../assets/img/LOGO_2.png" alt="Imagen de logo de la comunidad de vecinos.">
        </a>
    </header>

    <main>
        <section class="login-container">
            <h1>Error en el Registro</h1>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
            <a href="./index.php">Volver al formulario de registro</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Comunidad de Vecinos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

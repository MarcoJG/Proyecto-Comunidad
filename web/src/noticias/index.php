<?php
session_start();
require_once __DIR__ . '/../../../config.php';
?>

<?php
// Verificación de sesión y rol
$usuarioEsAdmin = (isset($_SESSION["nombre_rol"]) && $_SESSION["nombre_rol"] === "Admin");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="fondo-cuerpo">

    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . $basePath . 'web/src/header/cabecera.php'; ?>
    </header>

    <main>
        <section class="contenedor-principal">
            <?php if ($usuarioEsAdmin): ?>  
                <div style="text-align: right; margin: 20px;">
                    <a href="crear_noticia.php" class="boton-noticia">
                        Crear noticia
                    </a>
                </div>
            <?php endif; ?>

            <!-- Próximas Noticias -->
            <section class="contenedor proximos-noticias">
                <h2 class="titulo-noticia">Noticias Actuales</h2>
                <p class="subtitulo">Consulta todos las noticias de nuestra comunidad aquí</p>
                <?php include '../../../backend/src/noticias/noticias_actuales.php'; ?>
            </section>
        </section>

        <section class="contenedor-principal">
            <!-- Noticias pasadas -->
            <section class="contenedor proximos-noticias">
                <h2 class="titulo-noticia">Noticias pasadas</h2>
                <?php include '../../../backend/src/noticias/noticias_pasadas.php'; ?>
            </section>
        </section>
    </main>

</body>
</html>
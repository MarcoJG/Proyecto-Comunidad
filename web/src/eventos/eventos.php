<?php
require_once __DIR__ . '/../../../config.php';
session_start(); // Asegúrate de que la sesión esté iniciada

// Comprobamos si el usuario tiene el rol de Admin
$usuarioEsAdmin = isset($_SESSION["nombre_rol"]) && $_SESSION["nombre_rol"] === "Admin";

// Mostrar mensaje de éxito si el evento fue eliminado
if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado') {
    echo "<p style='color: green; text-align:center; margin-top: 20px;'>Evento eliminado correctamente.</p>";
}
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
<main>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . $basePath . 'web/src/header/cabecera.php'; ?>
    </header>

    <?php if ($usuarioEsAdmin): ?>  
        <div style="text-align: right; margin: 20px;">
            <a href="crear_evento.php" class="boton-evento" style="background-color: #243D51; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Crear evento
            </a>
        </div>
    <?php endif; ?>

    <section class="contenedor-principal">
        <!-- Próximos Eventos -->
        <section class="contenedor proximos-eventos">
            <h2 class="titulo-eventos">Próximos eventos</h2>
            <p class="subtitulo">Consulta todos los eventos de nuestra comunidad aquí</p>
            <?php include '../../../backend/src/eventos/eventos_futuros.php'; ?>
        </section>
    </section>

    <section class="contenedor-principal">
        <!-- Eventos pasados -->
        <section class="contenedor proximos-eventos">
            <h2 class="titulo-eventos">Eventos pasados</h2>
            <?php include '../../../backend/src/eventos/eventos_pasados.php'; ?>
        </section>
    </section>
</main>

<footer>
    <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="300px"></iframe>
</footer>

</body>
</html>

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
        <?php include('../header/cabecera.php'); ?>
    </header>
    <main>
        <div class="contenedor-principal">

            <!-- Crear evento solo para admins -->
            <div>
            <?php if ($usuarioEsAdmin): ?>  
                <div style="text-align: right; margin: 20px;">
                    <a href="crear_evento.php" class="boton-evento">
                        Crear evento
                    </a>
                </div>
            <?php endif; ?>
            </div>

            <!-- Próximos Eventos -->
            <section class="contenedor proximos-eventos">
            <h2 class="titulo-eventos">Próximos eventos</h2>
            <p class="subtitulo">Consulta todos los eventos de nuestra comunidad aquí</p>
            <?php include '../../../backend/src/eventos/eventos_futuros.php'; ?>
        </section>

    </div>

    <section class="contenedor-principal">
        <!-- Eventos pasados -->
        <section class="contenedor proximos-eventos">
            <h2 class="titulo-eventos">Eventos pasados</h2>
            <?php include '../../../backend/src/eventos/eventos_pasados.php'; ?>
        </section>
    </section>
    </main>

</body>
</html>

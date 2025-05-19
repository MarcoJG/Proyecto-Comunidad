<?php
require_once __DIR__ . '/../../../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Evento</title>
    <link rel="stylesheet" href="detalle.css?<?= time(); ?>" />

</head>
<body class="fondo-cuerpo">

<header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . $basePath . 'web/src/header/cabecera.php'; ?>
</header>

<div class="contenedor-principal">
    <?php include '../../../backend/src/eventos/detalle.php'; ?>
</div>

<footer> 
    <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="300px"></iframe> 
</footer>

<script>
    function confirmarBorrado(event) {
        event.preventDefault();
        if (confirm("¿Estás seguro de que quieres borrar este evento?")) {
            event.target.submit();
        }
    }
</script>

</body>
</html>

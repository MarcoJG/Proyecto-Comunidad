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

<!-- Modal de confirmación -->
<div id="modalConfirmacion" class="modal">
  <div class="modal-contenido">
    <p>¿Estás seguro de que quieres borrar este evento?</p>
    <div class="modal-botones">
        <button id="confirmarBtn">Sí, borrar</button>
        <button id="cancelarBtn">Cancelar</button>
    </div>
  </div>
</div>
<script>
    let formularioAEliminar = null;

    function confirmarBorrado(event) {
        event.preventDefault(); 
        formularioAEliminar = event.target; 
        document.getElementById('modalConfirmacion').style.display = 'block'; 
        return false; 
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('confirmarBtn').addEventListener('click', function () {
            document.getElementById('modalConfirmacion').style.display = 'none';
            if (formularioAEliminar) formularioAEliminar.submit(); 
        });

        document.getElementById('cancelarBtn').addEventListener('click', function () {
            document.getElementById('modalConfirmacion').style.display = 'none';
            formularioAEliminar = null; 
        });
    });
</script>

</body>
</html>

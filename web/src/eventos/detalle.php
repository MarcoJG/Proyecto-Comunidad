¡Entendido! Quieres mantener los "incoming changes" de la rama develop, que son los que están entre ======= y >>>>>>> develop.

Aquí tienes el contenido editado del archivo web/src/eventos/detalle.php manteniendo solo los "incoming changes":

HTML

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Evento</title>
    <link rel="stylesheet" href="detalle.css">
</head>

<body class="fondo-cuerpo">

    <div class="contenedor-principal">
        <?php
        include '../../../backend/src/eventos/detalle.php';
        ?>
    </div>

</body>

</html>
<?php
session_start();

if (!isset($_SESSION['nombre_rol']) || $_SESSION['nombre_rol'] !== 'Admin') {
    header("Location: ../../../web/src/eventos/acceso_denegado.php");
    exit();
}


// Recuperar datos del formulario en caso de error
$titulo_guardado = $_SESSION['form_data']['titulo'] ?? '';
$descripcion_guardado = $_SESSION['form_data']['descripcion'] ?? '';
$fecha_guardada = $_SESSION['form_data']['fecha'] ?? '';

// Limpiar datos de sesión después de usarlos
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Evento</title>
    <link rel="stylesheet" href="/../Proyecto-Comunidad/web/src/eventos/crear_evento.css">
</head>

<body class="fondo-cuerpo">

    <main class="contenedor-principal">
        <h2 class="titulo-eventos">Crear nuevo evento</h2>

        <?php
        // Mostrar errores (si los hay)
        if (isset($_GET['error'])) {
            $error_message = '';

            switch ($_GET['error']) {
                case 'faltan_datos':
                    $error_message = "Por favor, complete todos los campos.";
                    break;
                case 'longitud_invalida':
                    $error_message = "El título o la descripción son demasiado largos.";
                    break;
                case 'fecha_invalida':
                    $error_message = "La fecha del evento debe ser futura.";
                    break;
                default:
                    $error_message = "Ha ocurrido un error.";
            }

            echo "<p class='error'>$error_message</p>";
        }
        ?>
        <form action="../../../backend/src/eventos/procesar_crear_evento.php" method="POST" class="formulario-evento">
            <label for="titulo">Título del evento:</label>
            <input type="text" id="titulo" name="titulo" maxlength="100" required value="<?= htmlspecialchars($titulo_guardado) ?>">

            <label for="fecha">Fecha del evento:</label>
            <input type="date" id="fecha" name="fecha" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>" value="<?= htmlspecialchars($fecha_guardada) ?>">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" maxlength="255" required><?= htmlspecialchars($descripcion_guardado) ?></textarea>

            <button type="submit" class="boton-evento">Crear evento</button>
        </form>
    </main>

</body>

</html>

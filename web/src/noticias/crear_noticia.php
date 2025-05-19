<?php
session_start();

if (!isset($_SESSION['nombre_rol']) || $_SESSION['nombre_rol'] !== 'Admin') {
    header("Location: ../../../web/src/noticias/acceso_denegado.php");
    exit();
}


// Recuperar datos del formulario en caso de error
$titulo_guardado = $_SESSION['form_data']['titulo'] ?? '';
$descripcion_guardado = $_SESSION['form_data']['contenido'] ?? '';
$fecha_guardada = $_SESSION['form_data']['fecha'] ?? '';
$destacado_guardado = $_SESSION['form_data']['destacado'] ?? 0;

// Limpiar datos de sesión después de usarlos
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Noticia</title>
    <link rel="stylesheet" href="/../Proyecto-Comunidad/web/src/noticias/crear_noticia.css">
</head>

<body class="fondo-cuerpo">

    <main class="contenedor-principal">
        <h2 class="titulo-noticias">Crear nueva noticia</h2>

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
                    $error_message = "La fecha de la noticia debe ser futura.";
                    break;
                default:
                    $error_message = "Ha ocurrido un error.";
            }

            echo "<p class='error'>$error_message</p>";
        }
        ?>
        <form action="../../../backend/src/noticias/procesar_crear_noticia.php" method="POST" class="formulario-noticia" enctype="multipart/form-data">
            <label for="titulo">Título de la noticia:</label>
            <input type="text" id="titulo" name="titulo" maxlength="100" required value="<?= htmlspecialchars($titulo_guardado) ?>">

            <label for="descripcion">Descripción:</label>
            <textarea id="contenido" name="contenido" maxlength="255" required><?= htmlspecialchars($descripcion_guardado) ?></textarea>

            <label for="fecha">Fecha de la noticia:</label>
            <input type="date" id="fecha" name="fecha" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>" value="<?= htmlspecialchars($fecha_guardada) ?>">
            
            <label for="imagen">Imagen de la noticia:</label>
            <input type="file" name="imagen" accept="image/*">
            
            <!-- Evento es destacado -->
            <label for="destacado">¿Es noticia destacada?</label>

            <div class="checkbox-destacado">
                <label>
                    <input type="radio" name="destacado" value="1" <?= $destacado_guardado == 1 ? 'checked' : '' ?>> Sí
                </label>
                <label>
                    <input type="radio" name="destacado" value="0" <?= $destacado_guardado == 0 ? 'checked' : '' ?>> No
                </label>
            </div>

            <button type="submit" class="boton-noticia">Crear noticia</button>
        </form>
    </main>

</body>

</html>

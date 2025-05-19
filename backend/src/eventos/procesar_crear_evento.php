<?php
session_start();

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION['id_usuario']) || !isset($_SESSION["nombre_rol"]) || !in_array($_SESSION["nombre_rol"], ["Admin", "Presidente"])) {
        die("No autorizado.");
    }

    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    $id_usuario = $_SESSION['id_usuario'];

    // Comprobar si el evento es destacado
    $destacado = isset($_POST['destacado']) ? $_POST['destacado'] : 0;

    if (empty($titulo) || empty($descripcion) || empty($fecha)) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/src/eventos/crear_evento.php?error=faltan_datos");
        exit();
    }

    if (strlen($titulo) > 100 || strlen($descripcion) > 255) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/src/eventos/crear_evento.php?error=longitud_invalida");
        exit();
    }

    if (strtotime($fecha) <= strtotime('today')) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/src/eventos/crear_evento.php?error=fecha_invalida");
        exit();
    }
    // Imagen por defecto
    $rutaImagenBD = '/Proyecto-Comunidad/web/etc/assets/img/bloque.jpg';

    // Procesar imagen si se ha subido
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $tipoArchivo = $_FILES['imagen']['type'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];

        $permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (in_array($tipoArchivo, $permitidos)) {
        $hashArchivo = md5_file($rutaTemporal);
        $directorioDestino = __DIR__ . '/../../../web/etc/assets/img/';
        $archivosExistentes = scandir($directorioDestino);
        $imagenEncontrada = false;

        foreach ($archivosExistentes as $archivo) {
            if (in_array(pathinfo($archivo, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $rutaCompleta = $directorioDestino . $archivo;
                if (is_file($rutaCompleta) && md5_file($rutaCompleta) === $hashArchivo) {
                    $rutaImagenBD = '/Proyecto-Comunidad/web/etc/assets/img/' . $archivo;
                    $imagenEncontrada = true;
                    break;
                }
            }
        }

        if (!$imagenEncontrada) {
            $nombreUnico = basename($nombreArchivo); // Puedes cambiar por $hashArchivo si prefieres
            $rutaDestino = $directorioDestino . $nombreUnico;

            // Crear carpeta si no existe
            if (!is_dir(dirname($rutaDestino))) {
                mkdir(dirname($rutaDestino), 0755, true);
            }

            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                $rutaImagenBD = '/Proyecto-Comunidad/web/etc/assets/img/' . $nombreUnico;
            }
        }
    }
    }
    try {
        // Verificar si ya existe un evento destacado
        if ($destacado == 1) {
            $sql_check = "SELECT id_evento FROM eventos WHERE es_destacada = 1 LIMIT 1";
            $result = $pdo->query($sql_check);

            if ($result->rowCount() > 0) {
                // Guardar los datos del nuevo evento y redirigir a confirmación
                $_SESSION['evento_destacado_existente'] = true;
                $_SESSION['evento_destacado_data'] = [
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'fecha' => $fecha,
                    'destacado' => $destacado,
                    'id_usuario' => $id_usuario
                ];
                header("Location: /Proyecto-Comunidad/web/src/eventos/confirmar_reemplazo.php");
                exit();
            }
        }

        // Insertar si no hay conflicto
        $sql = "INSERT INTO eventos (titulo, descripcion, fecha, id_usuario, es_destacada, imagen)
                VALUES (:titulo, :descripcion, :fecha, :id_usuario, :es_destacada, :imagen)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':fecha' => $fecha,
            ':id_usuario' => $id_usuario,
            ':es_destacada' => $destacado,
            ':imagen' => $rutaImagenBD
        ]);

        header("Location: /Proyecto-Comunidad/web/src/eventos/index.php");
        exit();

    } catch (PDOException $e) {
        echo "Error al crear el evento: " . $e->getMessage();
    }
}
?>

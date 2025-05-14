<?php
session_start();

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificar usuario Admin o Presidente
    if (!isset($_SESSION['id_usuario']) || !isset($_SESSION["nombre_rol"]) || !in_array($_SESSION["nombre_rol"], ["Admin", "Presidente"])) {
        die("No autorizado.");
    }

    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    $id_usuario = $_SESSION['id_usuario'];

    // Comprobar si el evento es destacado
    $destacado = isset($_POST['destacado']) ? $_POST['destacado'] : 0;

    // Validaciones
    if (empty($titulo) || empty($descripcion) || empty($fecha)) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/eventos/crear_evento.php?error=faltan_datos");
        exit();
    }

    if (strlen($titulo) > 100 || strlen($descripcion) > 255) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/eventos/crear_evento.php?error=longitud_invalida");
        exit();
    }

    if (strtotime($fecha) <= strtotime('today')) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/eventos/crear_evento.php?error=fecha_invalida");
        exit();
    }

    try {
        // Verificar si ya existe un evento destacado
        if ($destacado == 1) {
            $sql_check = "SELECT id_evento FROM eventos WHERE es_destacada = 1 LIMIT 1";
            $result = $pdo->query($sql_check);

            if ($result->rowCount() > 0) {
                // Guardar los datos del nuevo evento en sesión y redirigir a confirmación
                $_SESSION['evento_destacado_existente'] = true;
                $_SESSION['evento_destacado_data'] = [
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'fecha' => $fecha,
                    'destacado' => $destacado,
                    'id_usuario' => $id_usuario
                ];
                header("Location: /Proyecto-Comunidad/web/eventos/confirmar_reemplazo.php");
                exit();
            }
        }

        // Insertar directamente si no hay conflicto
        $sql = "INSERT INTO eventos (titulo, descripcion, fecha, id_usuario, es_destacada)
                VALUES (:titulo, :descripcion, :fecha, :id_usuario, :es_destacada)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':fecha' => $fecha,
            ':id_usuario' => $id_usuario,
            ':es_destacada' => $destacado
        ]);

        header("Location: /Proyecto-Comunidad/web/eventos/index.php");
        exit();

    } catch (PDOException $e) {
        echo "Error al crear el evento: " . $e->getMessage();
    }
}
?>

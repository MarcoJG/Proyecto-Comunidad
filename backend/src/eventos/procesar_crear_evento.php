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
    $destacado = isset($_POST['destacado']) ? $_POST['destacado'] : 0; // 1 si está marcado, 0 si no

    // Validaciones
    if (empty($titulo) || empty($descripcion) || empty($fecha)) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/crear_evento.php?error=faltan_datos");
        exit();
    }

    if (strlen($titulo) > 100 || strlen($descripcion) > 255) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/crear_evento.php?error=longitud_invalida");
        exit();
    }

    if (strtotime($fecha) <= strtotime('today')) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'destacado' => $destacado
        ];
        header("Location: ../../../web/crear_evento.php?error=fecha_invalida");
        exit();
    }

    try {
        // Insertar en la BBDD, incluyendo si el evento es destacado
        $sql = "INSERT INTO eventos (titulo, descripcion, fecha, id_usuario, es_destacada) 
                VALUES (:titulo, :descripcion, :fecha, :id_usuario, :es_destacada)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindValue(':es_destacada', $destacado, PDO::PARAM_INT); // Guardar si es destacado

        $stmt->execute();

        // Redireccionar tras creación exitosa
        header("Location: ../../../web/src/eventos/index.php");
        exit();

    } catch (PDOException $e) {
        echo "Error al crear el evento: " . $e->getMessage();
    }
}
?>

<?php
session_start();

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificar usuario Admin
    if (!isset($_SESSION['id_usuario']) || !isset($_SESSION["nombre_rol"]) || $_SESSION["nombre_rol"] !== "Admin") {
        die("No autorizado.");
     }

    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    $id_usuario = $_SESSION['id_usuario'];
   

    // Validaciones
    if (empty($titulo) || empty($descripcion) || empty($fecha)) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_evento.php?error=faltan_datos");
        exit();
    }

    if (strlen($titulo) > 100 || strlen($descripcion) > 255) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_evento.php?error=longitud_invalida");
        exit();
    }

    if (strtotime($fecha) <= strtotime('today')) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_evento.php?error=fecha_invalida");
        exit();
    }

    try {
        // Insertar en la BBDD
        $sql = "INSERT INTO eventos (titulo, descripcion, fecha, id_usuario) VALUES (:titulo, :descripcion, :fecha, :id_usuario)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        $stmt->execute();
        // header("Location: ../../../web/eventos.php?mensaje=Evento+creado+correctamente");
        header("Location: ../../../web/src/eventos/index.php");
        exit();
        
        $stmt->close();
        $conexion->close();
    } catch (PDOException $e) {
        // Si ocurre un error, lo capturamos y mostramos
        echo "Error al crear el evento: " . $e->getMessage();
    }
}
?>
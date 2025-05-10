<?php
session_start();

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificar usuario Admin
    if (!isset($_SESSION['id_usuario']) || !isset($_SESSION["nombre_rol"]) || $_SESSION["nombre_rol"] !== "Admin") {
        die("No autorizado.");
     }

    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    $id_usuario = $_SESSION['id_usuario'];
   

    // Validaciones
    if (empty($titulo) || empty($contenido) || empty($fecha)) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $contenido,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_noticia.php?error=faltan_datos");
        exit();
    }

    if (strlen($titulo) > 100 || strlen($contenido) > 255) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $contenido,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_noticia.php?error=longitud_invalida");
        exit();
    }

    if (strtotime($fecha) <= strtotime('today')) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $contenido,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_noticia.php?error=fecha_invalida");
        exit();
    }

    try {
        // Insertar en la BBDD
        $sql = "INSERT INTO noticias (titulo, contenido, fecha, id_usuario) VALUES (:titulo, :contenido, :fecha, :id_usuario)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindValue(':contenido', $contenido, PDO::PARAM_STR);
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        $stmt->execute();
        
        header("Location: ../../../web/src/noticias/index.php");
        exit();
        
        $stmt->close();
        $conexion->close();
    } catch (PDOException $e) {
        // Si ocurre un error, lo capturamos y mostramos
        echo "Error al crear la noticia: " . $e->getMessage();
    }
}
?>
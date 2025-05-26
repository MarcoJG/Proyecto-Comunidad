<?php
require_once __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_noticias'])) {
    $id_noticias = intval($_POST['id_noticias']);

    try {
        $stmt = $pdo->prepare("DELETE FROM noticias WHERE id_noticias = :id_noticias");
        $stmt->bindParam(':id_noticias', $id_noticias, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../../../web/src/noticias/index.php");
            exit();
        } else {
            echo "Error al borrar la noticia.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Datos no válidos.";
}
?>

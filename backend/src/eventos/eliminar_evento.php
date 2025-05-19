<?php
require_once __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_evento'])) {
    $id_evento = intval($_POST['id_evento']);

    try {
        $stmt = $pdo->prepare("DELETE FROM eventos WHERE id_evento = :id_evento");
        $stmt->bindParam(':id_evento', $id_evento, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../../../web/src/eventos/index.php?mensaje=eliminado");
            exit();
        } else {
            echo "Error al borrar el evento.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Datos no válidos.";
}
?>

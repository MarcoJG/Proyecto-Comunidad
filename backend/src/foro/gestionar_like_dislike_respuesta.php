<?php
header('Content-Type: application/json');
session_start();
require_once '../conexion_BBDD/conexion_db_pm.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_respuesta = $_POST['id_respuesta'] ?? '';
    $accion = $_POST['accion'] ?? ''; // 'like' o 'dislike'
    $tipo = $_POST['tipo'] ?? '';     // 'add' o 'remove'
    $id_usuario = $_SESSION["id_usuario"] ?? null;

    if (!empty($id_respuesta) && !empty($accion) && !empty($tipo) && $id_usuario !== null) {
        $tabla = 'likes_respuestas';

        file_put_contents("log_likes.txt", json_encode([
            'id_usuario' => $_SESSION["id_usuario"] ?? null
        ]) . PHP_EOL, FILE_APPEND);
        
        // Eliminar cualquier voto previo del usuario
        $stmtDeletePrev = $pdo->prepare("DELETE FROM $tabla WHERE id_respuesta = :id_respuesta AND id_usuario = :id_usuario");
        $stmtDeletePrev->bindParam(':id_respuesta', $id_respuesta);
        $stmtDeletePrev->bindParam(':id_usuario', $id_usuario);
        $stmtDeletePrev->execute();

        if ($tipo === 'add') {
            // Insertar nuevo voto
            $stmt = $pdo->prepare("INSERT INTO $tabla (id_respuesta, id_usuario, tipo) VALUES (:id_respuesta, :id_usuario, :tipo)");
            $stmt->bindParam(':id_respuesta', $id_respuesta);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':tipo', $accion); // 'like' o 'dislike'

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo json_encode(['error' => "Error al añadir el $accion: " . $e->getMessage()]);
                exit;
            }
        }

        // Obtener recuento actualizado
        $stmtCount = $pdo->prepare("
            SELECT 
                SUM(CASE WHEN tipo = 'like' THEN 1 ELSE 0 END) AS likes,
                SUM(CASE WHEN tipo = 'dislike' THEN 1 ELSE 0 END) AS dislikes
            FROM $tabla
            WHERE id_respuesta = :id_respuesta
        ");
        $stmtCount->bindParam(':id_respuesta', $id_respuesta);
        $stmtCount->execute();
        $result = $stmtCount->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'likes' => (int)$result['likes'],
            'dislikes' => (int)$result['dislikes']
        ]);
    } else {
        echo json_encode(['error' => "Faltan datos o sesión de usuario"]);
    }
} else {
    echo json_encode(['error' => "Método no permitido"]);
}
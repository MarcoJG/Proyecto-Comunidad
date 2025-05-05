<?php
require_once '../config.php';
require_once '../utils/sesion.php';
require_once '../db/conexion.php';

if (!isset($_GET['id_respuesta'])) {
    echo json_encode(['error' => 'ID de respuesta no proporcionado']);
    exit;
}

$id_respuesta = intval($_GET['id_respuesta']);

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS dislikes FROM likes_respuestas WHERE id_respuesta = ? AND tipo = 'dislike'");
    $stmt->execute([$id_respuesta]);
    $dislikes = $stmt->fetch(PDO::FETCH_ASSOC)['dislikes'];

    echo json_encode(['dislikes' => intval($dislikes)]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener dislikes de la respuesta.']);
}
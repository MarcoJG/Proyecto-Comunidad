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
    $stmt = $pdo->prepare("SELECT COUNT(*) AS likes FROM likes_respuestas WHERE id_respuesta = ? AND tipo = 'like'");
    $stmt->execute([$id_respuesta]);
    $likes = $stmt->fetch(PDO::FETCH_ASSOC)['likes'];

    echo json_encode(['likes' => intval($likes)]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener likes de la respuesta.']);
}
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../conexion_BBDD/conexion_db_pm.php';

$stmt = $pdo->query("
    SELECT
        h.id_hilo AS id,
        h.titulo,
        h.contenido,
        h.fecha,
        u.usuario AS autor,
        (SELECT COUNT(*) FROM respuesta WHERE id_hilo = h.id_hilo) AS respuestas_count,
        (SELECT COUNT(*) FROM likes_hilo WHERE id_hilo = h.id_hilo) AS likes,
        (SELECT COUNT(*) FROM dislikes_hilo WHERE id_hilo = h.id_hilo) AS dislikes
    FROM hilo h
    JOIN usuarios u ON h.id_usuario = u.id_usuario
    ORDER BY h.fecha DESC
");

$hilos = $stmt->fetchAll();

// Para cada hilo, obtener sus respuestas
foreach ($hilos as &$hilo) {
    $stmtRespuestas = $pdo->prepare("
    SELECT
        r.id_respuesta AS id,
        r.contenido,
        r.fecha,
        u.usuario AS autor,
        (
            SELECT COUNT(*) 
            FROM likes_respuestas 
            WHERE id_respuesta = r.id_respuesta AND tipo = 'LIKE'
        ) AS likes,
        (
            SELECT COUNT(*) 
            FROM likes_respuestas 
            WHERE id_respuesta = r.id_respuesta AND tipo = 'DISLIKE'
        ) AS dislikes
    FROM respuesta r
    JOIN usuarios u ON r.id_usuario = u.id_usuario
    WHERE r.id_hilo = :id_hilo
    ORDER BY r.fecha ASC
");
    $stmtRespuestas->bindParam(':id_hilo', $hilo['id']);
    $stmtRespuestas->execute();
    $hilo['respuestas'] = $stmtRespuestas->fetchAll();
}

echo json_encode($hilos);
<?php
include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM eventos WHERE es_destacada = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['existe' => $row['total'] > 0]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if (!isset($_SESSION['nombre_rol']) || !in_array($_SESSION['nombre_rol'], ['Admin', 'Presidente'])) {
    http_response_code(403);
    echo json_encode(["error" => "Acceso no autorizado"]);
    exit;
}

date_default_timezone_set('Europe/Madrid');
$hoy = date('Y-m-d H:i:s');

try {
    $stmt = $pdo->prepare("SELECT rz.id_reserva, rz.zona, rz.fecha_reserva, u.nombre AS nombre_usuario
                           FROM reserva_zona_comun rz
                           INNER JOIN usuarios u ON rz.id_usuario = u.id_usuario
                           WHERE rz.fecha_reserva >= ?
                           ORDER BY rz.fecha_reserva ASC");
    $stmt->execute([$hoy]);
    $reservas = $stmt->fetchAll();

    echo json_encode($reservas);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al obtener las reservas: " . $e->getMessage()]);
}

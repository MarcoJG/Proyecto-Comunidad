<?php
session_start();
require_once __DIR__ . '/../../conexion_BBDD/conexion_db_pm.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: /Proyecto-Comunidad/web/public/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

date_default_timezone_set('Europe/Madrid');
$hoy = date('Y-m-d H:i:s');

try {
    // Reservas activas
    $stmtActivas = $pdo->prepare("SELECT zona, fecha_reserva, id_reserva
                                  FROM reserva_zona_comun
                                  WHERE id_usuario = ? AND fecha_reserva >= ?
                                  ORDER BY fecha_reserva ASC");
    $stmtActivas->execute([$id_usuario, $hoy]);
    $reservas_activas = $stmtActivas->fetchAll();

    // Historial (últimas 5)
    $stmtHistorico = $pdo->prepare("SELECT zona, fecha_reserva, id_reserva
                                    FROM reserva_zona_comun
                                    WHERE id_usuario = ? AND fecha_reserva < ?
                                    ORDER BY fecha_reserva DESC
                                    LIMIT 5");
    $stmtHistorico->execute([$id_usuario, $hoy]);
    $reservas_pasadas = $stmtHistorico->fetchAll();

} catch (PDOException $e) {
    die("Error al obtener las reservas: " . $e->getMessage());
}
?>
<?php
require_once("../conexion_BBDD/conexion_db_pm.php");

if (!isset($_GET['zona']) || !isset($_GET['fecha'])) {
    echo json_encode(['error' => 'Faltan parámetros']);
    exit;
}

$zona = $_GET['zona'];
$fecha = $_GET['fecha'];

$turnos = ['mañana' => '09:00:00', 'tarde' => '16:00:00'];
$resultado = [];

try {
    $stmt_aforo = $pdo->prepare("SELECT aforo_maximo FROM aforo_zona WHERE zona = ?");
    $stmt_aforo->execute([$zona]);
    $aforo = $stmt_aforo->fetchColumn();

    if (!$aforo) {
        echo json_encode(['error' => 'Zona no encontrada']);
        exit;
    }

    foreach ($turnos as $turno => $hora) {
        $fechaCompleta = $fecha . ' ' . $hora;

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reserva_zona_comun WHERE zona = ? AND fecha_reserva = ?");
        $stmt->execute([$zona, $fechaCompleta]);
        $reservas = $stmt->fetchColumn();

        if ($reservas < $aforo) {
            $resultado[] = $turno;
        }
    }

    echo json_encode($resultado);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

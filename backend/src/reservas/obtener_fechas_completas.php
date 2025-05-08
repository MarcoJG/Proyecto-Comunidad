<?php
require_once("../conexion_BBDD/conexion_db_pm.php");

if (!isset($_GET['zona'])) {
    echo json_encode([]);
    exit;
}

$zona = $_GET['zona'];
$turnos = ['09:00:00', '16:00:00'];
$fechasCompletas = [];

try {
    // Aforo máximo
    $stmt_aforo = $pdo->prepare("SELECT aforo_maximo FROM aforo_zona WHERE zona = ?");
    $stmt_aforo->execute([$zona]);
    $aforo = $stmt_aforo->fetchColumn();

    if (!$aforo) {
        echo json_encode([]);
        exit;
    }

    // Obtener fechas con reservas
    $stmt_fechas = $pdo->prepare("
        SELECT DATE(fecha_reserva) as fecha
        FROM reserva_zona_comun
        WHERE zona = ?
        GROUP BY DATE(fecha_reserva)
    ");
    $stmt_fechas->execute([$zona]);
    $fechas = $stmt_fechas->fetchAll(PDO::FETCH_COLUMN);

    foreach ($fechas as $fecha) {
        $turnosLlenos = 0;
        foreach ($turnos as $hora) {
            $fechaCompleta = $fecha . ' ' . $hora;
            $stmt = $pdo->prepare("
                SELECT COUNT(*) FROM reserva_zona_comun
                WHERE zona = ? AND fecha_reserva = ?
            ");
            $stmt->execute([$zona, $fechaCompleta]);
            $count = $stmt->fetchColumn();

            if ($count >= $aforo) {
                $turnosLlenos++;
            }
        }

        if ($turnosLlenos == 2) {
            $fechasCompletas[] = $fecha;
        }
    }

    echo json_encode($fechasCompletas);
} catch (PDOException $e) {
    echo json_encode([]);
}

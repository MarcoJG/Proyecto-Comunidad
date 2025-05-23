<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("../conexion_BBDD/conexion_db_pm.php"); 


if (!isset($_SESSION['usuario'])) {
    header("Location: /Proyecto-Comunidad/web/public/login.php"); 
    exit;
}

$usuario = $_SESSION['usuario'];
$zona = $_POST['zona'] ?? null;
$fecha = $_POST['fecha'] ?? null;
$turno = $_POST['turno'] ?? null;


if (!$zona || !$fecha || !$turno) {
    die("Faltan datos para procesar la reserva.");
}

// Convertir turno a hora
$horaTurno = match($turno) {
    "mañana" => "09:00:00",
    "tarde" => "16:00:00",
    default => null
};

if (!$horaTurno) {
    die("Turno inválido.");
}

// Fecha y hora completa para almacenar
$fechaReserva = $fecha . " " . $horaTurno;

try {
    // Aforo máximo para la zona
    $stmt = $pdo->prepare("SELECT aforo_maximo FROM aforo_zona WHERE zona = ?");
    $stmt->execute([$zona]);
    $aforoMaximo = $stmt->fetchColumn();

    if (!$aforoMaximo) {
        die("Zona no válida.");
    }

    // Contar reservas existentes para esa fecha/hora
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reserva_zona_comun WHERE zona = ? AND fecha_reserva = ?");
    $stmt->execute([$zona, $fechaReserva]);
    $reservasActuales = $stmt->fetchColumn();

    if ($reservasActuales >= $aforoMaximo) {
        die("No hay plazas disponibles para esa fecha y turno.");
    }

    // Insertar reserva bbdd
    $stmt = $pdo->prepare("INSERT INTO reserva_zona_comun (id_usuario, zona, fecha_reserva) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['id_usuario'], $zona, $fechaReserva]);

    // Redirigir a "Mis Reservas" con éxito
    header("Location: /Proyecto-Comunidad/web/src/reservas/mis_reservas.php?success=1");
    exit;

} catch (PDOException $e) {
    // Error, mensaje general o enviar a un log para admins
    error_log("Error al procesar la reserva: " . $e->getMessage());
    die("Error al procesar la reserva.");
}

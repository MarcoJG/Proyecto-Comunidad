<?php
session_start();
require_once("../conexion_BBDD/conexion_db_pm.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../../web/src/login/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $zona = $_POST['zona'];
    $fecha = $_POST['fecha'];
    $turno = $_POST['turno'];
    $id_usuario = $_SESSION['id_usuario']; 

    if (empty($zona) || empty($fecha) || empty($turno)) {
        die('Faltan datos en la solicitud');
    }

    try {
        $fechaCompleta = $fecha . ' ' . ($turno == 'mañana' ? '09:00:00' : '16:00:00');

        $stmt = $pdo->prepare("INSERT INTO reserva_zona_comun (fecha_reserva, zona, id_usuario) VALUES (?, ?, ?)");
        $stmt->execute([$fechaCompleta, $zona, $id_usuario]);

        // Guardar datos para el popup
        $_SESSION['mensaje_reserva'] = [
            'zona' => $zona,
            'fecha' => $fecha,
            'turno' => $turno
        ];

        header("Location: mostrar_mensaje.php");
        exit; 
    } catch (PDOException $e) {
        echo "Error al reservar: " . $e->getMessage();
    }
} else {
    header("Location: ../../../web/src/reservas/reservas.php");
    exit; 
}

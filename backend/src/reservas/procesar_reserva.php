<?php
session_start();
require_once("../conexion_BBDD/conexion_db_pm.php");

// DESACTIVAMOS LOGIN TEMPORALMENTE
// if (!isset($_SESSION['id_usuario'])) {
//     header("Location: ../../../web/src/login/index.php");
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $zona = $_POST['zona'];
    $fecha = $_POST['fecha'];
    $turno = $_POST['turno'];

    // ID DE USUARIO FIJO PARA PRUEBAS (1 como ID válido en BBDD)
    $id_usuario = 1;

    // Validaciones 
    if (empty($zona) || empty($fecha) || empty($turno)) {
        die('Faltan datos en la solicitud');
    }

    // Insertar reserva
    try {
        $fechaCompleta = $fecha . ' ' . ($turno == 'mañana' ? '09:00:00' : '16:00:00');

        $stmt = $pdo->prepare("INSERT INTO reserva_zona_comun (fecha_reserva, zona, id_usuario) VALUES (?, ?, ?)");
        $stmt->execute([$fechaCompleta, $zona, $id_usuario]);

        header("Location: ../../../web/src/reservas/reservas.php?success=1");
    } catch (PDOException $e) {
        echo "Error al reservar: " . $e->getMessage();
    }
} else {
    header("Location: ../../../web/src/reservas/reservas.php");
    exit();
}
?>

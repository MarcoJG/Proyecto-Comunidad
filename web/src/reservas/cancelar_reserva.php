<?php
session_start();
require_once __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';



// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: /Proyecto-Comunidad/web/public/login.php"); // Redirige si no está logueado
    exit;
}

// Verificar que el parámetro 'id' está presente en la URL
if (!isset($_GET['id'])) {
    die("No se especificó la reserva a cancelar.");
}

$id_reserva = $_GET['id'];

try {
    // Eliminar la reserva de la base de datos
    $stmt = $pdo->prepare("DELETE FROM reserva_zona_comun WHERE id_reserva = ? AND id_usuario = ?");
    $stmt->execute([$id_reserva, $_SESSION['id_usuario']]);

    // Redirigir a la página de "Mis Reservas" con el mensaje de éxito
    header("Location: /Proyecto-Comunidad/web/src/reservas/mis_reservas.php?success=2"); // 2 es para indicar que se canceló la reserva
    exit;

} catch (PDOException $e) {
    die("Error al cancelar la reserva: " . $e->getMessage());
}

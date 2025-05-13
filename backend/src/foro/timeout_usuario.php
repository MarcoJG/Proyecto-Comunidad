<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
session_start();
require_once '../conexion_BBDD/conexion_db_pm.php';

function esAdmin() {
    return isset($_SESSION["nombre_rol"]) && $_SESSION["nombre_rol"] === 'Admin';
}

if (!esAdmin()) {
    echo json_encode(['error' => 'No tienes permisos para aplicar timeouts a usuarios.']);
    
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_a_timeout = $_POST['usuario'] ?? '';
    $duracion = $_POST['duracion'] ?? '';

    if (!empty($usuario_a_timeout) && is_numeric($duracion) && $duracion > 0) {
        $fecha_actual = new DateTime();
        $fecha_fin = $fecha_actual->modify('+' . intval($duracion) . 'minutes');
        $fecha_fin_str = $fecha_fin->format('Y-m-d H:i:s');

        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET fecha_fin_timeout = :fecha_fin WHERE usuario = :usuario");
            $stmt->bindParam(':fecha_fin', $fecha_fin_str);
            $stmt->bindParam(':usuario', $usuario_a_timeout);
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Timeout aplicado a "' . htmlspecialchars($usuario_a_timeout)
                                  . '" hasta ' . $fecha_fin_str . '.']);
            } else {
                echo json_encode(['error' => 'Error al aplicar timeout al usuario.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos al aplicar timeout: ' . $e->getMessage()]);
        }
    } else {
        $error_message = '';
        if (empty($usuario_a_timeout)) $error_message .= 'Nombre de usuario no proporcionado, ';
        if (empty($duracion) || !is_numeric($duracion) || $duracion <= 0) $error_message .= 'Duración del timeout no válida.';
        echo json_encode(['error' => trim($error_message)]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
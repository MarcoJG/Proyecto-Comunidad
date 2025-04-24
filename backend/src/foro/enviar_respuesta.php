<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
session_start();
require_once '../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_hilo = $_POST['id_hilo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $id_usuario = $_SESSION["id_usuario"] ?? null;

    if (!empty($id_hilo) && !empty($contenido) && $id_usuario !== null) {
        $fecha = date('Y-m-d');

        $stmt = $pdo->prepare("INSERT INTO respuesta (contenido, fecha, id_hilo, id_usuario) VALUES (:contenido, :fecha, :id_hilo, :id_usuario)");
        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id_hilo', $id_hilo);
        $stmt->bindParam(':id_usuario', $id_usuario);

        if ($stmt->execute()) {
            echo json_encode(['success' => 'Respuesta enviada correctamente']);
        } else {
            echo json_encode(['error' => 'Error al enviar la respuesta']);
        }
    } else {
        $error_message = '';
        if (empty($id_hilo)) $error_message .= 'El ID del hilo es necesario. ';
        if (empty($contenido)) $error_message .= 'El contenido de la respuesta es obligatorio. ';
        if ($id_usuario === null) $error_message .= 'La información del usuario no está disponible. Por favor, inicia sesión nuevamente.';
        echo json_encode(['error' => trim($error_message)]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
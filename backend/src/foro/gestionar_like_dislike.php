<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} // Iniciar sesión
require_once '../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_hilo = $_POST['id_hilo'] ?? '';
    $accion = $_POST['accion'] ?? ''; // 'like' o 'dislike'
    $tipo = $_POST['tipo'] ?? ''; // 'add' o 'remove'
    // **Importante:** Obtener el ID del usuario autenticado de la sesión
    $id_usuario = $_SESSION["id_usuario"] ?? null;

    if (!empty($id_hilo) && !empty($accion) && !empty($tipo) && $id_usuario !== null) {
        $tabla = ($accion === 'like') ? 'likes_hilo' : 'dislikes_hilo';
        $columna_id = ($accion === 'like') ? 'id_like' : 'id_dislike';

        if ($tipo === 'add') {
            $stmt = $pdo->prepare("INSERT INTO $tabla (id_hilo, id_usuario) VALUES (:id_hilo, :id_usuario)");
            $stmt->bindParam(':id_hilo', $id_hilo);
            $stmt->bindParam(':id_usuario', $id_usuario);
            try {
                $stmt->execute();
                echo json_encode(['success' => ucfirst($accion) . ' añadido']);
            } catch (PDOException $e) {
                // Manejar el caso de que el usuario ya haya dado like/dislike
                if ($e->getCode() == '23000') {
                    echo json_encode(['info' => 'Ya has dado ' . $accion . ' a este hilo.']);
                } else {
                    echo json_encode(['error' => 'Error al añadir el ' . $accion . ': ' . $e->getMessage()]);
                }
            }
        } elseif ($tipo === 'remove') {
            $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_hilo = :id_hilo AND id_usuario = :id_usuario");
            $stmt->bindParam(':id_hilo', $id_hilo);
            $stmt->bindParam(':id_usuario', $id_usuario);
            if ($stmt->execute()) {
                echo json_encode(['success' => ucfirst($accion) . ' eliminado']);
            } else {
                echo json_encode(['error' => 'Error al eliminar el ' . $accion]);
            }
        } else {
            echo json_encode(['error' => 'Tipo de acción no válido']);
        }
    } else {
        $error_message = '';
        if (empty($id_hilo)) $error_message .= 'El ID del hilo es necesario. ';
        if (empty($accion)) $error_message .= 'La acción (like/dislike) es necesaria. ';
        if (empty($tipo)) $error_message .= 'El tipo de acción (add/remove) es necesario. ';
        if ($id_usuario === null) $error_message .= 'La información del usuario no está disponible. Por favor, inicia sesión nuevamente.';
        echo json_encode(['error' => trim($error_message)]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} // Iniciar sesión
require_once '../conexion_BBDD/conexion_db_pm.php';

// Función para obtener el rol del usuario de la sesión
function obtenerRolUsuarioActual() {
    return $_SESSION["nombre_rol"] ?? null;
}

// Función para obtener el ID del usuario de la sesión
function obtenerIdUsuarioActual() {
    return $_SESSION["id_usuario"] ?? null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_hilo = $_POST['id_hilo'] ?? '';
    $id_usuario_actual = obtenerIdUsuarioActual();
    $rol_usuario_actual = obtenerRolUsuarioActual();

    if ($id_usuario_actual !== null) {
        // Obtener información del hilo para verificar el autor
        $stmtGetHilo = $pdo->prepare("SELECT id_usuario FROM hilo WHERE id_hilo = :id_hilo");
        $stmtGetHilo->bindParam(':id_hilo', $id_hilo);
        $stmtGetHilo->execute();
        $hiloInfo = $stmtGetHilo->fetch();

        if ($hiloInfo) {
            $autorHilo = $hiloInfo['id_usuario'];

            // Verificar si el usuario actual es el autor del hilo o un administrador
            if ($autorHilo == $id_usuario_actual || $rol_usuario_actual === 'Admin') {
                // Primero, borrar los likes y dislikes asociados al hilo
                $stmtLikes = $pdo->prepare("DELETE FROM likes_hilo WHERE id_hilo = :id_hilo");
                $stmtLikes->bindParam(':id_hilo', $id_hilo);
                $stmtLikes->execute();

                $stmtDislikes = $pdo->prepare("DELETE FROM dislikes_hilo WHERE id_hilo = :id_hilo");
                $stmtDislikes->bindParam(':id_hilo', $id_hilo);
                $stmtDislikes->execute();

                // Luego, borrar las respuestas asociadas al hilo
                $stmtRespuestas = $pdo->prepare("DELETE FROM respuesta WHERE id_hilo = :id_hilo");
                $stmtRespuestas->bindParam(':id_hilo', $id_hilo);
                $stmtRespuestas->execute();

                // Finalmente, borrar el hilo
                $stmtHilo = $pdo->prepare("DELETE FROM hilo WHERE id_hilo = :id_hilo");
                $stmtHilo->bindParam(':id_hilo', $id_hilo);

                if ($stmtHilo->execute()) {
                    echo json_encode(['success' => 'Hilo borrado correctamente']);
                } else {
                    echo json_encode(['error' => 'Error al borrar el hilo']);
                }
            } else {
                echo json_encode(['error' => 'No tienes permiso para borrar este hilo.']);
            }
        } else {
            echo json_encode(['error' => 'Hilo no encontrado.']);
        }
    } else {
        echo json_encode(['error' => 'La información del usuario no está disponible. Por favor, inicia sesión nuevamente.']);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
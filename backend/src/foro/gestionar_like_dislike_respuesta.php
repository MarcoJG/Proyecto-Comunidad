<?php
header('Content-Type: application/json');
session_start();
require_once '../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_respuesta = $_POST['id_respuesta'] ?? '';
    $accion = $_POST['accion'] ?? ''; // like o dislike
    $tipo = $_POST['tipo'] ?? '';     // add o remove
    $id_usuario = $_SESSION["id_usuario"] ?? null;

    if (!empty($id_respuesta) && !empty($accion) && !empty($tipo) && $id_usuario !== null) {
        $tabla = ($accion === 'like') ? 'likes_respuesta' : 'dislikes_respuesta';

        if ($tipo === 'add') {
            $stmt = $pdo->prepare("INSERT INTO $tabla (id_respuesta, id_usuario) VALUES (:id_respuesta, :id_usuario)");
            $stmt->bindParam(':id_respuesta', $id_respuesta);
            $stmt->bindParam(':id_usuario', $id_usuario);
            try {
                $stmt->execute();
                echo json_encode(['success' => "$accion añadido"]);
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    echo json_encode(['info' => "Ya has dado $accion a esta respuesta."]);
                } else {
                    echo json_encode(['error' => "Error al añadir el $accion: " . $e->getMessage()]);
                }
            }
        } elseif ($tipo === 'remove') {
            $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_respuesta = :id_respuesta AND id_usuario = :id_usuario");
            $stmt->bindParam(':id_respuesta', $id_respuesta);
            $stmt->bindParam(':id_usuario', $id_usuario);
            if ($stmt->execute()) {
                echo json_encode(['success' => "$accion eliminado"]);
            } else {
                echo json_encode(['error' => "Error al eliminar el $accion"]);
            }
        } else {
            echo json_encode(['error' => "Tipo de acción no válido"]);
        }
    } else {
        echo json_encode(['error' => "Faltan datos o sesión de usuario"]);
    }
} else {
    echo json_encode(['error' => "Método no permitido"]);
}
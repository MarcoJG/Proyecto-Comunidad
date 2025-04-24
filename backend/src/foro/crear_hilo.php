<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
session_start(); // Con esto podremos acceder a la información de $_SESSION para id_usuario y cosas necesarias
require_once '../conexion_BBDD/conexion_db_pm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $id_usuario = $_SESSION["id_usuario"] ?? null;

    if (!empty($titulo) && !empty($contenido) && $id_usuario !== null) {
        $fecha = date('Y-m-d');
        $id_foro = 1;

        $stmt = $pdo->prepare("INSERT INTO hilo (titulo, contenido, fecha, id_foro, id_usuario) VALUES (:titulo, :contenido, :fecha, :id_foro, :id_usuario)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id_foro', $id_foro);
        $stmt->bindParam(':id_usuario', $id_usuario);

        if ($stmt->execute()) {
            echo json_encode(['success' => 'Hilo creado correctamente']);
        } else {
            echo json_encode(['error' => 'Error al crear el hilo']);
        }
    } else {
        $error_message = '';
        if (empty($titulo)) $error_message .= 'El título del hilo es obligatorio. ';
        if (empty($contenido)) $error_message .= 'El contenido del hilo es obligatorio. ';
        if ($id_usuario === null) $error_message .= 'La información del usuario no está disponible. Por favor, inicia sesión nuevamente.';
        echo json_encode(['error' => trim($error_message)]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
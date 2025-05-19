<?php
session_start();
header('Content-Type: application/json');

require_once '../conexion_BBDD/conexion_db_pm.php';

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'Sesión no iniciada. Por favor, inicia sesión.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_hilo = $_POST['id_hilo'] ?? null;
    $contenido = $_POST['contenido'] ?? null;
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['id_usuario'];

    if (empty($id_hilo) || empty($contenido)) {
        echo json_encode(['error' => 'Hilo y contenido son obligatorios.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO respuesta (id_hilo, contenido, fecha, id_usuario)
            VALUES (:id_hilo, :contenido, :fecha, :id_usuario)
        ");
        $stmt->execute([
            ':id_hilo' => $id_hilo,
            ':contenido' => $contenido,
            ':fecha' => $fecha,
            ':id_usuario' => $id_usuario
        ]);

        echo json_encode(['success' => 'Respuesta enviada correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Excepción del servidor']);
    }
}
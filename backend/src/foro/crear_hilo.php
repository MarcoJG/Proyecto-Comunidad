<?php
session_start();
header('Content-Type: application/json');

require_once '../conexion_BBDD/conexion_db_pm.php';

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'Sesión no iniciada. Por favor, inicia sesión.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $id_foro = $_POST['id_foro'] ?? 1; // Puedes ajustar esto según el foro correspondiente
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['id_usuario'];

    if (empty($titulo) || empty($contenido)) {
        echo json_encode(['error' => 'Título y contenido son obligatorios.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO hilo (titulo, contenido, fecha, id_foro, id_usuario)
            VALUES (:titulo, :contenido, :fecha, :id_foro, :id_usuario)
        ");
        $stmt->execute([
            ':titulo' => $titulo,
            ':contenido' => $contenido,
            ':fecha' => $fecha,
            ':id_foro' => $id_foro,
            ':id_usuario' => $id_usuario
        ]);

        echo json_encode(['success' => 'Hilo creado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error de base de datos']);
    }
}
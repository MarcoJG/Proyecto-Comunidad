<?php
header('Content-Type: application/json');
require_once '../conexion_BBDD/conexion_db_pm.php';

try {
    $stmt = $pdo->prepare("INSERT INTO hilo (titulo, contenido, fecha, id_foro, id_usuario) VALUES ('Prueba', 'Contenido de prueba', '2024-04-24', 1, 1)");
    $stmt->execute();
    echo json_encode(['success' => 'Inserción exitosa']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>
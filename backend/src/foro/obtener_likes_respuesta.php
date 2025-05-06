<?php
require_once '../conexion_BBDD/conexion_db_pm.php';

$sql = "SELECT id, likes, dislikes FROM respuestas";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();

$respuestas = [];
while ($row = $resultado->fetch_assoc()) {
    $respuestas[$row['id']] = [
        'likes' => (int)$row['likes'],
        'dislikes' => (int)$row['dislikes']
    ];
}

header('Content-Type: application/json');
echo json_encode($respuestas);
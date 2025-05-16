<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(["error" => "Acceso no autorizado."]);
    exit();
}


$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Filtro de usuario si está 
$filtro_usuario = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : '';

// Consultar reservas
if ($filtro_usuario) {
    $sql_reservas = "SELECT * FROM reservas WHERE usuario_id = ?";
    $stmt = $conexion->prepare($sql_reservas);
    $stmt->bind_param('i', $filtro_usuario);
    $stmt->execute();
    $result_reservas = $stmt->get_result();
} else {
    $sql_reservas = "SELECT * FROM reservas";
    $result_reservas = $conexion->query($sql_reservas);
}

$reservas = [];
while ($row = $result_reservas->fetch_assoc()) {
    $usuario_id = $row['usuario_id'];
    // Obtener nombre del usuario
    $sql_usuario = "SELECT nombre FROM usuarios WHERE id = ?";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bind_param('i', $usuario_id);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();
    $usuario = $result_usuario->fetch_assoc();
    
    // Respuesta
    $reservas[] = [
        'id_reserva' => $row['id_reserva'],
        'usuario' => $usuario['nombre'],
        'fecha_reserva' => $row['fecha_reserva'],
        'detalles' => $row['detalles']
    ];
}

$conexion->close();

// Reservas en JSON
echo json_encode($reservas);
?>

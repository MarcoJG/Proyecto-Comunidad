<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION["usuario"])) {
    echo json_encode(['success' => true, 'usuario' => $_SESSION["usuario"], 'correo' => $_SESSION["correo"] ?? '']);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario no identificado']);
}
?>
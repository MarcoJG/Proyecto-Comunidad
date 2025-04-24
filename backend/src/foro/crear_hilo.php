<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
session_start(); // Con esto podremos acceder a la información de $_SESSION para id_usuario y cosas necesarias
require_once '../conexion_BBDD/conexion_db_pm.php';

error_log('Inicio de crear_hilo.php'); // Log al inicio del script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $id_usuario = $_SESSION["id_usuario"] ?? null;

    error_log('Valores recibidos:');
    error_log('  titulo: ' . print_r($titulo, true));
    error_log('  contenido: ' . print_r($contenido, true));
    error_log('  id_usuario: ' . print_r($id_usuario, true));

    if (!empty($titulo) && !empty($contenido) && $id_usuario !== null) {
        $fecha = date('Y-m-d');
        $id_foro = 1;

        $stmt = $pdo->prepare("INSERT INTO hilo (titulo, fecha, id_foro, id_usuario) VALUES (:titulo, :fecha, :id_foro, :id_usuario)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id_foro', $id_foro);
        $stmt->bindParam(':id_usuario', $id_usuario);

        error_log('Consulta SQL: ' . $stmt->queryString);
        error_log('Parámetros: ' . print_r($stmt->debugDumpParams(), true));

        try {
            $result = $stmt->execute();
            error_log('Resultado de execute(): ' . print_r($result, true));

            if ($result) {
                error_log('Hilo creado correctamente');
                echo json_encode(['success' => 'Hilo creado correctamente']);
            } else {
                error_log('Error al crear el hilo (execute() falló)');
                echo json_encode(['error' => 'Error al crear el hilo']);
            }
        } catch (PDOException $e) {
            error_log('Error de la base de datos: ' . $e->getMessage());
            echo json_encode(['error' => 'Error de la base de datos: ' . $e->getMessage()]);
        }
    } else {
        $error_message = '';
        if (empty($titulo)) $error_message .= 'El título del hilo es obligatorio. ';
        if (empty($contenido)) $error_message .= 'El contenido del hilo es obligatorio. ';
        if ($id_usuario === null) $error_message .= 'La información del usuario no está disponible. Por favor, inicia sesión nuevamente.';
        error_log('Error de validación: ' . $error_message);
        echo json_encode(['error' => trim($error_message)]);
    }
} else {
        error_log('Método no permitido');
        echo json_encode(['error' => 'Método no permitido']);
}
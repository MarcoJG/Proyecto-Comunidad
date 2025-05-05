<?php 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    session_start();
    require_once '../conexion_BBDD/conexion_db_pm.php';

    function esAdmin() {
        return isset($_SESSION["nombre_rol"]) && $_SESSION["nombre_rol"] === 'Admin';
    }

    if(!esAdmin()) {
        echo json_encode(['error' => 'No tienes permisos para bannear usuarios.']);
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $usuario_a_bannear = $_POST['usuario'] ?? '';

        if (!empty($usuario_a_bannear)) {
            try {
                $stmt = $pdo->prepare("UPDATE usuarios SET baneado = TRUE WHERE usuario = :usuario");
                $stmst->bindParam(':usuario', $usuario);
                if ($stmt->execute()) {
                    echo json_encode(['success' => 'Usuario "' . htmlspecialchars($usuario_a_bannear) . '" ha sido banneado.']);
                } else {
                    echo json_encode(['error' => 'Error al bannear al usuario.']);
                }
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Error en la base de datos al bannear: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'Nombre de usuario a bannear no proporcionado.']);
        }
    } else {
        echo json_encode(['error' => 'Método no permitido']);
    }
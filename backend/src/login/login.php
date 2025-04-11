<?php
session_start();
include '../conexion_BBDD/conexion_db_pm.php'; // Conexión a la BBDD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    iniciarSesion($pdo);
}

function iniciarSesion($pdo) {
    $correo = $_POST["correo"];
    $contrasenya = $_POST["contrasenya"];

    try {
        // Buscar usuario por correo
        $sql = "SELECT u.*, r.nombre AS nombre_rol FROM usuarios u
                INNER JOIN roles r ON u.id_roles = r.id_roles
                WHERE u.correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar contraseña
        if ($usuario && password_verify($contrasenya, $usuario['contrasenya'])) {
            $_SESSION["usuario"] = $usuario["usuario"];
            $_SESSION["nombre_rol"] = $usuario["nombre_rol"];

            if ($_SESSION["nombre_rol"] === "Admin") {
                header("Location: ../../../web/src/admin_panel/index.php");
                exit();
            } else {
                // Redirigir a la página principal de usuarios no administradores
                header("Location: ../../../web/src/home/index.php"); // Ajusta la ruta según tu estructura
                exit();
            }
        } else {
            // Redirigir de vuelta al formulario de login con un mensaje de error
            header("Location: ../../../web/src/login/index.php?error=login_failed");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error en el inicio de sesión: " . $e->getMessage();
    }
}
?>
<?php
session_start();
include 'conexion_db_pm.php'; // Conexión a la BBDD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    iniciarSesion($pdo);
}

function iniciarSesion($pdo) {
    $correo = $_POST["correo"];
    $contrasenya = $_POST["contrasenya"];

    try {
        // Buscar usuario por correo
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar contraseña
        if ($usuario && password_verify($contrasenya, $usuario['contrasenya'])) {
            $_SESSION["usuario"] = $usuario["usuario"];
            echo "Inicio de sesión exitoso. Bienvenido, " . $_SESSION["usuario"];
        } else {
            echo "Error: Correo o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        echo "Error en el inicio de sesión: " . $e->getMessage();
    }
}
?>
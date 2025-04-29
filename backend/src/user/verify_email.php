<?php
include '../conexion_BBDD/conexion_db_pm.php';

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :email AND verification_token = :token 
                               AND email_verificado = FALSE");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $stmt->bindParam(':id', $user['id_usuario']);
            $stmt->execute();
            echo "¡Correo electrónico verificado! Ahora puedes iniciar sesión.";
            header("Location: ../../../web/src/login/index.php");
            exit();
        } else {
            echo "Enlace de verificación inválido o ya ha sido utilizado.";
        }
    }  catch (PDOException $e) {
        echo "Error al verificar el correo electrónico: " . $e->getMessage();
    }
} else {
    echo "Faltan parámetros.";
}

?>
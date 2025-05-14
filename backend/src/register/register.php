<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../lib/phpmailer/PHPMailer.php';
require '../../../lib/phpmailer/SMTP.php';
require '../../../lib/phpmailer/Exception.php';
include '../conexion_BBDD/conexion_db_pm.php';
session_start();

function sendVerificationEmail($correo, $token) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'soporteproyectocomunidad@gmail.com';  // Your Gmail
        $mail->Password = 'rtmt xfha bmmx nnxt';  // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('soporteproyectocomunidad@gmail.com', 'Proyecto Comunidad');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Verifica tu correo electrónico';
        $verificationLink = "http://localhost/Proyecto-Comunidad/backend/src/user/verify_email.php?email=" . urlencode($correo) . "&token=" . urlencode($token);  // Adjust the path as needed
        $mail->Body = "Por favor, haz clic en el siguiente enlace para verificar tu correo electrónico: <a href='" . $verificationLink . "'>" . $verificationLink . "</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar el correo de verificación: {$mail->ErrorInfo}");
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['correo']) || empty($_POST['contrasenya'])
        || empty($_POST['confirm_contrasenya'])) {
        echo "Error: Todos los campos son obligatorios.";
    } elseif ($_POST['contrasenya'] !== $_POST['confirm_contrasenya']) {
        echo "Error: Las contraseñas no coinciden.";
    } elseif (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        echo "Error: El formato del correo electrónico no es válido.";
    } else {
        $nombre = htmlspecialchars($_POST['nombre']);
        $usuario = htmlspecialchars($_POST['usuario']);
        $correo = $_POST['correo'];
        $contrasenya = $_POST['contrasenya'];

        try {
            $stmt_usuario = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
            $stmt_usuario->bindParam(':usuario', $usuario);
            $stmt_usuario->execute();

            $stmt_correo = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = :correo");
            $stmt_correo->bindParam(':correo', $correo);
            $stmt_correo->execute();

            if ($stmt_usuario->fetchColumn() > 0) {
                echo "Error: El nombre de usuario ya está en uso.";
            } elseif ($stmt_correo->fetchColumn() > 0) {
                //echo "Error: El correo ya está registrado.";
            } else {
                $hashedContrasenya = password_hash($contrasenya, PASSWORD_DEFAULT);
                $verification_token = bin2hex(random_bytes(32));  // Generate a unique token

                $stmt_insert = $pdo->prepare("INSERT INTO usuarios (nombre, usuario, contrasenya, correo, id_roles, verification_token)
                                                VALUES(:nombre, :usuario, :contrasenya, :correo, :id_roles, :verification_token)");
                $stmt_insert->execute([
                    'nombre' => $nombre,
                    'usuario' => $usuario,
                    'contrasenya' => $hashedContrasenya,
                    'correo' => $correo,
                    'id_roles' => 3,
                    'verification_token' => $verification_token
                ]);

                if (sendVerificationEmail($correo, $verification_token)) {
                    echo "Registro exitoso. Por favor, verifica tu correo electrónico.";
                } else {
                    echo "Registro exitoso, pero no se pudo enviar el correo de verificación. Por favor, contacta con el soporte.";
                    // Consider logging this error and possibly cleaning up the newly created user
                }

                //  header("Location: ../../../web/src/login/index.php?registro=exitoso");
                //  exit();
            }
        } catch (PDOException $e) {
            echo "Error al registrar usuario: " . $e->getMessage();
        }
    }
}

?>
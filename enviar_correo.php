<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Asegurate de que esta ruta sea correcta respecto a donde están los archivos
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["name"];
    $email = $_POST["email"];
    $mensaje = $_POST["message"];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rag0020@alu.medac.es'; // <-- Tu Gmail
        $mail->Password = '';     // <-- Clave de app de Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('rag0020@alu.medac.es', 'Formulario Web');
        $mail->addAddress('bogahih477@inveitro.com');

        $mail->isHTML(false);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = "Nombre: $nombre\nCorreo: $email\nMensaje:\n$mensaje";

        $mail->send();
        echo 'Mensaje enviado correctamente.';
    } catch (Exception $e) {
        echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
    }
}
?>

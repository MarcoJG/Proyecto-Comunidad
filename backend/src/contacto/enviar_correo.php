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
        $mail->Username = 'soporteproyectocomunidad@gmail.com'; // <-- Tu Gmail
        $mail->Password = 'rtmt xfha bmmx nnxt';     // <-- Clave de app de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;;
        $mail->Port = 587;

        $mail->setFrom('soporteproyectocomunidad@gmail.com', 'Formulario Soporte Proyecto Comunidad');
        $mail->addAddress('soporteproyectocomunidad@gmail.com');

        $mail->isHTML(false);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = "Nombre: $nombre\nCorreo: $email\nMensaje:\n$mensaje";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Mensaje enviado correctamente.']);
    } catch (Exception $e) {
        error_log(json_encode(['success' => false, 'message' => "Error al enviar el mensaje: {$mail->ErrorInfo}"]));
        echo json_encode(['success' => false, 'message' => "Error al enviar el mensaje: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
}
?>

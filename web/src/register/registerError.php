<?php
// Capturamos el mensaje de error desde la URL
$mensaje = $_GET['mensaje'] ?? "Ha ocurrido un error inesperado.";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error de Registro</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; height: 100vh;}
        .mensaje-box { background-color: #243D51; color: white; font-weight: bold; padding: 2rem; border: 1px solid #ccc; border-radius: 10px; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .mensaje-box p { font-size: 18px; margin-bottom: 20px; }
        .mensaje-box a { padding: 10px 20px; background-color: #786247; border-radius: 5px; font-weight: bold; font-size: 1rem; color: white; text-decoration: none; cursor:pointer; border: none; }
        .mensaje-box a:hover { background-color: #786247; }
    </style>
</head>
<body>
    <div class="mensaje-box">
        <p><?php echo htmlspecialchars($mensaje); ?></p>
        <a href="./index.php">Volver al formulario de registro</a>
    </div>
</body>
</html>
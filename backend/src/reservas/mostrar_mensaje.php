<?php
session_start();

if (!isset($_SESSION['mensaje_reserva'])) {
    header("Location: ../../../web/src/reservas/reservas.php");
    exit();
}

$zona = $_SESSION['mensaje_reserva']['zona'];
$fecha = $_SESSION['mensaje_reserva']['fecha'];
$turno = $_SESSION['mensaje_reserva']['turno'];
$error = $_SESSION['mensaje_reserva']['error'] ?? null;

// Formato día/mes/año
$fecha_formateada = date('d/m/Y', strtotime($fecha));

// Limpiar sesión
unset($_SESSION['mensaje_reserva']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva</title>
    <link rel="stylesheet" type="text/css" href="/../Proyecto-Comunidad/web/src/reservas/mostrar_mensaje.css">
    <script>
        window.onload = function() {
            const zona = `<?= addslashes($zona) ?>`;
            const fecha = `<?= addslashes($fecha_formateada) ?>`;
            const turno = `<?= addslashes($turno) ?>`;
            const error = `<?= isset($error) ? addslashes($error) : '' ?>`;

            let mensaje;

            if (error) {
                mensaje = `❌ ${error}<br><br>
                    <button onclick="redirigir()">Aceptar</button>`;
            } else {
                mensaje = `✅ ¡Reserva realizada con éxito!<br><br>
                    <strong>Zona:</strong> ${zona} <br>
                    <strong>Fecha:</strong> ${fecha} <br>
                    <strong>Turno:</strong> ${turno} <br><br>
                    <button onclick="redirigir()">Aceptar</button>`;
            }

            document.getElementById('mensaje').innerHTML = mensaje;
        }

        function redirigir() {
            window.location.href = "../../../web/src/reservas/reservas.php";
        }
    </script>
</head>
<body>
    <main>
        <div class="mensaje-contenedor" id="mensaje">
           
        </div>
    </main>
</body>
</html>

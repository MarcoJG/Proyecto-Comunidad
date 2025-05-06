<?php
session_start();

if (!isset($_SESSION['mensaje_reserva'])) {
    header("Location: ../../../web/src/reservas/reservas.php");
    exit();
}

$zona = $_SESSION['mensaje_reserva']['zona'];
$fecha = $_SESSION['mensaje_reserva']['fecha'];
$turno = $_SESSION['mensaje_reserva']['turno'];

// Convertir la fecha al formato deseado: día/mes/año
$fecha_formateada = date('d/m/Y', strtotime($fecha));

// Eliminar datos para que no reaparezcan
unset($_SESSION['mensaje_reserva']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>
    <link rel="stylesheet" type="text/css" href="/../Proyecto-Comunidad/web/src/reservas/mostrar_mensaje.css">
    <script>
        // Asegúrate de que el código se ejecute cuando el documento esté completamente cargado
        window.onload = function() {
            const zona = `<?= addslashes($zona) ?>`;
            const fecha = `<?= addslashes($fecha_formateada) ?>`;
            const turno = `<?= addslashes($turno) ?>`;

            const mensaje = `
                ✅ ¡Reserva realizada con éxito!<br><br>
                <strong>Zona:</strong> ${zona} <br>
                <strong>Fecha:</strong> ${fecha} <br>
                <strong>Turno:</strong> ${turno} <br><br>
                <button onclick="redirigir()">Aceptar</button>
            `;
            // Inyecta el mensaje y el botón en el div con id="mensaje"
            document.getElementById('mensaje').innerHTML = mensaje;
        }

        // Función para redirigir después de hacer clic en "Aceptar"
        function redirigir() {
            window.location.href = "../../../web/src/reservas/reservas.php";
        }
    </script>
</head>
<body>
    <main>
        <div class="mensaje-contenedor" id="mensaje">
            <!-- El mensaje y el botón se llenarán dinámicamente con JavaScript -->
        </div>
    </main>
</body>
</html>

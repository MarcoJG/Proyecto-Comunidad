<?php
// session_start();
// if (!isset($_SESSION['usuario'])) {
//     header('Location: login.php');
//     exit;
// }

$zona = isset($_GET['zona']) ? htmlspecialchars($_GET['zona']) : 'Zona desconocida';
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar <?php echo $zona; ?></title>
    <link rel="stylesheet" href="reservas.css">
</head>
<body class="fondo-cuerpo">

<header>
    <iframe src="../header/cabecera.html" frameborder="0" width="100%" height="120"></iframe>
</header>

<main class="formulario-reserva">
    <h2>Reservar: <?php echo $zona; ?></h2>

    <form action="../../../backend/src/reservas/procesar_reserva.php" method="POST">
        <input type="hidden" name="zona" value="<?php echo $zona; ?>">
        
        <label for="fecha">Fecha de Reserva:</label>
        <input type="date" name="fecha" id="fecha" required min="<?php echo date('Y-m-d'); ?>">

        <label for="turno">Turno:</label>
        <select name="turno" id="turno" required>
            <option value="">-- Selecciona --</option>
            <option value="mañana">Mañana</option>
            <option value="tarde">Tarde</option>
        </select>

        <button type="submit">Reservar</button>
    </form>
    
</main>

</body>
</html>

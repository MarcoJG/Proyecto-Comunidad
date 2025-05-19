<?php
session_start();
require_once __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: /Proyecto-Comunidad/web/public/login.php"); 
    exit;
}

$usuario = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];  

// Consultar las reservas del usuario
try {
    $stmt = $pdo->prepare("SELECT rz.zona, rz.fecha_reserva, rz.id_reserva
                           FROM reserva_zona_comun rz
                           WHERE rz.id_usuario = ? 
                           ORDER BY rz.fecha_reserva DESC");
    $stmt->execute([$id_usuario]);
    $reservas = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al obtener las reservas: " . $e->getMessage());
}

if (isset($_GET['success']) && $_GET['success'] == 2) {
    echo '<p>Reserva cancelada exitosamente.</p>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="/../Proyecto-Comunidad/web/src/reservas/mis_reservas.css"> 
</head>
<body>

<header>
    <?php
        define('BASE_PATH', '../header/');
        include(BASE_PATH . 'cabecera.php');
    ?>
</header>

<main>
    <div class="contenedor-reservas">
        <h2>Mis Reservas</h2>

        <?php if (empty($reservas)): ?>
            <div class="contenido-centrado mensaje-sin-reservas">
                <svg xmlns="http://www.w3.org/2000/svg" height="48" width="48" fill="#243D51">
                    <path d="M24 4q-4.05 0-7.625 1.55T10.15 10.15Q6.8 13.5 5.15 17.675T3.5 26q0 4.05 1.55 7.625t4.6 6.225q3.35 3.35 7.525 5T24 47.5q4.05 0 7.625-1.55T37.85 39.85q3.35-3.35 5-7.525T44.5 26q0-4.05-1.55-7.625t-4.6-6.225q-3.35-3.35-7.525-5T24 4Zm0 3q7.95 0 13.475 5.525Q43 18.05 43 26q0 7.95-5.525 13.475Q31.95 45 24 45q-7.95 0-13.475-5.525Q5 33.95 5 26q0-7.95 5.525-13.475Q16.05 7 24 7Zm-.5 9v10.25l8.75 5.25.75-1.2-8-4.8V16Z"/>
                </svg>
                <p>No tienes reservas actualmente.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr class="tr-titulo">
                        <th class="tr-zona">Zona</th>
                        <th class="tr-fecha">Fecha de Reserva</th>
                        <th class="tr-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody class ="tbody-reservas">
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reserva['zona']); ?></td>
                            <td class="td-fecha">
                                <?php 
                                $fechaReserva = new DateTime($reserva['fecha_reserva']);
                                echo $fechaReserva->format('d-m-Y H:i');
                                ?>
                            </td>
                            <td class="td-acciones">
                                <a href="/Proyecto-Comunidad/web/src/reservas/cancelar_reserva.php?id=<?php echo $reserva['id_reserva']; ?>" class="cancelar-reserva">Cancelar reserva</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="volver-centro">
            <a href="/Proyecto-Comunidad/web/src/reservas/reservas.php">
                <button class="btn-volver">Volver a Reservas</button>
            </a>
        </div>
    </div>
</main>

</body>
</html>

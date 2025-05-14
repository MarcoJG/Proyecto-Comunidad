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
    <link rel="stylesheet" href="mis_reservas.css"> 
</head>
<body>

<header>
    <?php
        define('BASE_PATH', '../header/');
        include(BASE_PATH . 'cabecera.php');
    ?>
</header>

<main>
    <h2>Mis Reservas</h2>

    <?php if (empty($reservas)): ?>
        <p>No tienes reservas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Zona</th>
                    <th>Fecha de Reserva</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['zona']); ?></td>
                        <td>
                            <?php 
                            // Fecha como día, mes y año
                            $fechaReserva = new DateTime($reserva['fecha_reserva']);
                            echo $fechaReserva->format('d-m-Y H:i');
                            ?>
                        </td>
                        <td>
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
</main>

</body>
</html>
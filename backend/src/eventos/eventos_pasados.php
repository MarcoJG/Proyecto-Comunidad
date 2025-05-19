<?php
include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

// Obtener la fecha actual y consultar eventos pasados
$hoy = date('Y-m-d');
$sql = "SELECT id_evento, titulo, descripcion, fecha, es_destacada, imagen FROM eventos WHERE DATE(fecha) < :hoy ORDER BY fecha ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':hoy' => $hoy]);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fecha_formateada = date('d/m/Y', strtotime($row['fecha']));
        // Lógica para asignar clase para la estrella
        $estrella_class = ($row['es_destacada'] == 1) ? 'estrella seleccionada' : 'estrella';

        $imagen = !empty($row['imagen']) ? htmlspecialchars($row['imagen'], ENT_QUOTES, 'UTF-8') : '../../../web/etc/assets/img/bloque.jpg';

        echo "<article class='evento'>";
        echo "<div class='noticia-imagen'><img src='" . htmlspecialchars($row['imagen']) . "' alt='Imagen del evento'></div>";
        echo "<div class='evento-texto'>";
        echo "<h2 class='titulo-evento'>" . htmlspecialchars($row['titulo']) . " <span class='$estrella_class'>&#9733;</span></h2>";
        echo "<p class='detalle-evento'>" . htmlspecialchars($row['descripcion']) . "</p>";
        echo "<p class='fecha-evento'>" . $fecha_formateada . "</p>";
        echo "<a href='detalle.php?id=" . $row['id_evento'] . "' class='boton-evento'>Accede</a>";
        echo "</div>";
        echo "</article>";
    }
} else {
    echo "<p>No hay eventos pasados.</p>";
}
?>

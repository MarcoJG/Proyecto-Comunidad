<?php
include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

// Obtener los eventos futuros
$sql_futuros = "SELECT id_evento, titulo, descripcion, fecha, es_destacada, imagen FROM eventos WHERE fecha > CURDATE() ORDER BY fecha ASC";
$result_futuros = $pdo->query($sql_futuros);

if ($result_futuros->rowCount() > 0) {
    while ($row = $result_futuros->fetch(PDO::FETCH_ASSOC)) {
        $fecha_formateada = date("d/m/Y", strtotime($row['fecha']));
        // Lógica para asignar clase para la estrella
        $estrella_class = ($row['es_destacada'] == 1) ? 'estrella seleccionada' : 'estrella';

        $imagen = $row['imagen'] === 'etc/assets/img/bloque.jpg' ? 'etc/assets/img/bloque.jpg' : $row['imagen'];
        
        echo "<article class='evento'>";
        echo "<div class='noticia-imagen'><img src='" . htmlspecialchars($row['imagen']) . "' alt='Imagen del evento'></div>";
        echo "<div class='evento-texto'>";
        echo "<h2 class='titulo-evento'>" . $row['titulo'] . " <span class='$estrella_class'>&#9733;</span></h2>";
        echo "<p class='detalle-evento'>" . $row['descripcion'] . "</p>";
        echo "<p class='fecha-evento'>" . $fecha_formateada . "</p>";
        echo "<a href='detalle.php?id=" . $row['id_evento'] . "' class='boton-evento'>Accede</a>";
        echo "</div>";
        echo "</article>";
    }
} else {
    echo "<p>No hay eventos futuros registrados.</p>";
}
?>

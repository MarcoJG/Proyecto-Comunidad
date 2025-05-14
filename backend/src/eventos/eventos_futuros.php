<?php
include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

// Fecha actual y consulta SQL eventos futuros
$hoy = date('Y-m-d');
$sql = "SELECT id_evento, titulo, descripcion, fecha, es_destacada FROM eventos WHERE fecha >= '$hoy' ORDER BY fecha ASC";

// Ejecutar la consulta y verificar si hay resultados
$result = $pdo->query($sql);

if ($result->rowCount() > 0) {
    while ($row = $result->fetch()) {
        $fecha_formateada = date('d/m/Y', strtotime($row['fecha']));

        echo "<article class='evento'>";
        echo "<div class='evento-imagen'><img src='../../etc/assets/img/bloque.jpg' alt='ImagenEvento'></div>";
        echo "<div class='evento-texto'>";

        // Evento  destacado, la estrella se ilumina
        $estrella_class = ($row['es_destacada'] == 1) ? 'estrella seleccionada' : 'estrella';

        // Estrella al lado del título
        echo "<h2 class='titulo-evento'>
        " . $row['titulo'] . " " . $fecha_formateada . "
        <span class='$estrella_class'>&#9733;</span>
      </h2>";

        echo "<p class='detalle-evento'>" . $row['descripcion'] . "</p>";
        echo "<a href='detalle.php?id=" . $row['id_evento'] . "' class='boton-evento'>Accede</a>";
        echo "</div>";
        echo "</article>";
    }
} else {
    echo "<p>No hay eventos futuros.</p>";
}
?>

<script>
    function mostrarIdEvento(idEvento) {
        alert("El ID del evento es: " + idEvento);
    }
</script>
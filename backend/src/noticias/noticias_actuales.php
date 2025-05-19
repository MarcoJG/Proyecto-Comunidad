<?php


include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

// Obtener la fecha actual y consulta SQL noticias actuales
$hoy = date('Y-m-d');
$sql = "SELECT id_noticias, titulo, contenido, fecha, es_destacada, imagen FROM noticias WHERE fecha >= '$hoy' ORDER BY fecha ASC";

// Ejecutar la consulta y verificar si hay resultados
$result = $pdo->query($sql);

if ($result->rowCount() > 0) {
    while ($row = $result->fetch()) {
        $fecha_formateada = date('d/m/Y', strtotime($row['fecha']));
         // Lógica para asignar clase para la estrella
        $estrella_class = ($row['es_destacada'] == 1) ? 'estrella seleccionada' : 'estrella';

        $imagen = $row['imagen'] === 'etc/assets/img/bloque.jpg' ? 'etc/assets/img/bloque.jpg' : $row['imagen'];

        echo "<article class='noticia'>";
        echo "<div class='noticia-imagen'><img src='" . htmlspecialchars($row['imagen']) . "' alt='Imagen de la noticia'></div>";
        echo "<div class='noticia-texto'>";
        echo "<h2 class='titulo-noticia'>" . $row['titulo'] . " <span class='$estrella_class'>&#9733;</span></h2>";
        echo "<p class='detalle-noticia'>" . $row['contenido'] . "</p>";
        echo "<p class='fecha-noticia'>" . $fecha_formateada . "</p>";
        echo "<a href='detalle.php?id=" . $row['id_noticias'] . "' class='boton-noticia'>Accede</a>";
        echo "</div>";
        echo "</article>";
    }
} else {
    echo "<p>No hay noticias actuales.</p>";
}
?>

<script>
    // Función ID del evento en un alert
    function mostrarIdEvento(idEvento) {
        alert("El ID del evento es: " + idEvento);
    }
</script>
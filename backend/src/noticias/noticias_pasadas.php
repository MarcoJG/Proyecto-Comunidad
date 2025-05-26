<?php

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

// Obtener la fecha actual
$hoy = date('Y-m-d');

// Consulta segura con prepared statement
$sql = "SELECT id_noticias, titulo, contenido, fecha, es_destacada, imagen FROM noticias WHERE DATE(fecha) < :hoy ORDER BY fecha ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['hoy' => $hoy]);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch()) {
        $fecha_formateada = date('d/m/Y', strtotime($row['fecha']));
        $id = (int)$row['id_noticias'];
        $titulo = htmlspecialchars($row['titulo'], ENT_QUOTES, 'UTF-8');
        $contenido = htmlspecialchars($row['contenido'], ENT_QUOTES, 'UTF-8');
         // Lógica para asignar clase para la estrella
        $estrella_class = ($row['es_destacada'] == 1) ? 'estrella seleccionada' : 'estrella';

        $imagen = !empty($row['imagen']) ? htmlspecialchars($row['imagen'], ENT_QUOTES, 'UTF-8') : '../../../web/etc/assets/img/bloque.jpg';


        echo "<article class='noticia'>";
        echo "<div class='noticia-imagen'><img src='" . htmlspecialchars($row['imagen']) . "' alt='Imagen de la noticia'></div>";
        echo "<div class='noticia-texto'>";
        echo "<h2 class='titulo-noticia'>" . htmlspecialchars($row['titulo']) . " <span class='$estrella_class'>&#9733;</span></h2>";
        echo "<p class='detalle-noticia'>" . htmlspecialchars($row['contenido']) . "</p>";
        echo "<p class='fecha-noticia'>" . $fecha_formateada . "</p>";
        echo "<a href='detalle.php?id=" . $row['id_noticias'] . "' class='boton-noticia'>Accede</a>";
        echo "</div>";
        echo "</article>";
    }
} else {
    echo "<p>No hay noticias pasadas.</p>";
}
?>

<script>
    function mostrarIdEvento(idEvento) {
        alert("El ID del evento es: " + idEvento);
    }
</script>

<?php

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

// Obtener la fecha actual
$hoy = date('Y-m-d');

// Consulta segura con prepared statement
$sql = "SELECT id_noticias, titulo, contenido, fecha FROM noticias WHERE DATE(fecha) < :hoy ORDER BY fecha ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['hoy' => $hoy]);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch()) {
        $fecha_formateada = date('d/m/Y', strtotime($row['fecha']));
        $id = (int)$row['id_noticias'];
        $titulo = htmlspecialchars($row['titulo'], ENT_QUOTES, 'UTF-8');
        $contenido = htmlspecialchars($row['contenido'], ENT_QUOTES, 'UTF-8');

        echo "<article class='noticia'>";
        echo "<div class='noticia-imagen'><img src='../../etc/assets/img/bloque.jpg' alt='ImagenNoticia'></div>";
        echo "<div class='noticia-texto'>";
        echo "<h2 class='titulo-noticia'>{$titulo} - {$fecha_formateada}</h2>";
        echo "<p class='detalle-noticia'>{$contenido}</p>";
        echo "<a href='detalle.php?id={$id}' class='boton-noticia'>Accede</a>";
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

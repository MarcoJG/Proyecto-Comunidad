<?php

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id_noticias = (int) $_GET['id']; // Validación estricta

    // Consulta segura con prepared statement
    $sql = "SELECT * FROM noticias WHERE id_noticias = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id_noticias]);

    if ($stmt->rowCount() > 0) {
        $noticia = $stmt->fetch();

        // Escapar contenido para prevenir XSS
        $titulo = htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8');
        $fecha = date('d/m/Y', strtotime($noticia['fecha']));
        $contenido = htmlspecialchars($noticia['contenido'], ENT_QUOTES, 'UTF-8');

        echo 
            "<div class='noticia-header'>
                <div class='noticia-imagen'>
                    <img src='../../etc/assets/img/bloque.jpg' alt='Imagen de la noticia'>
                </div>
                <div class='noticia-info'>
                    <h2 class='titulo-noticia'>{$titulo}</h2>
                    <p class='detalle-noticia'>{$fecha}</p>
                </div>
            </div>
            <div class='descripcion-noticia'>
                <p>{$contenido}</p>
            </div>";
    } else {
        echo "<p>Noticia no encontrada.</p>";
    }
} else {
    echo "<p>ID de la noticia no proporcionado o inválido.</p>";
}
?>

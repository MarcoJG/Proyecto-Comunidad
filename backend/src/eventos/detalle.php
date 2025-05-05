<?php

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if (isset($_GET['id'])) {
    $id_evento = intval($_GET['id']); // Evitar inyecciones

    $sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
    $resultado = $pdo->query($sql);

    if ($resultado->rowCount() > 0) {
        $evento = $resultado->fetch();
        echo 
            "<div class='evento-header'>
                <div class='evento-imagen'>
                    <img src='../../etc/assets/img/bloque.jpg' alt='Imagen del evento'>
                </div>
                <div class='evento-info'>
                    <h2 class='titulo-evento'>" . $evento ['titulo'] . " </h2>
                    <p class='detalle-evento'>" . date('d/m/Y', strtotime($evento['fecha'])) . " </p>
                </div>
            </div>
            <div class='descripcion-evento'>
                <p> ". $evento ['descripcion'] . " </p>
            </div>";
    } else {
        echo "<p>Evento no encontrado.</p>";
    }
} else {
    echo "<p>ID del evento no proporcionado.</p>";
}
?>
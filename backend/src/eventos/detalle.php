<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

// Verificar permisos para editar/borrar (Admin o Presidente)
$usuarioPuedeEditar = isset($_SESSION['id_usuario']) && isset($_SESSION["nombre_rol"]) && in_array($_SESSION["nombre_rol"], ["Admin", "Presidente"]);

if (isset($_GET['id'])) {
    $id_evento = intval($_GET['id']); // Evitar inyecciones

    $sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
    $resultado = $pdo->query($sql);

    if ($resultado->rowCount() > 0) {
        $evento = $resultado->fetch();
        // Verificar si la imagen está vacía y asignar la ruta por defecto si es necesario
        $imagen = !empty($evento['imagen']) ? $evento['imagen'] : '/Proyecto-Comunidad/web/etc/assets/img/bloque.jpg';

        // Escapar la ruta de la imagen
        $imagen = htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8');


        echo "
            
         
            <div class='evento-header'>
                <div class='evento-imagen'>
                    <img src='" . $imagen . "' alt='Imagen del evento'>
                </div>
                <div class='evento-info'>
                    <h2 class='titulo-evento'>" . htmlspecialchars($evento['titulo']) . "</h2>
                    <p class='detalle-evento'>" . date('d/m/Y', strtotime($evento['fecha'])) . "</p>
                </div>
            </div>
            <div class='descripcion-evento'>
                <p>" . nl2br(htmlspecialchars($evento['descripcion'])) . "</p>
            </div>
        ";

        // Mostrar botones si es admin o presidente
        if ($usuarioPuedeEditar) {
            echo "
                <div class='botones-admin'>
                    <form method='POST' action='../../../backend/src/eventos/eliminar_evento.php' onsubmit='return confirmarBorrado(event)'>
                        <input type='hidden' name='id_evento' value='$id_evento'>
                        <button type='submit' class='boton-evento'>Borrar evento</button>
                    </form>
                    <form method='GET' action='../../../web/src/eventos/editar_evento.php'>
                        <input type='hidden' name='id' value='$id_evento'>
                        <button type='submit' class='boton-evento'>Editar evento</button>
                    </form>
                </div>
            ";
        }
    } else {
        echo "<p>Evento no encontrado.</p>";
    }
} else {
    echo "<p>ID del evento no proporcionado.</p>";
}

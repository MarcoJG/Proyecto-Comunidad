<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php'; 

if (!isset($_SESSION["nombre_rol"]) || !in_array($_SESSION["nombre_rol"], ["Admin", "Presidente"])) {
    echo "<p>No tienes permiso para realizar esta acción.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_evento = intval($_POST["id_evento"]);
    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    $fecha = $_POST["fecha"];
    $es_destacada = isset($_POST["es_destacada"]) ? intval($_POST["es_destacada"]) : 0;

    if ($es_destacada === 1) {
        // Verificar si existe otro evento destacado 
        $sql_check = "SELECT id_evento FROM eventos WHERE es_destacada = 1 AND id_evento != :id_evento LIMIT 1";
        $stmt = $pdo->prepare($sql_check);
        $stmt->execute([':id_evento' => $id_evento]);

        if ($stmt->rowCount() > 0) {
            // Guardar datos en sesión y redirigir a confirmación
            $_SESSION['evento_editar_destacado_data'] = [
                'id_evento' => $id_evento,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'fecha' => $fecha,
                'es_destacada' => $es_destacada
            ];
            header("Location: /Proyecto-Comunidad/web/src/eventos/confirmar_reemplazo_edicion.php");
            exit;
        }
    }

    // Si no hay conflicto, actualizar directamente
    $sql = "UPDATE eventos 
            SET titulo = :titulo, descripcion = :descripcion, fecha = :fecha, es_destacada = :es_destacada 
            WHERE id_evento = :id_evento";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":titulo" => $titulo,
        ":descripcion" => $descripcion,
        ":fecha" => $fecha,
        ":es_destacada" => $es_destacada,
        ":id_evento" => $id_evento
    ]);

    header("Location: /Proyecto-Comunidad/web/src/eventos/detalle.php?id=$id_evento");
    exit;
} else {
    echo "<p>Método no permitido.</p>";
}

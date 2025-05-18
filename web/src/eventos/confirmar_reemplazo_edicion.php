<?php
session_start();
include __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["confirmar"] === "si" && isset($_SESSION["evento_editar_destacado_data"])) {
        $data = $_SESSION["evento_editar_destacado_data"];

        try {
            // Desmarcar cualquier otro evento destacado excepto este
            $stmt_unset = $pdo->prepare("UPDATE eventos SET es_destacada = 0 WHERE es_destacada = 1 AND id_evento != :id_evento");
            $stmt_unset->execute([':id_evento' => $data['id_evento']]);

            // Actualizar este evento como destacado y con nuevos datos
            $stmt = $pdo->prepare("UPDATE eventos 
                                   SET titulo = :titulo, descripcion = :descripcion, fecha = :fecha, es_destacada = 1 
                                   WHERE id_evento = :id_evento");
            $stmt->execute([
                ':titulo' => $data['titulo'],
                ':descripcion' => $data['descripcion'],
                ':fecha' => $data['fecha'],
                ':id_evento' => $data['id_evento']
            ]);

            unset($_SESSION["evento_editar_destacado_data"]);
            header("Location: /Proyecto-Comunidad/web/src/eventos/detalle.php?id={$data['id_evento']}");
            exit;
        } catch (PDOException $e) {
            echo "Error al actualizar evento: " . $e->getMessage();
        }

    } else {
        // Cancelado
        $id_evento = $_SESSION["evento_editar_destacado_data"]["id_evento"] ?? 0;
        unset($_SESSION["evento_editar_destacado_data"]);
        header("Location: /Proyecto-Comunidad/web/src/eventos/editar_evento.php?id=$id_evento");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar reemplazo</title>
    <link rel="stylesheet" href="./confirmar_reemplazo.css">
</head>
<body>
<main>
    <div class="confirm-box">
        <h2>¿Reemplazar evento destacado existente?</h2>
        <p>Ya hay otro evento marcado como destacado. Si confirmas, se reemplazará con este evento que estás editando.</p>
        <form method="POST">
            <div class="confirm-buttons">
                <button type="submit" name="confirmar" value="si" class="boton-evento">Confirmar cambio</button>
                <button type="submit" name="confirmar" value="no" class="boton-evento boton-cancelar">Cancelar</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>

<?php
session_start();
include __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["confirmar"] === "si" && isset($_SESSION["noticia_editar_destacado_data"])) {
        $data = $_SESSION["noticia_editar_destacado_data"];

        try {
            // Desmarcar cualquier otro noticia destacado excepto este
            $stmt_unset = $pdo->prepare("UPDATE noticias SET es_destacada = 0 WHERE es_destacada = 1 AND id_noticias != :id_noticias");
            $stmt_unset->execute([':id_noticias' => $data['id_noticias']]);

            // Actualizar este noticia como destacado y con nuevos datos
            $stmt = $pdo->prepare("UPDATE noticias 
                                   SET titulo = :titulo, contenido = :contenido, fecha = :fecha, es_destacada = 1 
                                   WHERE id_noticias = :id_noticias");
            $stmt->execute([
                ':titulo' => $data['titulo'],
                ':contenido' => $data['contenido'],
                ':fecha' => $data['fecha'],
                ':id_noticias' => $data['id_noticias']
            ]);

            unset($_SESSION["noticia_editar_destacado_data"]);
            header("Location: /Proyecto-Comunidad/web/src/noticias/detalle.php?id={$data['id_noticias']}");
            exit;
        } catch (PDOException $e) {
            echo "Error al actualizar noticia: " . $e->getMessage();
        }

    } else {
        // Cancelado
        $id_noticias = $_SESSION["noticia_editar_destacado_data"]["id_noticias"] ?? 0;
        unset($_SESSION["noticia_editar_destacado_data"]);
        header("Location: /Proyecto-Comunidad/web/src/noticias/editar_noticia.php?id=$id_noticias");
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
        <h2>¿Reemplazar noticia destacado existente?</h2>
        <p>Ya hay otro noticia marcado como destacado. Si confirmas, se reemplazará con este noticia que estás editando.</p>
        <form method="POST">
            <div class="confirm-buttons">
                <button type="submit" name="confirmar" value="si" class="boton-noticia">Confirmar cambio</button>
                <button type="submit" name="confirmar" value="no" class="boton-noticia boton-cancelar">Cancelar</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>

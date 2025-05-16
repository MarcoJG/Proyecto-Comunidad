<?php
session_start();
include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php'; 

if (!isset($_SESSION["nombre_rol"]) || !in_array($_SESSION["nombre_rol"], ["Admin", "Presidente"])) {
    echo "<p>No tienes permiso para realizar esta acción.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_noticia = intval($_POST["id_noticias"]);
    $titulo = trim($_POST["titulo"]);
    $contenido = trim($_POST["contenido"]);
    $fecha = $_POST["fecha"];
    $es_destacada = isset($_POST["es_destacada"]) ? intval($_POST["es_destacada"]) : 0;

    $sql = "UPDATE noticias 
            SET titulo = :titulo, contenido = :contenido, fecha = :fecha, es_destacada = :es_destacada 
            WHERE id_noticias = :id_noticias";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":titulo", $titulo);
    $stmt->bindParam(":contenido", $contenido);
    $stmt->bindParam(":fecha", $fecha);
    $stmt->bindParam(":es_destacada", $es_destacada);
    $stmt->bindParam(":id_noticias", $id_noticia);

    if ($stmt->execute()) {
        // ✅ Redirección correcta con base URL
        $host = $_SERVER['HTTP_HOST'];
        $uri = "/Proyecto-Comunidad/web/src/noticias/detalle.php?id=$id_noticia";
        header("Location: http://$host$uri");
        exit;
    } else {
        echo "<p>Error al actualizar el noticia.</p>";
    }
} else {
    echo "<p>Método no permitido.</p>";
}
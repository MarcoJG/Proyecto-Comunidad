<?php
session_start();
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

    $sql = "UPDATE eventos 
            SET titulo = :titulo, descripcion = :descripcion, fecha = :fecha, es_destacada = :es_destacada 
            WHERE id_evento = :id_evento";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":titulo", $titulo);
    $stmt->bindParam(":descripcion", $descripcion);
    $stmt->bindParam(":fecha", $fecha);
    $stmt->bindParam(":es_destacada", $es_destacada);
    $stmt->bindParam(":id_evento", $id_evento);

    if ($stmt->execute()) {
        // ✅ Redirección correcta con base URL
        $host = $_SERVER['HTTP_HOST'];
        $uri = "/Proyecto-Comunidad/web/src/eventos/detalle.php?id=$id_evento";
        header("Location: http://$host$uri");
        exit;
    } else {
        echo "<p>Error al actualizar el evento.</p>";
    }
} else {
    echo "<p>Método no permitido.</p>";
}
<?php
require_once '../../database/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = $_POST['fecha'];

    // Validación básica
    if (empty($titulo) || empty($descripcion) || empty($fecha)) {
        die("Faltan datos requeridos.");
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO eventos (titulo, descripcion, fecha) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $titulo, $descripcion, $fecha);

    if ($stmt->execute()) {
        header("Location: ../../../web/eventos.php?mensaje=Evento+creado+correctamente");
        exit();
    } else {
        echo "Error al crear el evento: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

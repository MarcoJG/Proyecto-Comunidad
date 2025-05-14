<?php
session_start();

include __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';


if (isset($_SESSION['evento_destacado_existente']) && $_SESSION['evento_destacado_existente']) {
    try {
        // Eliminar el evento anterior destacado
        $pdo->query("UPDATE eventos SET es_destacada = 0 WHERE es_destacada = 1");

        // Insertar el nuevo evento usando los datos de sesión
        if (isset($_SESSION['evento_destacado_data'])) {
            $data = $_SESSION['evento_destacado_data'];

            $sql = "INSERT INTO eventos (titulo, descripcion, fecha, id_usuario, es_destacada)
                    VALUES (:titulo, :descripcion, :fecha, :id_usuario, :es_destacada)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo' => $data['titulo'],
                ':descripcion' => $data['descripcion'],
                ':fecha' => $data['fecha'],
                ':id_usuario' => $data['id_usuario'],
                ':es_destacada' => $data['destacado']
            ]);
        }

        // Limpiar las variables de sesión
        unset($_SESSION['evento_destacado_existente']);
        unset($_SESSION['evento_destacado_data']);

        // Redirigir al listado de eventos
        header("Location: /Proyecto-Comunidad/web/src/eventos/index.php");
        exit();

    } catch (PDOException $e) {
        echo "Error al reemplazar el evento destacado: " . $e->getMessage();
    }
} else {
    echo "No hay evento destacado que reemplazar.";
}
?>

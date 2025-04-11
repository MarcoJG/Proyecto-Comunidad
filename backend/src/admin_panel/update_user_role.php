<?php
session_start();
include '../conexion_BBDD/conexion_db_pm.php';

//Verificar si es admin
if (!isset($_SESSION["nombre_rol"]) || $_SESSION["nombre_rol"] !== "Admin") {
    echo "Acceso denegado.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];
    $nuevo_rol_id = $_POST["nuevo_rol"];

    try {
        $sql = "UPDATE usuarios SET id_roles = :nuevo_rol_id WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nuevo_rol_id', $nuevo_rol_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: admin_panel.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar el rol: " . $e->getMessage();
    }
} else {
    echo "Petición inválida.";
}
?>
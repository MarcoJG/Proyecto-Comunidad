<?php
session_start();

include 'conexion_db_pm.php';

if (!isset($_SESSION["nombre_rol"]) || $_SESSION["nombre_rol"] !== "Admin") {
    header("Location: login.html");
    exit();
}

try {
    $sql = "SELECT u.id_usuario, u.usuario, r.nombre AS rol_nombre FROM usuarios u
            INNER JOIN roles r ON u.id_roles = r.id_roles";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Obtener lista de roles para el formulario desplegable
    $sql_roles = "SELECT id_roles, nombre FROM roles";
    $stmt_roles = $pdo->prepare($sql_roles);
    $stmt_roles->execute();
    $roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error al obtener datos: " . $e->getMessage();
}

//Incluyendo html
include 'admin_panel.template.php';
?>
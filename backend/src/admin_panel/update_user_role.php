<?php
session_start();
include '../conexion_BBDD/conexion_db_pm.php';

if (!isset($_SESSION["nombre_rol"]) || $_SESSION["nombre_rol"] !== "Admin") {
    echo "Acceso denegado.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];
    $nuevo_rol_id = $_POST["nuevo_rol"];

    try {
        // Obtener nombre del usuario y del nuevo rol (opcional, para el popup)
        $stmt = $pdo->prepare("SELECT usuario FROM usuarios WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $usuario = $stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT nombre FROM roles WHERE id_roles = :id_roles");
        $stmt->bindParam(':id_roles', $nuevo_rol_id);
        $stmt->execute();
        $rol = $stmt->fetchColumn();

        // Actualizar el rol
        $sql = "UPDATE usuarios SET id_roles = :nuevo_rol_id WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nuevo_rol_id', $nuevo_rol_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        // Guardar info del popup en sesión temporal
        $_SESSION['flash_success'] = [
            'usuario' => $usuario,
            'rol' => $rol
        ];

        header("Location: ../../../web/src/admin_panel/index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar el rol: " . $e->getMessage();
    }
} else {
    echo "Petición inválida.";
}
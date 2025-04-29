<?php
include '../conexion_BBDD/conexion_db_pm.php';

//Datos de la cuenta del admin
$nombre_admin = 'marco';
$correo_admin = 'mjg0016@alu.medac.es';
$usuario_admin = 'marco';
$contrasenya_plana_admin = 'beograd011';

try {
    $contrasenya_hasheada_admin = password_hash($contrasenya_plana_admin, PASSWORD_DEFAULT);

    $sql_rol = "SELECT id_roles FROM roles WHERE nombre = 'Admin'";
    $stmt_rol = $pdo->prepare($sql_rol);
    $stmt_rol->execute();
    $rol_admin = $stmt_rol->fetch(PDO::FETCH_ASSOC);

    if($rol_admin){
        $id_rol_admin = $rol_admin['id_roles'];

        $sql_insert = "INSERT INTO usuarios (nombre, correo, usuario, contrasenya, id_roles)
                       VALUES (:nombre, :correo, :usuario, :contrasenya, :id_roles)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':nombre', $nombre_admin);
        $stmt_insert->bindParam(':correo', $correo_admin);
        $stmt_insert->bindParam(':usuario', $usuario_admin);
        $stmt_insert->bindParam(':contrasenya', $contrasenya_hasheada_admin);
        $stmt_insert->bindParam(':id_roles', $id_rol_admin, PDO::PARAM_INT);
        $stmt_insert->execute();

        echo "¡Cuenta de administrador creada exitosamente!";
    } else {
        echo "Error: No se encontró el rol 'Admin' en la BBDD. Asegúrate de haber poblado la tabla 'roles'.";
    } 
} catch (PDOException $e) {
    echo "Error al crear la cuenta de administrador: " . $e->getMessage();
}
?>
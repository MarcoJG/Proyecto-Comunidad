<?php
    require_once __DIR__ . '/../../../config.php';
    session_start();
    require_once '../../../backend/src/admin_panel/admin_panel.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel de administrador para la comunidad de vecinos.">

    <meta name="keywords" content="comunidad de vecinos, panel, administrador, admin">
    <meta name="author" content="Comunidad de vecinos">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title>Panel de administrador</title>
    <link rel="stylesheet" href="admin_panel.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<header>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . $basePath . 'web/src/header/cabecera.php';
    ?>
</header>
<body>
    <h1>Panel de Administración</h1>
    <p>Bienvenido, <?php echo $_SESSION["usuario"]; ?> (<?php echo $_SESSION["nombre_rol"]; ?>)</p>

    <h2>Gestionar Roles de Usuario</h2>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Usuario</th>
                <th>Rol Actual</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($usuarios)) : ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id_usuario']; ?></td>
                        <td><?php echo $usuario['usuario']; ?></td>
                        <td><?php echo $usuario['rol_nombre']; ?></td>
                        <td>
                            <form action="../../../backend/src/admin_panel/update_user_role.php" method="POST">
                                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                                <label for="nuevo_rol_<?php echo $usuario['id_usuario']; ?>">Nuevo rol:</label>
                                <select name="nuevo_rol" id="nuevo_rol_<?php echo $usuario['id_usuario']; ?>">
                                    <?php if (isset($roles)): ?>
                                        <?php foreach($roles as $rol): ?>
                                            <option value="<?php echo $rol['id_roles']; ?>"
                                                <?php if ($rol['nombre'] === $usuario['rol_nombre']) echo 'selected'; ?>>
                                                <?php echo $rol['nombre']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <button type="submit">Actualizar rol</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="../../../backend/src/admin_panel/logout.php">Cerrar sesión</a></p>
    <?php
    if (isset($_SESSION['flash_success'])) {
        $usuario = htmlspecialchars($_SESSION['flash_success']['usuario']);
        $rol = htmlspecialchars($_SESSION['flash_success']['rol']);
        // Eliminar después de usarlo
        unset($_SESSION['flash_success']);
    ?>
    <script>
        Swal.fire({
            title: 'Rol actualizado',
            text: "Se ha actualizado el rol de '<?php echo $usuario; ?>' a '<?php echo $rol; ?>'",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php } ?>
</body>
</html>
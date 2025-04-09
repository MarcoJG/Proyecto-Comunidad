<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
</head>
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
                            <form action="update_user_role.php" method="POST">
                                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                                <label for="nuevo_rol_<?php echo $usuario['id_usuario']; ?>">Nuevo rol:</label>
                                <select name="nuevo_rol" id="nuevo_rol_<?php echo $usuario['id_usuario']; ?>"></select>
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

    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
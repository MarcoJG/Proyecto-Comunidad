<?php

include 'conexion_db_pm.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // 1. Validar el formato del correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Error: El formato del correo electrónico no es válido.";
            exit();
        }

        // 2. Verificar si el usuario o el correo ya existen
        $stmt_check = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE usuario = :usuario OR correo = :correo");
        $stmt_check->execute([':usuario' => $username, ':correo' => $email]);
        if ($stmt_check->fetch()) {
            echo "Error: El nombre de usuario o la dirección de correo electrónico ya están registrados.";
            exit();
        }

        try {
            // 3. Hashear la contraseña de forma segura
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // 4. Obtener el id_roles para 'Usuario'
            $stmt_rol = $pdo->prepare("SELECT id_roles FROM roles WHERE nombre = 'Usuario'");
            $stmt_rol->execute();
            $rol_usuario = $stmt_rol->fetch(PDO::FETCH_ASSOC);

            if ($rol_usuario) {
                $id_rol_usuario = $rol_usuario['id_roles'];

                // 5. Insertar el nuevo usuario en la tabla 'usuarios'
                $stmt_insert = $pdo->prepare("INSERT INTO usuarios (nombre, correo, usuario, contrasenya, id_roles)
                                               VALUES (:nombre, :correo, :usuario, :contrasenya, :id_roles)");
                $stmt_insert->execute([
                    'nombre' => htmlspecialchars($username),
                    'correo' => $email,
                    'usuario' => htmlspecialchars($username),
                    'contrasenya' => $password_hash,
                    'id_roles' => $id_rol_usuario
                ]);

                echo "Usuario registrado exitosamente.";
                // Opcional: Redirigir al usuario a la página de inicio de sesión
                // header("Location: login.html");
                // exit();

            } else {
                echo "Error: No se encontró el rol 'Usuario' en la base de datos.";
            }

        } catch (PDOException $e) {
            echo "Error al registrar usuario: " . $e->getMessage();
        }
    } else {
        echo "Error: Por favor, completa todos los campos del formulario.";
    }
}

?>
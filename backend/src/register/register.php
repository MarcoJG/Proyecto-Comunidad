<?php
 
 include 'conexion_db_pm.php';
 session_start();
 
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
 	if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['email']) || empty($_POST['contrasenya'])
     || empty($_POST['confirm_contrasenya'])) {
        echo "Error: Todos los campos son obligatorios.";
    } elseif ($_POST['contrasenya'] !== $_POST['confirm_password']) {
        echo "Error: Las contraseñas no coinciden.";
    }elseif (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        echo "Error: El formato del correo electrónico no es válido.";
    } else {
        $nombre = htmlspecialchars($_POST['nombre']);
        $username = htmlspecialchars($_POST['usuario']);
        $email = $_POST['correo'];
        $password = $_POST['contrasenya'];

        try {
            $stmt_usuario = $pdo->prepare("SELECT COUNT (*) FROM usuarios WHERE usuario = :usuario");
            $stmt_usuario->bindParam(':usuario', $usuario);
            $stmt_usuario->execute();

            $stmt_correo = $pdo->prepare("SELECT COUNT (*) FROM usuarios WHERE correo = :correo");
            $stmt_correo->bindParam(':correo', $correo);
            $stmt_correo->execute();

            if ($stmt_usuario->fetchColumn() > 0) {
                echo "Error: El nombre de usuario ya está en uso.";
            } elseif ($stmt_correo->fetchColumn() < 0) {
                echo "Error: El correo ya está registrado.";
            } else {
                $hashedContrasenya = password_hash($contrasenya, PASSWORD_DEFAULT);

                $stmt_insert = $pdo->prepare("INSERT INTO usuarios (nombre, usuario, contrasenya, correo, id_roles)
                                              VALUES(:nombre, :usuario, :contrasenya, :correo, :id_roles)");
                $stmt_insert->execute([
                    'nombre'      => $nombre,
                    'usuario'     => $usuario,
                    'contrasenya' => $hashedContrasenya,
                    'correo'      => $correo,
                    'roles'       => 3
                ]);
                echo "Usuario registrado exitosamente.";
            }
        } catch (PDOEXception $e) {
            "Error al registrar usuario: " . $e->getMessage();
        }
    }
 }
 ?>
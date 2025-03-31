<?php

$host = 'localhost';
$db   = 'comunidad_db';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if ((!empty($_POST['username'])) && (!empty($_POST['email'])) && (!empty($_POST['password']))) {
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$email = $_POST['email'];
		try {
            // Preparar la consulta SQL
            $stmt = $pdo->prepare("INSERT INTO usuario (nombre_completo, email, contrasena, id_roles) 
                                   VALUES (:nombre_completo, :email, :contrasena, :id_roles)");
            
            // Ejecutar la consulta con valores seguros
            $stmt->execute([
                'nombre_completo' => $username,
                'email' => $email,
                'contrasena' => $password,
                'id_roles' => 1
            ]);

            echo "Usuario registrado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al registrar usuario: " . $e->getMessage();
        }
	}
}



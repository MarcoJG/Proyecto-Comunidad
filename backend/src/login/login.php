<?php
/*TODO: 
- migrar datos a archivo de configuración
- indicar credenciale scorrectas de la BBDD
*/
$host = 'localhost';
$db   = 'login_db';
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
	if ((!empty($_POST['username'])) && (!empty($_POST['password']))) {
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);

		$stmt = $pdo->prepare("SELECT username FROM usuario WHERE username = :username and password = SHA2(:password, 256)");
		$stmt->execute(['username' => $username, 'password' => $password,]);
		$user = $stmt->fetch();

		if ($user) {
			echo "Bienvenido, " . htmlspecialchars($user['username']);
		} else {
			echo "Usuario o contraseña incorrectos.";
		}
	}
}


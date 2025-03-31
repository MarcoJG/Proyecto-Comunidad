<?php
session_start();
include 'conexion_db_pm.php'; //Conexión a la BBDD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    if ($action == "register") {
        registrarUsuario($pdo);
    } elseif ($action == "login") {
        iniciarSesion($pdo);
    }
}

//Funcion para registrar usuario
function registrarUsuario($pdo){
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $usuario = $_POST["usuario"];
    $contrasenya = password_hash($_POST["contrasenya"], PASSWORD_BCRYPT);

    try {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['correo' => $correo]);

        if($stmt->rowCount() > 0){
            echo "Error: El correo ya está registrado";
        } else {
            $sql = "INSERT INTO usuarios (nombre, correo, usuario, contrasenya
            VALUES (:nombre, :correo, :usuario, :contrasenya)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nombre' => $nombre,
                'correo' => $correo,
                'usuario' => $usuario,
                'contrasenya' => $contrasenya
            ]);
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
        }
    } catch (PDOException $e) {
        echo "Error en el registro: " . $e->getMessage();
    }
}

function iniciarSesion($pdo){
    $correo = $_POST["correo"];
    $contrasenya = $_POST["contrasenya"];

    try{
        //Buscar usuario por correo
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //Verificar contrasenya
        if($usuario && password_verify($contrasenya, $usuario['contrasenya'])) {
            $_SESSION["usuario"] = $usuario["usuario"];
            echo "Inicio de sesión exitoso. Bienvenido, " . $_SESSION["usuario"];
        } else {
            echo "Error: Correcto o contrasenya incorrectos.";
        }
    } catch (PDOException $e){
        echo "Error en el inicio de sesión: " . $e->getMessage();
    }
}
?>
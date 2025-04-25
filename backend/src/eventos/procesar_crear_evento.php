<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto_comunidad";


$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificar usuario Admin
    // if (!isset($_SESSION['id_usuario']) || !isset($_SESSION["nombre_rol"]) || $_SESSION["nombre_rol"] !== "Admin") {
    //     die("No autorizado.");
    // }

    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    // $id_usuario = $_SESSION['id_usuario'];
    $id_usuario = 1;

    // Validaciones
    if (empty($titulo) || empty($descripcion) || empty($fecha)) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_evento.php?error=faltan_datos");
        exit();
    }

    if (strlen($titulo) > 100 || strlen($descripcion) > 255) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_evento.php?error=longitud_invalida");
        exit();
    }

    if (strtotime($fecha) <= strtotime('today')) {
        $_SESSION['form_data'] = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha
        ];
        header("Location: ../../../web/crear_evento.php?error=fecha_invalida");
        exit();
    }

    // Insertar en la BBDD
    $sql = "INSERT INTO eventos (titulo, descripcion, fecha, id_usuario) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $titulo, $descripcion, $fecha, $id_usuario);

    if ($stmt->execute()) {
        // header("Location: ../../../web/eventos.php?mensaje=Evento+creado+correctamente");
        header("Location: ../../../web/src/eventos/eventos.php");
        exit();
    } else {
        echo "Error al crear el evento: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

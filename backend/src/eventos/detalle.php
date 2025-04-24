<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto_comunidad";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id_evento = intval($_GET['id']); // Evitar inyecciones

    $sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $evento = $resultado->fetch_assoc();
        echo 
            "<div class='evento-header'>
                <div class='evento-imagen'>
                    <img src='../../etc/assets/img/bloque.jpg' alt='Imagen del evento'>
                </div>
                <div class='evento-info'>
                    <h2 class='titulo-evento'>" . $evento ['titulo'] . " </h2>
                    <p class='detalle-evento'>" . date('d/m/Y', strtotime($evento['fecha'])) . " </p>
                </div>
            </div>
            <div class='descripcion-evento'>
                <p> ". $evento ['descripcion'] . " </p>
            </div>";
    } else {
        echo "<p>Evento no encontrado.</p>";
    }
} else {
    echo "<p>ID del evento no proporcionado.</p>";
}

$conn->close();
?>
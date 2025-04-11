<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto_comunidad";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la fecha actual y consulta SQL eventos futuros
$hoy = date('Y-m-d');
$sql = "SELECT id_evento, titulo, descripcion, fecha FROM eventos WHERE fecha >= '$hoy' ORDER BY fecha ASC";

// Ejecutar la consulta y verificar si hay resultados
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fecha_formateada = date('d/m/Y', strtotime($row['fecha']));


        echo "<article class='evento'>";
        echo "<div class='evento-imagen'><img src='../../etc/assets/img/bloque.jpg' alt='ImagenEvento'></div>";
        echo "<div class='evento-texto'>";
        echo "<h2 class='titulo-evento'>" . $row['titulo'] . " " . $fecha_formateada . "</h2>";  // Mostrar título y fecha
        echo "<p class='detalle-evento'>" . $row['descripcion'] . "</p>";

        // Onclick para mostrar la alerta con el ID del evento
        echo "<button type='button' class='boton-evento' onclick='mostrarIdEvento(" . $row['id_evento'] . ")'>Accede</button>";

        echo "</div>";
        echo "</article>";
    }
} else {
    echo "<p>No hay eventos futuros.</p>";
}

$conn->close();
?>

<script>
    // Función ID del evento en un alert
    function mostrarIdEvento(idEvento) {
        alert("El ID del evento es: " + idEvento);
    }
</script>
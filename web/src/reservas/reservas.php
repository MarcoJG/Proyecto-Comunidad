<?php
session_start();
$usuarioEsAdmin = isset($_SESSION["nombre_rol"]) && $_SESSION["nombre_rol"] === "Admin";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas de Zonas Comunes</title>
    <link rel="stylesheet" href="reservas.css">
</head>
<body class="fondo-cuerpo">

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 15px; margin: 20px auto; border: 1px solid #c3e6cb; border-radius: 5px; width: 80%; text-align: center;">
        ✅ ¡Reserva realizada con éxito!
    </div>
<?php endif; ?>

<main>
    <header>
        <iframe src="../header/cabecera.html" frameborder="0" width="100%" height="100%"></iframe>
    </header>

    <section class="contenedor-principal">
        <h2 class="titulo-eventos">Reserva de Zonas Comunes</h2><br>
        <p class="subtitulo">Consulta las zonas disponibles para reservar</p>

        <div class="contenedor-eventos">
            <?php
            $zonas = [
                ['nombre' => 'Piscina', 'imagen' => '../../etc/assets/img/piscina.jpg'],
                ['nombre' => 'Pista de Tenis', 'imagen' => '../../etc/assets/img/tenis.jpg'],
                ['nombre' => 'Gimnasio', 'imagen' => '../../etc/assets/img/gimnasio.jpg'],
                ['nombre' => 'Sala de Reuniones', 'imagen' => '../../etc/assets/img/sala_reuniones.jpg'],
                ['nombre' => 'Barbacoa', 'imagen' => '../../etc/assets/img/barbacoa.jpg'],
            ];

            // Mensajes por zona
            $mensajes = [
                'Piscina' => 'Reserva tu turno en nuestra piscina y date un chapuzón refrescante.',
                'Pista de Tenis' => 'Disfruta de un partido en la pista de tenis, reserva ya tu turno.',
                'Gimnasio' => 'Mantente en forma reservando tu sesión en el gimnasio.',
                'Sala de Reuniones' => 'Planifica tu próxima reunión con comodidad y privacidad.',
                'Barbacoa' => 'Comparte una comida al aire libre reservando la zona de barbacoa.',
            ];

            foreach ($zonas as $zona) {
                echo '<div class="evento">';
                echo '<div class="evento-imagen"><img src="'.$zona['imagen'].'" alt="'.$zona['nombre'].'"></div>';
                echo '<div class="evento-texto">';
                echo '<h3 class="titulo-evento">'.$zona['nombre'].'</h3>';
                echo '<p class="detalle-evento">'.$mensajes[$zona['nombre']].'</p>';
                echo '<a href="reserva_formulario.php?zona='.urlencode($zona['nombre']).'" class="boton-evento">Reservar</a>';
                echo '</div></div>';
            }
            ?>
        </div>
    </section>
</main>

<footer>
    <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="100%"></iframe>
</footer>
</body>
</html>

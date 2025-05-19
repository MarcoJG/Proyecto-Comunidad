<?php
session_start();

// Redirigir si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <script src="../../../backend/src/home/calendar.js"></script>
    <meta name="description" content="Página principal de la comunidad de vecinos. Información sobre noticias, eventos y más.">
    <meta name="keywords" content="comunidad de vecinos, noticias, eventos, foro, reservas">
    <meta name="author" content="Equipo Proyecto Comunidad">
    <link rel="icon" type="" href="">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <meta property="og:title" content="Comunidad de vecinos - Inicio">
    <meta property="og:description" content="Noticias y eventos de tu comunidad de vecinos.">
    <meta name="twitter:card" content="summary_large_image">
</head>

<body>
    <?php
        define('BASE_PATH', '../header/');
        include(BASE_PATH . 'cabecera.php');
    ?>

    <main>
        <!-- BLOQUE DE NOTICIAS (estático, no tocado) -->
        <div>
            <h2>Bloque de noticias</h2>
            <p>Las noticias más próximas sobre nuestra comunidad</p>
            <div class="noticias-container">
                <div class="noticia">
                    <a href=""><img src="" alt="Imagen de una puerta de garaje rota"></a>
                    <a href=""><h3>Puerta del garaje rota</h3></a>
                    <p>Lorem ipsum dolor...</p>
                    <a href=""><button>Button</button></a>
                </div>
                <div class="noticia">
                    <a href=""><img src="" alt="Imagen de un ascensor en el bloque 3 averiado"></a>
                    <a href=""><h3>Ascensor Bloque 3 averiado</h3></a>
                    <p>Lorem ipsum dolor...</p>
                    <a href=""><button>Button</button></a>
                </div>
            </div>
        </div>

        <!-- BLOQUE DESTACADO (dinámico) -->
        <?php
        include __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';

        $sql_destacado = "SELECT id_evento, titulo, descripcion, fecha FROM eventos WHERE es_destacada = 1 LIMIT 1";
        $stmt_destacado = $pdo->query($sql_destacado);

        if ($stmt_destacado->rowCount() > 0) {
            $evento_destacado = $stmt_destacado->fetch(PDO::FETCH_ASSOC);
            $fecha_formateada = date("d/m/Y", strtotime($evento_destacado['fecha']));
        ?>
            <section id="bloqueDestacado">
                <h2>Evento Destacado</h2>
                <div>
                    <img src="../../etc/assets/img/bloque.jpg" alt="Imagen destacada del evento">
                    <h3><?php echo htmlspecialchars($evento_destacado['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($evento_destacado['descripcion']); ?></p>
                    <p><strong>Fecha:</strong> <?php echo $fecha_formateada; ?></p>
                    <a href="../eventos/detalle.php?id=<?php echo $evento_destacado['id_evento']; ?>">
                        <button>Ver Detalles</button>
                    </a>
                </div>
            </section>
        <?php
        }
        ?>

        <!-- BLOQUE DE EVENTOS MÁS RECIENTES (dinámico) -->
        <?php
        $sql_recientes = "
            SELECT id_evento, titulo, descripcion, fecha 
            FROM eventos 
            WHERE fecha >= CURDATE()
            ORDER BY fecha ASC 
            LIMIT 2
        ";
        $stmt_recientes = $pdo->query($sql_recientes);

        if ($stmt_recientes->rowCount() > 0) {
        ?>
            <section id="bloque-eventos">
                <h2>Eventos Más Recientes</h2>
                <p>Los eventos más próximos sobre nuestra comunidad</p>
                <div class="eventos-container">
                    <?php
                    while ($evento = $stmt_recientes->fetch(PDO::FETCH_ASSOC)) {
                        $fecha_formateada = date("d/m/Y", strtotime($evento['fecha']));
                    ?>
                        <div class="evento">
                            <img src="../../etc/assets/img/bloque.jpg" alt="Imagen del evento">
                            <h3><?php echo htmlspecialchars($evento['titulo']); ?></h3>
                            <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                            <p><strong>Fecha:</strong> <?php echo $fecha_formateada; ?></p>
                            <a href="../eventos/detalle.php?id=<?php echo $evento['id_evento']; ?>">
                                <button>Ver Detalles</button>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </section>
        <?php
        }
        ?>

        <!-- CALENDARIO (no tocado) -->
        <section id="calendario">
            <div class="calendar-header">
                <span>Select date</span>
                <div class="selected-date-container">
                    <span id="selectedDate">Mon, Aug 17</span>
                    <i class="fas fa-pencil-alt edit-icon"></i>
                </div>
                <div class="month-selector">
                    <div class="month-year-container">
                        <span id="monthYear">August 2025</span>
                        <i class="fas fa-chevron-down month-dropdown"></i>
                    </div>
                    <div>
                        <button id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                        <button id="nextMonth"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="calendar-grid" id="calendarGrid"></div>
            </div>
        </section>

    </main>

    <footer>
        <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="300px"></iframe>
    </footer>
</body>

</html>
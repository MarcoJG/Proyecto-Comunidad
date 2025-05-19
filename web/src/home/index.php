<?php
session_start();

// Redirigir si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login/login.php");
    exit();
}

// Incluir la conexión a la base de datos AL PRINCIPIO
include __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';
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
        <?php
        $sql_noticias = "
            SELECT id_noticias, titulo, contenido, fecha, imagen
            FROM noticias
            WHERE fecha >= CURDATE()
            ORDER BY fecha ASC
            LIMIT 2
        ";
        $stmt_noticias = $pdo->query($sql_noticias);

        if ($stmt_noticias->rowCount() > 0) {
        ?>
            <div>
                <h2>Noticias más cercanas</h2>
                <p>Las noticias más próximas sobre nuestra comunidad</p>
                <div class="noticias-container">
                    <?php
                    while ($noticia = $stmt_noticias->fetch(PDO::FETCH_ASSOC)) {
                        $fecha_formateada = date("d/m/Y", strtotime($noticia['fecha']));
                        $imagen = !empty($noticia['imagen']) ? $noticia['imagen'] : '../../etc/assets/img/bloque.jpg';
                    ?>
                        <div class="noticia">
                            <a href="../noticias/detalle.php?id=<?php echo $noticia['id_noticias']; ?>">
                                <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de la noticia">
                            </a>
                            <a href="../noticias/detalle.php?id=<?php echo $noticia['id_noticias']; ?>">
                                <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                            </a>
                            <p><?php echo htmlspecialchars(mb_strimwidth($noticia['contenido'], 0, 100, "...")); ?></p>
                            <a href="../noticias/detalle.php?id=<?php echo $noticia['id_noticias']; ?>">
                                <button>Ver más</button>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>

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
                <h2>Eventos más cercanos</h2>
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
    </main>

    <aside class="sidebar-right">
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

        <?php
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
        <?php
    $sql_noticia_destacada = "
        SELECT id_noticias, titulo, contenido, fecha, imagen
        FROM noticias
        WHERE es_destacada = 1
        ORDER BY fecha DESC
        LIMIT 1
    ";
    $stmt_noticia_destacada = $pdo->query($sql_noticia_destacada);

    if ($stmt_noticia_destacada->rowCount() > 0) {
        $noticia_destacada = $stmt_noticia_destacada->fetch(PDO::FETCH_ASSOC);
        $fecha_formateada = date("d/m/Y", strtotime($noticia_destacada['fecha']));
        $imagen = !empty($noticia_destacada['imagen']) ? $noticia_destacada['imagen'] : '../../etc/assets/img/bloque.jpg';
    ?>
        <section id="bloqueNoticiaDestacada">
            <h2>Noticia Destacada</h2>
            <div>
                <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen destacada de la noticia">
                <h3><?php echo htmlspecialchars($noticia_destacada['titulo']); ?></h3>
                <p><?php echo htmlspecialchars(mb_strimwidth($noticia_destacada['contenido'], 0, 100, "...")); ?></p>
                <p><strong>Fecha:</strong> <?php echo $fecha_formateada; ?></p>
                <a href="../noticias/detalle.php?id=<?php echo $noticia_destacada['id_noticias']; ?>">
                    <button>Ver Detalles</button>
                </a>
            </div>
        </section>
    <?php
    }
    ?>
    </aside>

    <footer>
        <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="300px"></iframe>
    </footer>
</body>

</html>
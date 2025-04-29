<?php
session_start();
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
    <header>
    <?php
        define('BASE_PATH', '../header/'); // Relativa desde index.php hacia cabecera.php
        include(BASE_PATH . 'cabecera.php');
    ?>
    </header>
    <main>
        <section id="bloque-noticias">
            <div>
                <h2>Bloque de noticias</h2>
                <p>Todas las noticias relevantes sobre nuestra comunidad</p>
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
        </section>
        <section id="bloque-eventos">
            <div>
                <h2>Bloque de eventos</h2>
                <p>Todos los eventos relevantes sobre nuestra comunidad</p>
                <div class="eventos-container">
                    <div class="evento">
                        <a href=""><img src="" alt="Imagen de la reunion de la Comunidad"></a>
                        <a href=""><h3>Reunion Comunidad 18/10/2025</h3></a>
                        <p>Lorem ipsum dolor...</p>
                        <a href=""><button>Button</button></a>
                    </div>
                    <div class="evento">
                        <a href=""><img src="" alt="Imagen de Lorem Ipsum dolor"></a>
                        <a href=""><h3>Reunion Comunidad 18/10/2025</h3></a>
                        <p>Lorem ipsum dolor...</p>
                        <a href=""><button>Button</button></a>
                    </div>
                </div>
            </div>
        </section>
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
            </section>
            <section id="bloqueDestacado">
                <h2>Bloque destacado</h2>
                <div>
                    <img src="" alt="Imagen destacada del evento">
                    <h2>Reunion Comunidad 18/10/2025</h2>
                    <p>Lorem ipsum dolor...</p>
                    <button>Button</button>
                </div>
            </section>
        </main>
        <footer> 
            <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="300px"></iframe> 
        </footer>
    </body>
    </html>
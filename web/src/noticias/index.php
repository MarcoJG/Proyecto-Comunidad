<?php
    require_once __DIR__ . '/../../../config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>noticias</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="fondo-cuerpo">

    <header>
        <?php include('../header/cabecera.php'); ?>
    </header>

    <div class="contenedor-principal">

        <!-- Próximas Noticias -->
        <div class="contenedor proximas-noticias">
            <h2 class="titulo-noticias">Noticias actuales</h2>
            <p class="subtitulo">Consulta todas las noticias de nuestra comunidad aquí</p>

            <!--Noticia 1 -->
            <div class="noticia">

                <div class="noticia-imagen">
                    <img src="../../etc/assets/img/central electrica.jpg" alt="ImagenNoticia">
                </div>

                <!-- Texto y botón -->
                <div class="noticia-texto">
                    <h2 class="titulo-noticia">Apagón General</h2>
                    <p class="detalle-noticia">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam
                        consequuntur ipsa aspernatur fugit suscipit aliquam beatae, voluptatum praesentium maxime
                        doloremque! Sint quia dolores soluta molestias sunt. Quos iste quia quo!.</p>
                    <button class="boton-noticia">Accede</button>
                </div>
            </div>

            <!--Noticia 2 -->
            <div class="noticia">

                <div class="noticia-imagen">
                    <img src="../../etc/assets/img/piscina.jpg" alt="ImagenNoticia">
                </div>

                <!-- Texto y botón -->
                <div class="noticia-texto">
                    <h2 class="titulo-noticia">Piscina cerrada por rotura</h2>
                    <p class="detalle-noticia">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod,
                        exercitationem vel! Perferendis minus aliquam rerum dolore quam sequi necessitatibus explicabo.
                    </p>
                    <button class="boton-noticia">Accede</button>
                </div>
            </div>
        </div>
    </div>


    <div class="contenedor-principal">

        <!--  Noticias pasadas -->
        <div class="contenedor proximas-noticias">
            <h2 class="titulo-noticias">Noticias pasadas</h2>

            <!-- Noticia 1 -->
            <div class="noticia">
                <div class="noticia-imagen">
                    <img src="../../etc/assets/img/ascensor.jpg" alt="ImagenNoticia">
                </div>

                <!-- Texto y botón -->
                <div class="noticia-texto">
                    <h2 class="titulo-noticia">Ascensor Bloque 2-A Averiado</h2>
                    <p class="detalle-noticia">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam
                        consequuntur ipsa aspernatur fugit suscipit aliquam beatae, voluptatum praesentium maxime
                        doloremque! Sint quia dolores soluta molestias sunt. Quos iste quia quo!.</p>
                    <button class="boton-noticia">Accede</button>
                </div>
            </div>

            <!-- Noticia 2  -->
            <div class="noticia">
                <div class="noticia-imagen">
                    <img src="../../etc/assets/img/ayuda.jpg" alt="ImagenNoticia">
                </div>

                <!-- Texto y botón -->
                <div class="noticia-texto">
                    <h2 class="titulo-noticia">La Comunidad con los afectados por la DANA</h2>
                    <p class="detalle-noticia">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod,
                        exercitationem vel! Perferendis minus aliquam rerum dolore quam sequi necessitatibus explicabo.
                    </p>
                    <button class="boton-noticia">Accede</button>
                </div>
            </div>
        </div>
    </div>

    <footer> 
        <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="300px"></iframe> 
    </footer>
     
</body>

</html>
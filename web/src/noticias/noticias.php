<!-- lógica para rol admin -->
<?php
require_once __DIR__ . '/../../../config.php';
// Comprobamos si el usuario tiene el rol de Admin
if (!isset($_SESSION["nombre_rol"]) || $_SESSION["nombre_rol"] !== "Admin") {
    // Si no es Admin, redirigimos o mostramos un mensaje
    $usuarioEsAdmin = false;
} else {
    // Si es Admin, mostramos el botón
    $usuarioEsAdmin = true;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="fondo-cuerpo">
    <main>
        
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . $basePath . 'web/src/header/cabecera.php'; ?>
    </header>
     <!-- Condicional comentado para que siempre se vea el botón hasta que funcione con el admin -->

    <?php if ($usuarioEsAdmin): ?>  
        <div style="text-align: right; margin: 20px;">
            <a href="crear_noticia.php" class="boton-noticia" style="background-color: #243D51; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Crear noticia
            </a>
        </div>
        <?php endif;?>
        <section class="contenedor-principal">

            <!-- Noticias Actuales -->
            <section class="contenedor proximos-noticia">
                <h2 class="titulo-noticia">
                    Noticias Actuales
                </h2>
                <p class="subtitulo">Consulta todos las noticias de nuestra comunidad aquí</p>

                <?php
                /* Incluimos la lógica específica para noticias actuales desde un archivo concreto (noticias_actuales.php)
                 Esto responde al principio de responsabilidad única (SRP) del modelo SOLID,
                 manteniendo separada la lógica de noticias actuales y pasados para facilitar el mantenimiento,
                 pruebas unitarias e independencia de cambios. Lo mismo hacemos para noticias_pasadas.php */
                include '../../../backend/src/noticias/noticias_actuales.php';
                ?>
            </section>
        </section>

        <section class="contenedor-principal">
            <!--  Noticias Pasadas -->
            <section class="contenedor proximos-noticia">
                <h2 class="titulo-noticia">Noticias Pasadas</h2>

                <?php

                include '../../../backend/src/noticias/noticias_pasadas.php';
                ?>
            </section>
        </section>

    </main>
    <!-- Aquí irá el footer -->

</body>

</html>
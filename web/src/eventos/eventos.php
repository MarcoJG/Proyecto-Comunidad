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

        <!-- Aquí irá la cabecera -->
         
        <section class="contenedor-principal">

            <!-- Próximos Eventos -->
            <section class="contenedor proximos-eventos">
                <h2 class="titulo-eventos">
                    Próximos eventos
                </h2>
                <p class="subtitulo">Consulta todos los eventos de nuestra comunidad aquí</p>

                <?php
                /* Incluimos la lógica específica para eventos futuros desde un archivo concreto (eventos_futuros.php)
                 Esto responde al principio de responsabilidad única (SRP) del modelo SOLID,
                 manteniendo separada la lógica de eventos futuros y pasados para facilitar el mantenimiento,
                 pruebas unitarias e independencia de cambios. Lo mismo hacemos para eventos_pasados.php */
                include '../../../backend/src/eventos/eventos_futuros.php';
                ?>
            </section>
        </section>

        <section class="contenedor-principal">
            <!--  Eventos pasados -->
            <section class="contenedor proximos-eventos">
                <h2 class="titulo-eventos">Eventos pasados</h2>

                <?php

                include '../../../backend/src/eventos/eventos_pasados.php';
                ?>
            </section>
        </section>

    </main>
    <!-- Aquí irá el footer -->

</body>

</html>
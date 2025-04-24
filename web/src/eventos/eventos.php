<!-- lógica para rol admin -->
<?php
session_start();

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

        <!-- Aquí irá la cabecera -->
         
         <!-- Condicional comentado para que siempre se vea el botón hasta que funcione con el admin -->
<?php /* if ($usuarioEsAdmin): */?>  
    <div style="text-align: right; margin: 20px;">
        <a href="crear_evento.php" class="boton-evento" style="background-color: #243D51; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Crear evento
        </a>
    </div>
<?php /* endif; */?>


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
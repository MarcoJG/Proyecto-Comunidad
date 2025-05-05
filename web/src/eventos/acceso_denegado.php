<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Denegado</title>
    <link rel="stylesheet" href="../style.css"> <!-- Ajusta si es necesario -->
    <style>
        .centrado-acceso-denegado {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }

        .centrado-acceso-denegado .titulo-principal {
            margin-bottom: 10px;
        }

        .centrado-acceso-denegado .detalle-evento {
            max-width: 600px;
        }
    </style>
</head>
<body class="fondo-cuerpo">
    <div class="centrado-acceso-denegado">
        <h1 class="titulo-principal">🚫 Acceso Denegado</h1>
        <p class="detalle-evento">
            Lo sentimos, no tienes permisos para acceder a esta sección.<br>
            
        </p>
        <a href="eventos.php"
           class="boton-evento"
           style="background-color: #243D51; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;">
           Volver a Eventos
        </a>
    </div>
</body>
</html>

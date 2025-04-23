<!--lógica acceso formulario usuario autorizado-->
<?php
session_start();

// Verificamos si el usuario tiene el rol de Admin
if (!isset($_SESSION["nombre_rol"]) || $_SESSION["nombre_rol"] !== "Admin") {
    // Si no es Admin, redirigimos a una página de acceso denegado
    header("Location: acceso_denegado.php");
    exit();
}

?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Evento</title>
    <!-- Enlazamos el archivo CSS específico para crear evento -->
    <link rel="stylesheet" href="/../Proyecto-Comunidad/web/src/eventos/crear_evento.css"> 
</head>
<body class="fondo-cuerpo">

<main class="contenedor-principal">
    <h2 class="titulo-eventos">Crear nuevo evento</h2>
    
    <form action="../../backend/src/eventos/procesar_crear_evento.php" method="POST" class="formulario-evento">
        
        <label for="titulo">Título del evento:</label>
        <input type="text" id="titulo" name="titulo" maxlength="100" required>

        <label for="fecha">Fecha del evento:</label>
        <input type="date" id="fecha" name="fecha" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" maxlength="255" required></textarea>

        <button type="submit" class="boton-evento">Crear evento</button>
    </form>
</main>

</body>
</html>

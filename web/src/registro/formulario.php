<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Registro de Usuario</title>
    <link rel="stylesheet" href="registro.css">
</head>

<body>
   
    <div class="registro-container">
        <h2>Regístrate</h2>
        <form action="registro.php" method="POST">
            <label>Nombre de Usuario:</label><br>
            <input type="text" name="username" placeholder="Ejemplo: Pepito" required><br><br>
            <label>Correo electrónico:</label><br>
            <input type="email" name="email" placeholder="Ejemplo: pepito@gmail.com" required><br><br>
            <label>Contraseña:</label><br>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="Confirmar">
        </form>
</body>

</html>
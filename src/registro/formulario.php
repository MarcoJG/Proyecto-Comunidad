<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro de Usuario</title>
</head>
<body>
    <h2>Regístrate</h2>
    <form action="registro.php" method="POST">
        <label>Nombre de Usuario:</label><br>
        <input type="text" name="username" placeholder="Pepito..." required><br>
        <label>Correo electrónico:</label><br>
        <input type="email" name="email" required><br>
        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Confirmar">
    </form>
</body>
</html>

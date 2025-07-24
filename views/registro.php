<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
<div class="container">
    <h2>Registro de Usuario</h2>
    <form action="index.php?action=registrar" method="POST">
        <input type="text" name="nombres" placeholder="Nombres" required><br>
        <input type="text" name="apellidos" placeholder="Apellidos" required><br>
        <input type="text" name="cedula" placeholder="Cedula" required><br>
        <input type="email" name="correo" placeholder="Correo" required><br>
        <input type="text" name="telefono" placeholder="Teléfono"><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="index.php?action=login">Inicia sesión aquí</a></p>
    </div>
</body>
</html>

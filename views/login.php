<?php
require_once RUTA_BASE .'/models/configuracion.php';
$config = new Configuracion();
$fondo = $config->obtenerFondo('login');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="public/css/login.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #e8f5e9 0%, #b7e4c7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Quicksand', 'Segoe UI', Arial, sans-serif;
        }
        .container {
            background: rgba(255,255,245,0.97); /* Beige claro */
            padding: 2.5rem 2rem;
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(56,142,60,0.13); /* Verde sombra */
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        .container h2 {
            margin-bottom: 1.5rem;
            color: #388e3c; /* Verde intenso */
            font-weight: 700;
        }
        .container input[type="email"],
        .container input[type="password"] {
            width: 90%;
            padding: 0.8rem;
            margin: 0.7rem 0;
            border: 1.5px solid #b7e4c7; /* Verde claro */
            border-radius: 8px;
            outline: none;
            font-size: 1rem;
            background: #f4fce3;
            transition: border 0.2s;
        }
        .container input:focus {
            border: 2px solid #388e3c;
        }
        .container button {
            width: 95%;
            padding: 0.9rem;
            margin-top: 1rem;
            background: linear-gradient(90deg, #388e3c 0%, #43a047 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(56, 142, 60, 0.08);
        }
        .container button:hover {
            background: linear-gradient(90deg, #43a047 0%, #388e3c 100%);
        }
        .container p {
            margin-top: 1.5rem;
            color: #2e4637;
        }
        .container a {
            color: #388e3c;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .container a:hover {
            text-decoration: underline;
            color: #2e4637;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Iniciar Sesión</h2>
    <form action="index.php?action=login" method="POST">
        <input type="email" name="correo" placeholder="Correo electrónico" required><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br>
        <button type="submit">Iniciar sesión</button>
    </form>
    <p>¿No tienes cuenta? <a href="index.php?action=registrar">Regístrate aquí</a></p>
    <p>
        <a href="index.php?action=recuperar">¿Olvidaste tu contraseña?</a>
    </p>
</div>
</body>
</html>
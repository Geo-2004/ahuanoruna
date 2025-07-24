
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <style>
        .recuperrar_contrasena {
            background: #f4fce3;
            border-radius: 18px;
            box-shadow: 0 6px 16px rgba(56,142,60,0.13);
            padding: 36px 32px;
            max-width: 400px;
            margin: 60px auto;
            border: 1.5px solid #b7e4c7;
            text-align: center;
        }
        .recuperrar_contrasena h2 {
            color: #388e3c;
            margin-bottom: 28px;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .recuperrar_contrasena form {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-bottom: 18px;
        }
        .recuperrar_contrasena input[type="email"] {
            padding: 0.7rem;
            border: 1.5px solid #b7e4c7;
            border-radius: 8px;
            background: #e8f5e9;
            font-size: 1rem;
            transition: border 0.2s;
        }
        .recuperrar_contrasena input[type="email"]:focus {
            border: 2px solid #388e3c;
            outline: none;
        }
        .recuperrar_contrasena button[type="submit"] {
            background: linear-gradient(90deg, #388e3c 0%, #4caf50 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.9rem 1.7rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(56, 142, 60, 0.08);
            transition: background 0.2s;
        }
        .recuperrar_contrasena button[type="submit"]:hover {
            background: linear-gradient(90deg, #4caf50 0%, #388e3c 100%);
        }
        .recuperrar_contrasena a {
            color: #388e3c;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .recuperrar_contrasena a:hover {
            text-decoration: underline;
            color: #2e4637;
        }
    </style>
</head>
<body>
    <div class="recuperrar_contrasena">
        <h2>Recuperar Contraseña</h2>
        <form action="index.php?action=recuperar_enviar" method="POST">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <button type="submit">Enviar instrucciones</button>
        </form>
        <p>
            <a href="index.php?action=login">Volver al login</a>
        </p>
    </div>
</body>
</html>

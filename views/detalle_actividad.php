<?php
require_once RUTA_BASE .'/models/actividad.php';
require_once RUTA_BASE .'/models/configuracion.php';

$config = new Configuracion();
$fondo = $config->obtenerFondo('detalle_actividad');

$actividadModel = new Actividad();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Actividad no especificada";
    exit();
}

$id = $_GET['id'];
$actividad = $actividadModel->obtenerPorId($id);

if (!$actividad) {
    echo "Actividad no encontrada";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $actividad['nombre'] ?> - Detalle</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('<?= $fondo ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #333;
        }

        .detalle-actividad {
            max-width: 1000px;
            margin: 40px auto;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            padding: 30px;
        }

        h1 {
            font-size: 32px;
            text-align: center;
            color: #0a4d3c;
            margin-bottom: 20px;
        }

        .imagen img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 25px;
        }

        .contenido {
            font-size: 16px;
            line-height: 1.6;
        }

        .descripcion {
            font-size: 18px;
            color: #444;
            margin-bottom: 20px;
        }

        .detalles li {
            margin-bottom: 8px;
            list-style: none;
            padding-left: 20px;
            position: relative;
        }

        .detalles li::before {
            content: '✔️';
            position: absolute;
            left: 0;
        }

        .descripcion-larga {
            margin: 15px 0;
            background-color: #f0f8f7;
            padding: 15px;
            border-left: 5px solid #2a8b71;
            border-radius: 6px;
        }

        .incluye {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            padding-left: 0;
            margin-top: 15px;
        }

        .incluye li {
            background-color: #e6f2ef;
            padding: 10px 15px;
            border-radius: 8px;
            list-style: none;
            border-left: 5px solid #2a8b71;
        }

        .acciones {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .boton {
            text-decoration: none;
            background-color: #2a8b71;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .boton:hover {
            background-color: #1c5f4d;
        }

        .boton.secundario {
            background-color: #ccc;
            color: #333;
        }

        .boton.secundario:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <div class="detalle-actividad">
        <h1><?= $actividad['nombre'] ?></h1>

        <div class="imagen">
            <img src="<?= $actividad['imagen'] ?>" alt="<?= $actividad['nombre'] ?>">
        </div>

        <div class="contenido">
            <p class="descripcion"><?= $actividad['descripcion'] ?></p>

            <ul class="detalles">
                <li><strong>💲 Precio:</strong> $<?= $actividad['precio'] ?></li>
                <li><strong>⏱ Duración:</strong> <?= $actividad['duracion'] ?> horas</li>
                <li><strong>📌 Estado:</strong> <?= ucfirst($actividad['estado']) ?></li>
            </ul>

            <h3>📝 Descripción completa:</h3>
            <p class="descripcion-larga"><?= $actividad['descripcion_larga'] ?></p>

            <h3>📦 Incluye:</h3>
            <ul class="incluye">
                <li>Guía turístico</li>
                <li>Transporte local</li>
                <li>Refrigerio</li>
            </ul>

            <div class="acciones">
                <a href="index.php?action=reservar&id=<?= $actividad['id_actividad'] ?>" class="boton">Reservar ahora</a>
                <a href="javascript:history.back()" class="boton secundario">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>

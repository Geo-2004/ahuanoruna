<?php
require_once RUTA_BASE .'/models/configuracion.php';
$config = new Configuracion();
$fondo = $config->obtenerFondo('actividades');

if (session_status() === PHP_SESSION_NONE){
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
    header('Location: index.php?action=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actividades</title>
    <link rel="stylesheet" href="public/css/actividades.css">
    <style>
        body {
            background-image: url('<?= $fondo ?>');
        }
    </style>
</head>
<body>

<!-- Encabezado directamente aquí -->
<header class="header-cliente">
    <h1 class="logo-cliente">🌿 Ahuanoruna</h1>
    <nav class="menu-cliente">
        <a href="index.php?action=dashboard_cliente">Inicio</a>
        <a href="index.php?action=actividades">Actividades</a>
        <a href="index.php?action=mis_reservas">Mis Reservas</a>
        <a href="index.php?action=mis_facturas">Mis Facturas</a>
        <a href="index.php?action=logout" class="cerrar-sesion">Cerrar Sesión</a>
    </nav>
</header>

<div class="actividades">
    <h2>Actividades Disponibles</h2>

    <?php if (!empty($actividades)): ?>
        <ul class="lista-actividades">
            <?php foreach ($actividades as $act): ?>
                <li class="actividad-item">
                    <?php if (!empty($act['imagen'])): ?>
                        <img src="<?= $act['imagen'] ?>" alt="Imagen de la actividad">
                    <?php endif; ?>
                    <h3 class="actividad-nombre"><?= $act['nombre'] ?></h3>
                    <p class="actividad-descripcion"><?= $act['descripcion'] ?></p>
                    <p class="actividad-detalles">
                        Precio: <span class="precio">$<?= $act['precio'] ?></span> –
                        Duración: <span class="duracion"><?= $act['duracion'] ?></span>
                    </p>
                    <a href="index.php?action=detalle_actividad&id=<?= $act['id_actividad'] ?>" class="boton">Ver más</a>
                    <a class="boton-reservar" href="index.php?action=reservar&id=<?= $act['id_actividad'] ?>">Reservar</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="sin-actividades">No hay actividades disponibles.</p>
    <?php endif; ?>
</div>
</body>
</html>

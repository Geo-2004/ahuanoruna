<?php
require_once RUTA_BASE .'/models/configuracion.php';
$config = new Configuracion();
$fondo = $config->obtenerFondo('mis_reservas');

if (session_status() === PHP_SESSION_NONE) {
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
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="public/css/mis_reservas.css">
    <style>
        body {
            background-image: url('<?= $fondo ?>');
        }
    </style>
</head>
<body>

<!-- Header integrado -->
<header class="header-cliente">
    <h1 class="logo-cliente">🌿 Ahuanoruna</h1>
    <nav class="menu-cliente">
        <a href="index.php?action=dashboard_cliente">Inicio</a>
        <a href="index.php?action=actividades">Actividades</a>
        <a href="index.php?action=mis_reservas" class="activo">Mis Reservas</a>
        <a href="index.php?action=mis_facturas">Mis Facturas</a>
        <a href="index.php?action=logout" class="cerrar-sesion">Cerrar Sesión</a>
    </nav>
</header>

<div class="contenedor tarjeta">
    <h2>Mis Reservas</h2>

    <?php if (!empty($reservas)): ?>
        <table>
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Fecha</th>
                    <th>Personas</th>
                    <th>Estado</th>
                    <th>Monto</th>
                    <th>Método</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['actividad']) ?></td>
                        <td><?= htmlspecialchars($r['fecha_actividad']) ?></td>
                        <td><?= htmlspecialchars($r['cantidad_personas']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($r['estado'])) ?></td>
                        <td><?= isset($r['monto_total']) ? '$' . htmlspecialchars($r['monto_total']) : '-' ?></td>
                        <td><?= htmlspecialchars($r['metodo_pago'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes reservas registradas todavía.</p>
    <?php endif; ?>
</div>

</body>
</html>

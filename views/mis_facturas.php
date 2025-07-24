<?php
require_once RUTA_BASE .'/models/configuracion.php';

$config = new Configuracion();
$fondo = $config->obtenerFondo('mis_facturas');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
    header('Location: index.php?action=login');
    exit();
}

// Aquí asumo que $facturas ya está cargado antes de incluir esta vista
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Mis Facturas</title>
    <link rel="stylesheet" href="public/css/mis_facturas.css" />
    <style>
        body {
            background-image: url('<?= $fondo ?>');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
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
        <a href="index.php?action=mis_reservas">Mis Reservas</a>
        <a href="index.php?action=mis_facturas" class="activo">Notas de Venta</a>
        <a href="index.php?action=logout" class="cerrar-sesion">Cerrar Sesión</a>
    </nav>
</header>

<div class="contenedor tarjeta">
    <h2>Mis Notas de Venta</h2>
    <?php if (!empty($facturas)): ?>
        <table>
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Fecha Pago</th>
                    <th>Monto Total</th>
                    <th>Método</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facturas as $factura): ?>
                    <tr>
                        <td><?= htmlspecialchars($factura['actividad']) ?></td>
                        <td><?= htmlspecialchars($factura['fecha_pago']) ?></td>
                        <td>$<?= htmlspecialchars($factura['monto_total']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($factura['metodo_pago'])) ?></td>
                        <td>
                            <a href="index.php?action=imprimir&id=<?= urlencode($factura['id_factura']) ?>" class="btn-ver-detalle">Ver más</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes facturas registradas aún.</p>
    <?php endif; ?>
</div>

</body>
</html>

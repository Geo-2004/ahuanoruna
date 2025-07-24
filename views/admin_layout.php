<?php
require_once RUTA_BASE .'/models/configuracion.php';
require_once RUTA_BASE .'/models/reserva.php';
require_once RUTA_BASE .'/models/Pago.php';

$pagoModel = new Pago();
$ingresosHoy = $pagoModel->obtenerIngresosHoy();


$config = new Configuracion();
$fondo = $config->obtenerFondo('admin_dashboard');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: index.php?action=login');
    exit();
}

$accionActual = $_GET['action'] ?? 'admin_dashboard'; // ✅ Para detectar la opción actual

// Cargar métricas si no se solicitó una vista diferente
$reservaModel = new Reserva();
$reservasHoy = $reservaModel->contarReservasHoy();
$ingresosHoy = $reservaModel->sumarIngresosHoy();
$totalClientes = $reservaModel->contarClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="public/css/dashboard_admin.css">
    <link rel="stylesheet" href="public/css/admin_actividades.css">    
    <link rel="stylesheet" href="public/css/form_crear_actividad.css">
    <link rel="stylesheet" href="public/css/dashboard_cliente_config.css">
    <style>
        body {
            background-image: url('<?= $fondo ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
<div class="layout">
    <!-- Menú lateral -->
    <aside class="sidebar">
        <div class="sidebar-logo">🌿 Ahuanoruna Admin</div>
        <nav class="sidebar-menu">
            <a href="index.php?action=admin_dashboard" class="<?= ($accionActual == 'admin_dashboard') ? 'activo' : '' ?>">Inicio Admin</a>
            <a href="index.php?action=editar_dashboard_cliente" class="<?= ($accionActual == 'editar_dashboard_cliente') ? 'activo' : '' ?>">Editar Dashboard Cliente</a>
            <a href="index.php?action=gestionar_usuarios" class="<?= ($accionActual == 'gestionar_usuarios') ? 'activo' : '' ?>">Usuarios</a>
            <a href="index.php?action=limite_reservas" class="<?= ($accionActual == 'limite_reservas') ? 'activo' : '' ?>">Límites</a>
            <a href="index.php?action=gestionar_actividades" class="<?= ($accionActual == 'gestionar_actividades') ? 'activo' : '' ?>">Actividades</a>
            <a href="index.php?action=gestionar_reservas" class="<?= ($accionActual == 'gestionar_reservas') ? 'activo' : '' ?>">Reservas</a>
            <a href="index.php?action=gestionar_cuentas" class="<?= ($accionActual == 'gestionar_cuentas') ? 'activo' : '' ?>">Cuentas</a>
            <a href="index.php?action=configuracion" class="<?= ($accionActual == 'configuracion') ? 'activo' : '' ?>">Fondos</a>
            <a href="index.php?action=configurar_footer" class="<?= ($accionActual == 'configurar_footer') ? 'activo' : '' ?>">Pie de página</a>
            <a href="index.php?action=logout" class="logout">Cerrar sesión</a>
        </nav>
    </aside>

    <!-- Contenido dinámico o dashboard por defecto -->
    <main class="contenido-principal">
        <?php
        if (isset($contenido) && file_exists($contenido)) {
            include $contenido;
        } else {
            ?>
            <h2>Bienvenido, <?= $_SESSION['usuario']['nombres'] ?></h2>
            <p>Selecciona una opción del menú para comenzar.</p>

            <div class="contenedor-metricas">
                <div class="caja-metrica">
                    <h3>Reservas Hoy</h3>
                    <p class="dato"><?= $reservasHoy ?></p>
                </div>
                <div class="caja-metrica">
                    <h3>Ingresos Hoy</h3>
                    <p class="dato">$<?= number_format($ingresosHoy, 2) ?></p>
                </div>
                <div class="caja-metrica">
                    <h3>Clientes</h3>
                    <p class="dato"><?= $totalClientes ?></p>
                </div>
            </div>
            <?php
        }
        ?>
    </main>
</div>
</body>
</html>

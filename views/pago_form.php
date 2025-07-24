<?php
require_once RUTA_BASE .'/models/Configuracion.php';
$config = new Configuracion();
$fondo = $config->obtenerFondo('pago_form');

if (session_status() === PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago de Reserva</title>
    <link rel="stylesheet" href="public/css/pago_form.css">
    <style>
        body {
            background-image: url('<?= $fondo ?>');
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
    <div class="formulario-reserva">
        <h2>Pago por Transferencia</h2>

        <div class="info-transferencia">
            <h3>Datos para Transferencia Bancaria</h3>
            <?php if (!empty($cuentas)): ?>
                <ul>
                    <?php foreach ($cuentas as $cuenta): ?>
                        <li>
                            <strong><?= $cuenta['banco'] ?></strong> — 
                            <?= $cuenta['tipo_cuenta'] ?> #<?= $cuenta['numero_cuenta'] ?><br>
                            Titular: <?= $cuenta['nombre_titular'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay cuentas bancarias activas registradas.</p>
            <?php endif; ?>
        </div>

        <form action="index.php?action=pagar" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">
            <input type="hidden" name="monto" value="<?= $monto_total ?>">

            <p><strong>Cliente:</strong> <?= $_SESSION['usuario']['nombres'] . ' ' . $_SESSION['usuario']['apellidos'] ?></p>
            <p><strong>Actividad:</strong> <?= $actividad['nombre'] ?></p>
            <p><strong>Fecha de actividad:</strong> <?= $reserva['fecha_actividad'] ?></p>
            <p><strong>Cantidad de personas:</strong> <?= $reserva['cantidad_personas'] ?></p>
            <p><strong>Total a pagar:</strong> $<?= number_format($monto_total, 2) ?></p>

            <label>Número de comprobante:</label>
            <input type="text" name="numero_comprobante" required>

            <label>Sube una imagen del comprobante:</label>
            <input type="file" name="comprobante" accept="image/*" required><br><br>

            <button type="submit">Confirmar Pago</button>
        </form>
    </div>
</body>
</html>

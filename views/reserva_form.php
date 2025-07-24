<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar actividad</title>
    <style>
        body {
            background: #f4fce3;
            font-family: 'Quicksand', Arial, sans-serif;
        }

        .contenedor {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 40px;
        }

        .formulario, .pago {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 16px rgba(56,142,60,0.13);
            padding: 32px 28px;
            width: 420px;
            min-width: 280px;
            border: 1.5px solid #b7e4c7;
        }

        .formulario h2, .pago h2 {
            color: #388e3c;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 18px;
            text-align: center;
        }

        .formulario label, .pago label {
            color: #2e4637;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .formulario input, .formulario select,
        .pago input, .pago select {
            width: 100%;
            padding: 0.7rem;
            border: 1.5px solid #b7e4c7;
            border-radius: 8px;
            background: #e8f5e9;
            font-size: 1rem;
            margin-bottom: 12px;
            transition: border 0.2s;
            box-sizing: border-box;
        }

        .formulario input:focus, .formulario select:focus,
        .pago input:focus, .pago select:focus {
            border: 2px solid #388e3c;
            outline: none;
        }

        .formulario button, .pago button {
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
            margin-top: 12px;
            width: 100%;
        }

        .formulario button:hover, .pago button:hover {
            background: linear-gradient(90deg, #4caf50 0%, #388e3c 100%);
        }

        .pago h3 {
            color: #388e3c;
            font-size: 1.1rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .pago ul {
            background: #f4fce3;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 18px;
            list-style: none;
        }

        .pago ul li {
            margin-bottom: 12px;
            color: #2e4637;
            font-size: 1rem;
            border-bottom: 1px solid #e8f5e9;
            padding-bottom: 8px;
        }

        .pago ul li:last-child {
            border-bottom: none;
        }

        .pago p, .formulario p {
            margin-bottom: 10px;
            color: #388e3c;
            font-size: 1rem;
        }

        @media (max-width: 900px) {
            .contenedor {
                flex-direction: column;
                gap: 24px;
                align-items: center;
            }
            .formulario, .pago {
                width: 98vw;
                max-width: 480px;
                padding: 18px 8px;
            }
        }
    </style>
</head>
<body>

<div class="contenedor">
    <!-- FORMULARIO DE RESERVA -->
    <div class="formulario formulario-reserva">
        <h2>Reservar actividad</h2>
        <form method="POST" action="index.php?action=reservar">
            <label>Actividad:</label><br>
            <select name="id_actividad" required>
                <?php foreach ($actividades as $act): ?>
                    <option value="<?= $act['id_actividad'] ?>" 
                        <?= (isset($idActividad) && $idActividad == $act['id_actividad']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($act['nombre']) ?> - $<?= number_format($act['precio'], 2) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label>Fecha:</label><br>
<?php $minFecha = date('Y-m-d', strtotime('+1 day')); ?>
<input type="date" name="fecha_actividad" min="<?= $minFecha ?>" value="<?= $fecha ?? $minFecha ?>" required>
            
            <br><br>

            <label>Cantidad de personas:</label><br>
            <input type="number" name="cantidad_personas" min="1" value="<?= $cantidad ?? 1 ?>" required><br><br>
            <!-- campo de fecha actual -->
            <?php $fechaActual = date('Y-m-d'); ?><input type="hidden" name="fecha_reserva" value="<?= $fechaActual ?>">


            <button type="submit">Reservar</button>
        </form>
    </div>

    <!-- SECCIÓN DE PAGO (sólo si ya reservaste) -->
    <?php if (!empty($idReserva)): ?>
        <div class="pago">
            <h2>Pago por Transferencia</h2>

            <p><strong>Total a pagar:</strong> $<?= number_format($montoTotal, 2) ?></p>

            <h3>Datos para Transferencia Bancaria</h3>
            <?php if (!empty($cuentas)): ?>
                <ul>
                    <?php foreach ($cuentas as $cuenta): ?>
                        <li>
                            <strong><?= htmlspecialchars($cuenta['banco']) ?></strong> — 
                            <?= htmlspecialchars($cuenta['tipo_cuenta']) ?> #<?= htmlspecialchars($cuenta['numero_cuenta']) ?><br>
                            Titular: <?= htmlspecialchars($cuenta['nombre_titular']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay cuentas bancarias activas registradas.</p>
            <?php endif; ?>

            <form action="index.php?action=pagar" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($idReserva) ?>">
                <input type="hidden" name="monto" value="<?= htmlspecialchars($montoTotal) ?>">

                <p><strong>Cliente:</strong> <?= htmlspecialchars($_SESSION['usuario']['nombres'] . ' ' . $_SESSION['usuario']['apellidos']) ?></p>
                <p><strong>Actividad:</strong> <?= htmlspecialchars($actividad['nombre']) ?></p>
<p><strong>Fecha de actividad:</strong> <?= htmlspecialchars($fechaActividad ?? '') ?></p>
                <p><strong>Cantidad de personas:</strong> <?= htmlspecialchars($cantidad) ?></p>
                <p><strong>Total a pagar:</strong> $<?= number_format($montoTotal, 2) ?></p>

                <label>Número de comprobante:</label><br>
                <input type="text" name="numero_comprobante" required><br><br>

                <label>Sube una imagen del comprobante:</label><br>
                <input type="file" name="comprobante" accept="image/*" required><br><br>

                <button type="submit">Confirmar Pago</button>
            </form>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

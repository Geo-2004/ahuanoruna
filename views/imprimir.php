<?php
require_once RUTA_BASE . '/models/Factura.php';

if (isset($_GET['id'])) {
    $facturaModel = new Factura();
    $factura = $facturaModel->obtenerPorId($_GET['id']);

    if ($factura):
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Venta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 30px;
            color: #333;
        }
        .nota-container {
            max-width: 700px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 25px;
            border-radius: 8px;
        }
        .encabezado, .cliente, .tabla-detalles, .totales {
            margin-bottom: 25px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .datos-cliente p, .otros p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        .totales {
            text-align: right;
        }
        .totales p {
            font-size: 16px;
            font-weight: bold;
        }
        .encabezado-flex {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.encabezado-flex .izquierda {
    text-align: left;
}

.encabezado-flex .derecha {
    text-align: right;
}

    </style>
</head>
<body onload="window.print();">
    <div class="nota-container">
        <h2>NOTA DE VENTA</h2>

        <div class="encabezado-flex">
    <div class="izquierda">
        <p><strong>Fecha de Emisión:</strong> <?= $factura['fecha_emision'] ?></p>
    </div>
    <div class="derecha">
        <p><strong>N° Factura:</strong> <?= $factura['id_factura'] ?></p>
    </div>
</div>


        <div class="cliente">
            <h3>Datos del Cliente</h3>
            <div class="datos-cliente">
                <p><strong>Nombre:</strong> <?= $factura['nombres'] . ' ' . $factura['apellidos'] ?></p>
                <p><strong>Cédula:</strong> <?= $factura['cedula'] ?></p>
                <p><strong>Correo:</strong> <?= $factura['correo'] ?></p>
                <p><strong>Teléfono:</strong> <?= $factura['telefono'] ?></p>
            </div>
        </div>

        <div class="tabla-detalles">
            <h3>Detalle</h3>
            <table>
    <thead>
        <tr>
            <th>#</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Reserva de: <?= htmlspecialchars($factura['actividad']) ?></td>
            <td><?= htmlspecialchars($factura['cantidad_personas'] ?? 1) ?></td>
            <td>$<?= number_format($factura['total'] / max(1, $factura['cantidad_personas']), 2) ?></td>
            <td>$<?= number_format($factura['total'], 2) ?></td>
        </tr>
    </tbody>
</table>

        </div>

        <div class="otros">
            
            <p><strong>Fecha Actividad:</strong> <?= $factura['fecha_actividad'] ?></p>
            <p><strong>Método de Pago:</strong> <?= $factura['metodo_pago'] ?? 'No registrado' ?></p>
            <p><strong>Estado:</strong> <?= ucfirst($factura['estado'] ?? 'Pendiente') ?></p>
        </div>

        <div class="totales">
            <p>Total a Pagar: $<?= number_format($factura['total'], 2) ?></p>
        </div>
    </div>
</body>
</html>
<?php
    else:
        echo "Factura no encontrada.";
    endif;
} else {
    echo "ID de factura no especificado.";
}
?>

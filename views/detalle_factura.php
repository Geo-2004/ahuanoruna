<?php
require_once RUTA_BASE .'/models/Factura.php';

if (isset($_GET['id'])) {
    $facturaModel = new Factura();
    $factura = $facturaModel->obtenerPorId($_GET['id']);

    if ($factura): ?>
    <style>
        .detalle-factura-box {
            max-width: 500px;
            margin: 40px auto;
            background: #f8fff6;
            padding: 32px 28px;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(56,142,60,0.13);
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
        }
        .detalle-factura-box h3 {
            color: #388e3c;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 18px;
            text-align: center;
        }
        .seccion {
            margin-bottom: 18px;
            background: #e8f5e9;
            border-radius: 8px;
            padding: 16px;
        }
        .seccion p {
            margin: 8px 0;
            font-size: 1.05rem;
        }
        .fila-dato {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 1rem;
        }
        .boton-imprimir {
            display: block;
            width: 100%;
            background-color: #388e3c;
            color: #fff;
            padding: 12px 0;
            text-align: center;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 18px;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(56, 142, 60, 0.08);
        }
        .boton-imprimir:hover {
            background-color: #2e4637;
        }
        @media (max-width: 600px) {
            .detalle-factura-box {
                padding: 12px 4px;
                max-width: 98vw;
            }
        }
    </style>
    <div class="detalle-factura-box">
        <h3>Factura #<?= $factura['id_factura'] ?></h3>

        <div class="seccion">
            <p><strong>Cliente:</strong> <?= $factura['nombres'] . ' ' . $factura['apellidos'] ?></p>
            <p><strong>Actividad:</strong> <?= $factura['actividad'] ?></p>
        </div>

        <div class="seccion">
            <div class="fila-dato">
                <span><strong>Fecha Actividad:</strong></span>
                <span><?= $factura['fecha_actividad'] ?></span>
            </div>
            <div class="fila-dato">
                <span><strong>Total:</strong></span>
                <span>$<?= $factura['total'] ?></span>
            </div>
            <div class="fila-dato">
                <span><strong>Fecha Emisión:</strong></span>
                <span><?= $factura['fecha_emision'] ?></span>
            </div>
        </div>

        <div class="seccion">
            <p><strong>Detalle:</strong></p>
            <p><?= nl2br(htmlspecialchars($factura['detalle'])) ?></p>
        </div>

        <a href="index.php?action=imprimir_factura&id=<?= $factura['id_factura'] ?>" target="_blank" class="boton-imprimir">🖨️ Imprimir Factura</a>
        <a href="index.php?action=imprimir&id=<?= $factura['id_factura'] ?>" target="_blank" class="boton-imprimir">🖨️ Imprimir Factura</a>

    </div>
    <?php else: ?>
        <p>Error: factura no encontrada.</p>
    <?php endif;
} else {
    echo "<p>ID de factura no especificado.</p>";
}

<?php
require_once RUTA_BASE . '/models/factura.php';

class FacturaController {

    // Mostrar todas las facturas del cliente logueado
    public function misFacturas() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
            header('Location: index.php?action=login');
            exit();
        }

        $facturaModel = new Factura();
        $facturas = $facturaModel->obtenerPorUsuario($_SESSION['usuario']['id_usuario']);

        // Mostrar vista
        include RUTA_BASE . '/views/mis_facturas.php';
    }

    // Imprimir una factura específica
    public function imprimir() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?action=login');
        exit();
    }

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "⚠️ Factura no especificada.";
        return;
    }

    $facturaModel = new Factura();
    $factura = $facturaModel->obtenerPorId($_GET['id']); // <--- Cambiado

    if ($factura) {
        include RUTA_BASE . '/views/imprimir.php';  // Aquí la vista usará $factura
    } else {
        echo "⚠️ Factura no encontrada.";
    }
}


    // Mostrar detalles de factura (usado en ventana modal o carga dinámica)
    public function detalleFactura() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
            echo "<p>Acceso denegado.</p>";
            return;
        }

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "<p>ID de factura no especificado.</p>";
            return;
        }

        $id = intval($_GET['id']);
        $facturaModel = new Factura();
        $factura = $facturaModel->obtenerPorId($id);

        if (!$factura) {
            echo "<p>Factura no encontrada.</p>";
            return;
        }

        // Se muestra solo el bloque con el detalle
        ?>
        <div class="detalle-factura-box">
            <h3>Factura #<?= htmlspecialchars($factura['id_factura']) ?></h3>
            <p><strong>Cliente:</strong> <?= htmlspecialchars($factura['nombres'] . ' ' . $factura['apellidos']) ?></p>
            <p><strong>Actividad:</strong> <?= htmlspecialchars($factura['actividad']) ?></p>
            <p><strong>Fecha Actividad:</strong> <?= htmlspecialchars($factura['fecha_actividad']) ?></p>
            <p><strong>Total:</strong> $<?= htmlspecialchars(number_format($factura['total'], 2)) ?></p>
            <p><strong>Detalle:</strong> <?= nl2br(htmlspecialchars($factura['detalle'])) ?></p>
            <p><strong>Fecha Emisión:</strong> <?= htmlspecialchars($factura['fecha_emision']) ?></p>
            <button onclick="window.print()">🖨️ Imprimir</button>
        </div>
        <?php
    }

    // Aquí puedes añadir más métodos según tus necesidades (AJAX, exportar, etc.)
    
}

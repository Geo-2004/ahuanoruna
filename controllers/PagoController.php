<?php
require_once RUTA_BASE .'/models/Pago.php';
require_once RUTA_BASE .'/models/Reserva.php';
require_once RUTA_BASE .'/models/Actividad.php';
require_once RUTA_BASE .'/models/Factura.php';
require_once RUTA_BASE .'/models/CuentaBancaria.php';

class PagoController {
    public function pagar() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $pagoModel = new Pago();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_reserva = $_POST['id_reserva'];
            $monto = $_POST['monto'];
            $metodo = 'transferencia'; // fijo por ahora
            $numero_comprobante = $_POST['numero_comprobante'];

            // Validar y subir comprobante
            if ($_FILES['comprobante']['error'] === 0) {
                $rutaDestino = 'public/images/comprobantes/';
                if (!is_dir($rutaDestino)) mkdir($rutaDestino, 0777, true);

                $nombreArchivo = uniqid() . '_' . basename($_FILES['comprobante']['name']);
                $rutaCompleta = $rutaDestino . $nombreArchivo;

                if (!move_uploaded_file($_FILES['comprobante']['tmp_name'], $rutaCompleta)) {
                    echo "Error al subir el comprobante.";
                    return;
                }
            } else {
                echo "Comprobante obligatorio.";
                return;
            }

            // Registrar pago con estado pendiente
            $pagoModel->registrar($id_reserva, $monto, $metodo, $rutaCompleta, $numero_comprobante);

            // Crear factura (opcional, dependiendo flujo)
            $detalle = "Pago de reserva #$id_reserva por $$monto. Nº Comprobante: $numero_comprobante";
            $factura = new Factura();
            $factura->crear($id_reserva, $monto, $detalle);

            echo "<script>alert('Pago registrado correctamente, pendiente de confirmación.'); window.location.href='index.php?action=mis_facturas';</script>";
            exit();
        }

        $id_reserva = $_GET['id_reserva'] ?? null;
        if (!$id_reserva) {
            echo "Reserva no especificada.";
            return;
        }

        if ($pagoModel->existePago($id_reserva)) {
            echo "<script>alert('Esta reserva ya fue pagada.'); window.location.href='index.php?action=mis_facturas';</script>";
            return;
        }

        $reservaModel = new Reserva();
        $reserva = $reservaModel->obtenerPorId($id_reserva);
        $actividadModel = new Actividad();
        $actividad = $actividadModel->obtenerPorId($reserva['id_actividad']);
        $monto_total = $actividad['precio'] * $reserva['cantidad_personas'];

        $cuentaModel = new CuentaBancaria();
        $cuentas = $cuentaModel->obtenerTodasActivas();

        include RUTA_BASE .'/views/pago_form.php';
    }

}
?>

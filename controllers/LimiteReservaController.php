<?php
require_once RUTA_BASE .'/models/LimiteReserva.php';

class LimiteReservaController {

    public function formulario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            return;
        }
        $contenido = 'views/admin_limite_reservas.php'; // ✅ Contenido a mostrar dentro del layout
        require RUTA_BASE .'/views/admin_layout.php';     // ✅ Layout general
    }

    public function guardar() {
        session_start();
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            return;
        }

        $fecha = $_POST['fecha'];
        $maximo = $_POST['maximo'];

        $limite = new LimiteReserva();
        $limite->establecer($fecha, $maximo);

        header("Location: index.php?action=limite_reservas");
    }
}
?>

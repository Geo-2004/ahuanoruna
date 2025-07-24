<?php
require_once RUTA_BASE .'/models/reserva.php';
require_once RUTA_BASE .'/models/actividad.php';
require_once RUTA_BASE .'/models/LimiteReserva.php'; // Para el límite diario
require_once RUTA_BASE .'/models/CuentaBancaria.php';
require_once RUTA_BASE .'/models/factura.php';


class ReservaController {
    public function reservar() {
    // Inicia sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Solo usuarios logueados pueden reservar
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?action=login');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_actividad'])) {
        // Recibir datos del formulario
        $idActividad = $_POST['id_actividad'];
        $fechaActividad = $_POST['fecha_actividad'];
        $cantidad = $_POST['cantidad_personas'];
        $fechaReservaActual = $_POST['fecha_reserva']; // <-- FECHA AUTOMÁTICA DESDE EL FORMULARIO

        $idUsuario = $_SESSION['usuario']['id_usuario'];

        // Crear reserva en la base de datos
        $reservaModel = new Reserva();
        $idReserva = $reservaModel->crear($idActividad, $fechaActividad, $cantidad, $idUsuario, $fechaReservaActual);

        // Obtener información de la actividad
        $actividadModel = new Actividad();
        $actividad = $actividadModel->obtenerPorId($idActividad);
        $montoTotal = $actividad['precio'] * $cantidad;

        // Obtener cuentas bancarias para mostrar en la sección de pago
        $cuentaModel = new CuentaBancaria();
        $cuentas = $cuentaModel->obtenerTodas();

        // Obtener todas las actividades para el selector del formulario
        $actividades = $actividadModel->obtenerTodas();

        // Mostrar vista con el formulario + sección de pago
        require RUTA_BASE .'/views/reserva_form.php';

    } else {
        // Si es un GET, simplemente mostramos el formulario vacío
        $actividadModel = new Actividad();
        $actividades = $actividadModel->obtenerTodas();
        $idReserva = null;
        $montoTotal = null;
        $cuentas = [];
        require RUTA_BASE .'/views/reserva_form.php';
    }
}



    // Métodos admin, editar, eliminar, mostrar reservas, etc


    public function listarAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
        echo "Acceso denegado.";
        return;
    }

    $reserva = new Reserva();
    $reservas = $reserva->obtenerTodas();

    $contenido = 'views/admin_reservas.php'; // 👉 aquí se define qué vista se cargará dentro del layout
    include RUTA_BASE .'/views/admin_layout.php';     // 👉 layout general que contiene el menú y la clase .contenido-principal
}

  public function editarAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once RUTA_BASE .'/models/Pago.php';

    $reserva = new Reserva();
    $pago = new Pago();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Actualizar reserva
        $reserva->actualizar(
            $_POST['id'],
            $_POST['fecha_actividad'],
            $_POST['cantidad_personas'],
            $_POST['estado_reserva']  // ojo aquí con el nombre distinto
        );

        // Actualizar estado del pago (si existe pago)
        if (isset($_POST['estado_pago'])) {
            $pago->actualizarEstadoPorReserva($_POST['id'], $_POST['estado_pago']);
        }

        header('Location: index.php?action=gestionar_reservas');
        exit();
    } else {
        $datos = $reserva->obtenerPorId($_GET['id']);
        $datosPago = $pago->obtenerPorReserva($_GET['id']); // método nuevo

        $contenido = 'views/form_editar_reservas.php';
        include RUTA_BASE .'/views/admin_layout.php';
    }
}


    
    public function eliminarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

        $reserva = new Reserva();
        $reserva->eliminar($_GET['id']);
        header('Location: index.php?action=gestionar_reservas');
    }
    public function mostrarDesdeInicio() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
        header('Location: index.php?action=login');
        exit();
    }

    if (!isset($_GET['id'])) {
        echo "ID de actividad no especificado.";
        return;
    }

    $id_actividad = $_GET['id'];

    // Obtener solo esa actividad
    require_once RUTA_BASE .'models/actividad.php';
    $actividadModel = new Actividad();
    $actividad = $actividadModel->obtenerPorId($id_actividad);

    if (!$actividad) {
        echo "La actividad no existe.";
        return;
    }

    // Enviar como arreglo para que funcione igual que en la vista
    $actividades = [$actividad];

    include RUTA_BASE .'views/reserva_form.php';
    }

    public function misReservasCliente() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
        header('Location: index.php?action=login');
        exit();
    }

    $reserva = new Reserva();
    $reservas = $reserva->obtenerReservasPorCliente($_SESSION['usuario']['id_usuario']);

    include RUTA_BASE .'/views/mis_reservas.php';
}

        

}
?>

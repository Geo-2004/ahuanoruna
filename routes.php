<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'controllers/UsuarioController.php';

$action = $_GET['action'] ?? 'inicio';

switch ($action) {

    // Autenticación y perfil
    case 'registrar':
        (new UsuarioController())->registrar();
        break;

    case 'login':
        (new UsuarioController())->login();
        break;

    case 'logout':
        (new UsuarioController())->logout();
        break;

    case 'perfil_admin':
        (new UsuarioController())->verPerfilAdmin();
        break;

    // Actividades
    case 'actividades':
        require_once 'controllers/ActividadController.php';
        (new ActividadController())->listar();
        break;

    case 'gestionar_actividades':
        require_once 'controllers/ActividadController.php';
        (new ActividadController())->adminListar();
        break;

    case 'crear_actividad':
        require_once 'controllers/ActividadController.php';
        (new ActividadController())->crear();
        break;

    case 'editar_actividad':
        require_once 'controllers/ActividadController.php';
        (new ActividadController())->editar();
        break;

    case 'eliminar_actividad':
        require_once 'controllers/ActividadController.php';
        (new ActividadController())->eliminar();
        break;

    case 'detalle_actividad':
        include 'views/detalle_actividad.php';
        break;

    // Usuarios
    case 'gestionar_usuarios':
        (new UsuarioController())->listarAdmin();
        break;

    case 'editar_usuario':
        (new UsuarioController())->editarAdmin();
        break;

    case 'eliminar_usuario':
        (new UsuarioController())->eliminarAdmin();
        break;

    // Reservas
    case 'reservar':
        require_once 'controllers/ReservaController.php';
        (new ReservaController())->reservar();
        break;

    case 'mis_reservas':
        require_once 'controllers/ReservaController.php';
        (new ReservaController())->misReservasCliente();
        break;

    case 'gestionar_reservas':
        require_once 'controllers/ReservaController.php';
        (new ReservaController())->listarAdmin();
        break;

    case 'editar_reserva':
        require_once 'controllers/ReservaController.php';
        (new ReservaController())->editarAdmin();
        break;

    case 'eliminar_reserva':
        require_once 'controllers/ReservaController.php';
        (new ReservaController())->eliminarAdmin();
        break;

    case 'cambiar_estado_reserva':
        require_once 'controllers/ReservaController.php';
        (new ReservaController())->cambiarEstadoManual();
        break;

    case 'ver_actividad':
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?action=login');
            exit();
        }
        require_once 'controllers/ReservaController.php';
        (new ReservaController())->mostrarDesdeInicio();
        break;

    // Pagos
    case 'pagar':
        require_once 'controllers/PagoController.php';
        (new PagoController())->pagar();
        break;

    case 'pagos_admin':
        require_once 'controllers/PagoController.php';
        (new PagoController())->listarAdmin();
        break;

    case 'eliminar_pago':
        require_once 'controllers/ReservaController.php';
        (new ReservaController())->eliminarPago();
        break;

    // Facturas
    case 'mis_facturas':
        require_once 'controllers/FacturaController.php';
        (new FacturaController())->misFacturas();
        break;

    case 'imprimir_factura':
        require_once 'controllers/FacturaController.php';
        (new FacturaController())->imprimir();
        break;

    case 'detalle_factura':
        require_once 'controllers/FacturaController.php';
        (new FacturaController())->detalleFactura();
        break;

    // Cuentas Bancarias
    case 'gestionar_cuentas':
        require_once 'controllers/CuentaBancariaController.php';
        (new CuentaBancariaController())->listarAdmin();
        break;

    case 'crear_cuenta':
        require_once 'controllers/CuentaBancariaController.php';
        (new CuentaBancariaController())->crear();
        break;

    case 'editar_cuenta':
        require_once 'controllers/CuentaBancariaController.php';
        (new CuentaBancariaController())->editar();
        break;

    case 'eliminar_cuenta':
        require_once 'controllers/CuentaBancariaController.php';
        (new CuentaBancariaController())->eliminar();
        break;

    // Configuración General
    case 'configuracion':
        require_once 'controllers/ConfiguracionController.php';
        (new ConfiguracionController())->formularioFondo();
        break;

    case 'actualizar_fondo':
        require_once 'controllers/ConfiguracionController.php';
        (new ConfiguracionController())->actualizarFondo();
        break;

    case 'subir_fondo':
        require_once 'controllers/ConfiguracionController.php';
        (new ConfiguracionController())->subirFondo();
        break;

    case 'eliminar_fondo':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->eliminarFondo();
        break;

    // Límite de reservas
    case 'limite_reservas':
        require_once 'controllers/LimiteReservaController.php';
        (new LimiteReservaController())->formulario();
        break;

    case 'guardar_limite_reservas':
        require_once 'controllers/LimiteReservaController.php';
        (new LimiteReservaController())->guardar();
        break;

    // Dashboard Cliente
    case 'dashboard_cliente':
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'cliente') {
            include 'views/dashboard_cliente.php';
        } else {
            echo "Acceso denegado.";
        }
        break;

    // Configuración Dashboard Cliente
    case 'editar_dashboard_cliente':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->editar();
        break;

    case 'guardar_dashboard_cliente':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->guardar();
        break;

    case 'guardar_bienvenida_titulo':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->guardarBienvenidaTitulo();
        break;

    case 'guardar_bienvenida_texto':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->guardarBienvenidaTexto();
        break;

    case 'guardar_clima_ciudad':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->guardarClimaCiudad();
        break;

    case 'guardar_mapa':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->guardarMapa();
        break;

    case 'guardar_video':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->guardarVideo();
        break;

    case 'guardar_galeria':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->guardarGaleria();
        break;

    case 'eliminarImagen':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->eliminarImagen();
        break;

    case 'eliminarVideo':
        require_once 'controllers/ConfiguracionDashboardController.php';
        (new ConfiguracionDashboardController())->eliminarVideo();
        break;

    // Footer
    case 'editar_footer':
    case 'configurar_footer':
    case 'guardar_footer':
        require_once 'controllers/FooterController.php';
        $controller = new FooterController();
        switch ($action) {
            case 'editar_footer':
                $controller->editar();
                break;
            case 'configurar_footer':
                $controller->formulario();
                break;
            case 'guardar_footer':
                $controller->guardar();
                break;
        }
        break;

    // Panel Admin principal
    case 'admin_dashboard':
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin') {
            include 'views/admin_layout.php';
        } else {
            echo "Acceso denegado.";
        }
        break;


         // Recuperación de contraseña
    case 'recuperar':
        include 'views/recuperar.php';
        break;

    case 'recuperar_enviar':
        (new UsuarioController())->recuperar_enviar();
        break;

    case 'recuperar_form':
        include 'views/recuperar_form.php';
        break;

    case 'recuperar_cambiar':
        (new UsuarioController())->recuperar_cambiar();
        break;

    case 'imprimir':
        include 'views/imprimir.php';
        break;

    // Página de inicio (por defecto)
    case 'inicio':
    default:
        include 'views/inicio.php';
        break;

   
}

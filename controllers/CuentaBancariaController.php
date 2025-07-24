<?php
require_once RUTA_BASE .'/models/CuentaBancaria.php';

class CuentaBancariaController {

    private function asegurarSesionAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            exit(); // Importante para cortar la ejecución si no tiene permisos
        }
    }

    public function listarAdmin() {
        $this->asegurarSesionAdmin();

        $cuentaModel = new CuentaBancaria();
$cuentas = $cuentaModel->obtenerTodas();
$contenido = 'views/admin_cuentas.php'; // Ruta de la vista parcial
include RUTA_BASE .'/views/admin_layout.php'; // Carga el layout completo

    }

    public function crear() {
        $this->asegurarSesionAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cuenta = new CuentaBancaria();
            $cuenta->crear(
                $_POST['banco'],
                $_POST['numero_cuenta'],
                $_POST['tipo_cuenta'],
                $_POST['nombre_titular'],
                $_POST['estado']
            );
            header('Location: index.php?action=gestionar_cuentas');
            exit();
        } else {
        $contenido = 'views/form_cuenta.php'; // 👈 Esta es la vista parcial
        include RUTA_BASE .'/views/admin_layout.php';   // 👈 Esta es la plantilla completa del admin
    }
}
    public function editar() {
        $this->asegurarSesionAdmin();

        $cuenta = new CuentaBancaria();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cuenta->actualizar(
                $_POST['id'],
                $_POST['banco'],
                $_POST['numero_cuenta'],
                $_POST['tipo_cuenta'],
                $_POST['nombre_titular'],
                $_POST['estado']
            );
            header('Location: index.php?action=gestionar_cuentas');
            exit();
        } else {
            $datos = $cuenta->obtenerPorId($_GET['id']);
            $contenido = 'views/form_cuenta.php'; // Vista parcial (solo el formulario)
        include RUTA_BASE .'/views/admin_layout.php';  // Plantilla completa del panel admin
    }
}
    public function eliminar() {
        $this->asegurarSesionAdmin();

        $cuenta = new CuentaBancaria();
        $cuenta->eliminar($_GET['id']);
        header('Location: index.php?action=gestionar_cuentas');
        exit();
    }
}

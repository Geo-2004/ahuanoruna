<?php
require_once RUTA_BASE .'/models/Footer.php';

class FooterController {
    public function editar() {
        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            return;
        }

        $footer = new Footer();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                ':telefono' => $_POST['telefono'],
                ':correo' => $_POST['correo'],
                ':direccion' => $_POST['direccion'],
                ':facebook' => $_POST['facebook'],
                ':instagram' => $_POST['instagram'],
                ':whatsapp' => $_POST['whatsapp']
            ];

            $footer->actualizar($datos);
            header('Location: index.php?action=editar_footer');
        } else {
            $datos = $footer->obtener();
            include RUTA_BASE .'views/form_footer.php';
        }
    }

    public function formulario() {
        $footer = new Footer();
        $datos = $footer->obtener();
        $contenido = 'views/form_footer.php';
        include RUTA_BASE .'/views/admin_layout.php';
    }   


    public function guardar() {
    session_start();
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
        echo "Acceso denegado.";
        return;
    }

    $datos = [
        ':telefono' => $_POST['telefono'],
        ':correo' => $_POST['correo'],
        ':direccion' => $_POST['direccion'],
        ':facebook' => $_POST['facebook'],
        ':instagram' => $_POST['instagram'],
        ':whatsapp' => $_POST['whatsapp']
    ];

    $footer = new Footer();
    $footer->actualizar($datos);

    echo "<script>
        alert('Cambios realizados con éxito.');
        window.location.href = 'index.php?action=admin_dashboard';
    </script>";
    exit;
}



}



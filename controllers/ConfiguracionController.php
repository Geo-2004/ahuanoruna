<?php
require_once RUTA_BASE .'/models/configuracion.php';

class ConfiguracionController {

    public function formularioFondo() {
        if (session_status()=== PHP_SESSION_NONE){
            session_start();
         }
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            return;
        }

        $config = new Configuracion();
        $fondos = [
            'login' => $config ->obtenerFondo('login'),
            'admin_dashboard' => $config->obtenerFondo('admin_dashboard'),
            'dashboard_cliente' => $config->obtenerFondo('dashboard_cliente'),
            'actividades' => $config->obtenerFondo('actividades')
        ];
         $contenido = 'views/admin_configuracion.php'; // ✅ Contenido a mostrar dentro del layout
        require RUTA_BASE .'/views/admin_layout.php';     // ✅ Layout general
    }

    public function actualizarFondo() {
        session_start();
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            return;
        }

        $vista = $_POST['vista'];
        $ruta = $_POST['ruta'];

        $config = new Configuracion();
        $config->actualizarFondo($vista, $ruta);

        header("Location: index.php?action=configuracion");
    }
    public function subirFondo() {
        if (session_status()=== PHP_SESSION_NONE){
            session_start();
         }
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            return;
        }
    
        if (isset($_FILES['fondo']) && isset($_POST['vista'])) {
            $vista = $_POST['vista'];
            $nombre = $_FILES['fondo']['name'];
            $tmp = $_FILES['fondo']['tmp_name'];
            $destino = "public/images/" . uniqid() . "_" . $nombre;
    
            if (move_uploaded_file($tmp, $destino)) {
                $config = new Configuracion();
                $config->actualizarFondo($vista, $destino);
                header("Location: index.php?action=configuracion");
            } else {
                echo "Error al subir imagen.";
            }
        } else {
            echo "Faltan datos.";
        }
    }
    
}
?>

<?php
require_once RUTA_BASE .'/models/ConfiguracionDashboard.php';
require_once RUTA_BASE .'/models/GaleriaDashboard.php';

class ConfiguracionDashboardController {
    private $model;
    private $galeriaModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            header('Location: index.php?action=login');
            exit();
        }

        $this->model = new ConfiguracionDashboard();
        $this->galeriaModel = new GaleriaDashboard();
    }

    private function obtenerDatosCompletos($datosParciales = []) {
        $base = [
            'bienvenida_titulo' => '',
            'bienvenida_texto' => '',
            'clima_ciudad' => '',
            'mapa_latitud' => '',
            'mapa_longitud' => '',
            'video_url' => ''
        ];
        return array_merge($base, $datosParciales);
    }

    public function editar() {
        $config = $this->model->obtenerConfiguracion();
        $imagenesGaleria = $this->galeriaModel->obtenerTodas();
        $contenido = 'views/config_dashboard_cliente.php'; // Vista parcial (solo el formulario)
        include RUTA_BASE .'/views/admin_layout.php';  // Plantilla completa del panel admin
    
     }
     

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'bienvenida_titulo' => $_POST['bienvenida_titulo'] ?? '',
                'bienvenida_texto' => $_POST['bienvenida_texto'] ?? '',
                'clima_ciudad' => $_POST['clima_ciudad'] ?? '',
                'mapa_latitud' => $_POST['mapa_latitud'] ?? '',
                'mapa_longitud' => $_POST['mapa_longitud'] ?? '',
                'video_url' => ''
            ];

            $uploadDir = 'public/img_clientes/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
                $videoTmp = $_FILES['video_file']['tmp_name'];
                $videoName = basename($_FILES['video_file']['name']);
                $videoExt = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));

                if ($videoExt === 'mp4') {
                    $videoFinalName = uniqid('video_') . '.' . $videoExt;
                    $videoPath = $uploadDir . $videoFinalName;
                    if (move_uploaded_file($videoTmp, $videoPath)) {
                        $datos['video_url'] = $videoPath;
                    }
                }
            } else {
                $configActual = $this->model->obtenerConfiguracion();
                $datos['video_url'] = $configActual['video_url'] ?? '';
            }

            $this->model->guardarConfiguracion($datos);

            if (isset($_FILES['imagenes_files']) && !empty($_FILES['imagenes_files']['name'][0])) {
                foreach ($_FILES['imagenes_files']['tmp_name'] as $key => $tmpName) {
                    $imgName = basename($_FILES['imagenes_files']['name'][$key]);
                    $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
                    if (in_array($imgExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $imgFinalName = uniqid('img_') . '.' . $imgExt;
                        $imgPath = $uploadDir . $imgFinalName;
                        if (move_uploaded_file($tmpName, $imgPath)) {
                            $this->galeriaModel->agregar($imgPath);
                        }
                    }
                }
            }

            header('Location: index.php?action=editar_dashboard_cliente&msg=guardado');
            exit();
        }
    }


    public function guardarBienvenidaTitulo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['bienvenida_titulo'] ?? '';
            if ($titulo !== '') {
                $config = $this->model->obtenerConfiguracion();
                $datos = $this->obtenerDatosCompletos($config);
                $datos['bienvenida_titulo'] = $titulo;
                $this->model->guardarConfiguracion($datos);
            }
            header('Location: index.php?action=editar_dashboard_cliente&msg=guardado_titulo');
            exit();
        }
    }

    public function guardarBienvenidaTexto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $texto = $_POST['bienvenida_texto'] ?? '';
            if ($texto !== '') {
                $config = $this->model->obtenerConfiguracion();
                $datos = $this->obtenerDatosCompletos($config);
                $datos['bienvenida_texto'] = $texto;
                $this->model->guardarConfiguracion($datos);
            }
            header('Location: index.php?action=editar_dashboard_cliente&msg=guardado_texto');
            exit();
        }
    }

    public function guardarClimaCiudad() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ciudad = $_POST['clima_ciudad'] ?? '';
            if ($ciudad !== '') {
                $config = $this->model->obtenerConfiguracion();
                $datos = $this->obtenerDatosCompletos($config);
                $datos['clima_ciudad'] = $ciudad;
                $this->model->guardarConfiguracion($datos);
            }
            header('Location: index.php?action=editar_dashboard_cliente&msg=guardado_clima');
            exit();
        }
    }

    public function guardarMapa() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lat = $_POST['mapa_latitud'] ?? '';
            $lng = $_POST['mapa_longitud'] ?? '';
            if ($lat !== '' && $lng !== '') {
                $config = $this->model->obtenerConfiguracion();
                $datos = $this->obtenerDatosCompletos($config);
                $datos['mapa_latitud'] = $lat;
                $datos['mapa_longitud'] = $lng;
                $this->model->guardarConfiguracion($datos);
            }
            header('Location: index.php?action=editar_dashboard_cliente&msg=guardado_mapa');
            exit();
        }
    }

    public function guardarVideo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            $carpetaDestino = 'public/videos/';
            if (!is_dir($carpetaDestino)) mkdir($carpetaDestino, 0755, true);

            $nombreArchivo = basename($_FILES['video']['name']);
            $rutaDestino = $carpetaDestino . $nombreArchivo;
            $ext = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

            if ($ext !== 'mp4') {
                header('Location: index.php?action=editar_dashboard_cliente&msg=error_video');
                exit();
            }

            if (move_uploaded_file($_FILES['video']['tmp_name'], $rutaDestino)) {
                $config = $this->model->obtenerConfiguracion();
                $datos = $this->obtenerDatosCompletos($config);
                $datos['video_url'] = $rutaDestino;
                $this->model->guardarConfiguracion($datos);

                header('Location: index.php?action=editar_dashboard_cliente&msg=guardado_video');
                exit();
            }
        }

        header('Location: index.php?action=editar_dashboard_cliente&msg=error_video');
        exit();
    }

    public function guardarGaleria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['imagenes']['name'][0])) {
            $carpetaDestino = 'public/img_clientes/';
            if (!is_dir($carpetaDestino)) mkdir($carpetaDestino, 0755, true);

            foreach ($_FILES['imagenes']['tmp_name'] as $index => $tmpName) {
                $nombreArchivo = basename($_FILES['imagenes']['name'][$index]);
                $rutaDestino = $carpetaDestino . $nombreArchivo;
                $ext = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) continue;

                if (move_uploaded_file($tmpName, $rutaDestino)) {
                    $this->galeriaModel->agregar($rutaDestino);
                }
            }

            header('Location: index.php?action=editar_dashboard_cliente&msg=guardado_galeria');
            exit();
        }

        header('Location: index.php?action=editar_dashboard_cliente&msg=error_galeria');
        exit();
    }
    public function eliminarVideo() {
        // Obtener configuración actual
        $config = $this->model->obtenerConfiguracion();

        // Verificar si existe el archivo y eliminarlo
        if (!empty($config['video_url']) && file_exists($config['video_url'])) {
            unlink($config['video_url']);
        }

        // Actualizar configuración quitando el video
        $datos = $this->obtenerDatosCompletos($config);
        $datos['video_url'] = '';
        $this->model->guardarConfiguracion($datos);

        header('Location: index.php?action=editar_dashboard_cliente&msg=video_eliminado');
        exit();
    }

    public function eliminarImagen() {
        if (isset($_GET['id'])) {
            // Primero obtener info de la imagen para eliminar archivo físico
            $imagen = $this->galeriaModel->obtenerPorId($_GET['id']);
            if ($imagen && file_exists($imagen['ruta'])) {
                unlink($imagen['ruta']);
            }

            // Luego eliminar el registro en base de datos
            $this->galeriaModel->eliminar($_GET['id']);
        }
        header('Location: index.php?action=editar_dashboard_cliente&msg=imagen_eliminada');
        exit();
    }
    public function eliminarFondo() {
    if (isset($_GET['vista'])) {
        require_once RUTA_BASE .'models/Configuracion.php';
        $conf = new Configuracion();
        $conf->eliminarFondo($_GET['vista']);
    }

   // Redirige nuevamente a la vista de configuración de fondos
    header('Location: index.php?action=configuracion&msg=fondo_eliminado');
    exit();
}


    
}

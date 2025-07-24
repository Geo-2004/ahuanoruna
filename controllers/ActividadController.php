<?php
require_once RUTA_BASE .'/models/actividad.php';
class ActividadController {
    public function listar() {
        $actividad = new Actividad();
        $actividades = $actividad->obtenerTodas();
        include RUTA_BASE .'/views/actividades.php';
    }

    public function adminListar() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
        echo "Acceso denegado.";
        return;
    }

    require_once RUTA_BASE .'/models/actividad.php';
    $actividadModel = new Actividad();
    $actividades = $actividadModel->obtenerTodas();

    $contenido = __DIR__ . '/../views/admin_actividades.php';
    include __DIR__ . '/../views/admin_layout.php';
 }


  public function crear() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actividad = new Actividad();

        $rutaImagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombre = basename($_FILES['imagen']['name']);
            $rutaDestino = 'public/images/actividades/' . $nombre;
            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
            $rutaImagen = $rutaDestino;
        }

        $actividad->crear(
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['descripcion_larga'],
            $_POST['precio'],
            $_POST['duracion'],
            $_POST['estado'],
            $rutaImagen
        );

        header('Location: index.php?action=gestionar_actividades');
        exit();
    } else {
        $contenido = 'views/form_crear_actividad.php'; // ✅ Contenido a mostrar dentro del layout
        require RUTA_BASE .'/views/admin_layout.php';     // ✅ Layout general
    }
    // Dentro del método crear() del controlador:
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // proceso POST...
 } else {
    include RUTA_BASE .'/views/form_crear_actividad.php';
 }

 }


    public function editar() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
     }

     $actividad = new Actividad();

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ruta por defecto: la imagen anterior
        $rutaImagen = $_POST['imagen_actual'];

        // Si se sube una nueva imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombre = basename($_FILES['imagen']['name']);
            $rutaDestino = 'public/images/actividades/' . $nombre;
            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
            $rutaImagen = $rutaDestino;
        }

        $actividad->actualizar(
            $_POST['id'],
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['precio'],
            $_POST['duracion'],
            $_POST['estado'],
            $rutaImagen
        );

        header('Location: index.php?action=gestionar_actividades');
     } else {
       $datos = $actividad->obtenerPorId($_GET['id']);
      $actividad = $datos; }
      $contenido = 'views/form_editar_actividades.php'; // Vista parcial (solo el formulario)
        include RUTA_BASE .'/views/admin_layout.php';  // Plantilla completa del panel admin
    }

    



    public function eliminar() {
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
        $actividad = new Actividad();
        $actividad->eliminar($_GET['id']);
        header('Location: index.php?action=gestionar_actividades');
    }
}

?>
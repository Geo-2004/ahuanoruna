<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class UsuarioController {
    public $modeloUsuario;

    public function __construct() {
        require_once RUTA_BASE . '/models/Usuario.php';
        $this->modeloUsuario = new Usuario();
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();
            $usuario->registrar(
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['cedula'],
                $_POST['correo'],
                $_POST['telefono'],
                $_POST['contrasena']
            );
            header('Location: index.php?action=login');
        } else {
            include __DIR__ . '/../views/registro.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();
            $datos = $usuario->login($_POST['correo'], $_POST['contrasena']); 
            if ($datos) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['usuario'] = $datos;

                if ($datos['rol'] === 'admin') {
                    header('Location: index.php?action=admin_dashboard');
                } else {
                    header('Location: index.php?action=dashboard_cliente');
                }
            } else {
                echo "Correo o contraseña incorrectos";
            }
        } else {
            include RUTA_BASE .'/views/login.php';
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: index.php?action=inicio');
        exit();
    }

    public function listarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            return;
        }

        $usuarioModel = new Usuario();

        if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $usuarios = $usuarioModel->buscarPorNombreOCedula($_GET['busqueda']);
        } else {
            $usuarios = $usuarioModel->obtenerTodos();
        }

        $contenido = __DIR__ . '/../views/admin_usuario.php';
        include __DIR__ . '/../views/admin_layout.php';
    }

    public function editarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $usuario = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->actualizar(
                $_POST['id'],
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['cedula'],
                $_POST['correo'],
                $_POST['telefono'],
                $_POST['rol'],
                $_POST['estado']
            );
            header('Location: index.php?action=gestionar_usuarios');
        } else {
            $datos = $usuario->obtenerPorId($_GET['id']);
            $contenido = __DIR__ . '/../views/form_editar_usuario.php';
            include __DIR__ . '/../views/admin_layout.php';
        }
    }

    public function eliminarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $usuario = new Usuario();
        $usuario->eliminar($_GET['id']);
        header('Location: index.php?action=gestionar_usuarios');
    }

    public function verPerfilAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            return;
        }

        $usuario = new Usuario();
        $datos = $usuario->obtenerPorId($_SESSION['usuario']['id_usuario']);
        $contenido = __DIR__ . '/../views/perfil_admin.php';
        include __DIR__ . '/../views/admin_layout.php';
    }

    public function recuperar_enviar() {
        $correo = $_POST['correo'] ?? '';
        if (empty($correo)) {
            include 'views/recuperar.php';
            return;
        }

        $usuario = $this->modeloUsuario->buscarPorCorreo($correo);
        if (!$usuario) {
            $mensaje = "No existe una cuenta con ese correo.";
            include 'views/recuperar.php';
            return;
        }

        $token = bin2hex(random_bytes(32));
        $this->modeloUsuario->guardarTokenRecuperacion($usuario['id_usuario'], $token);

        $enlace = "localhost:8080/public_html/index.php?action=recuperar_form&token=$token";
        $asunto = "Recuperación de contraseña";
        $mensajeCorreo = "Hola, para recuperar tu contraseña haz clic en el siguiente enlace:\n$enlace";

        // --- INTEGRACIÓN PHPMailer ---
        require_once __DIR__ . '/../vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Cambia por tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'rikimamallacta5@gmail.com'; // Tu correo
            $mail->Password = 'pwhe ohom kigl oiag'; // Tu contraseña o app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('rikimamallacta5@gmail.com', 'Ahuanoruna');
            $mail->addAddress($correo);
            $mail->Subject = $asunto;
            $mail->Body = $mensajeCorreo;

            $mail->send();
            $mensaje = "Te hemos enviado instrucciones a tu correo.";
        } catch (Exception $e) {
            $mensaje = "No se pudo enviar el correo: {$mail->ErrorInfo}";
        }
        // --- FIN PHPMailer ---

        include 'views/recuperar.php';
    }

    public function recuperar_cambiar() {
        $token = $_POST['token'] ?? '';
        $nueva = $_POST['nueva_contrasena'] ?? '';
        $confirmar = $_POST['confirmar_contrasena'] ?? '';

        if (empty($token) || empty($nueva) || empty($confirmar)) {
            $mensaje = "Completa todos los campos.";
            include 'views/recuperar_form.php';
            return;
        }

        if ($nueva !== $confirmar) {
            $mensaje = "Las contraseñas no coinciden.";
            include 'views/recuperar_form.php';
            return;
        }

        // Buscar usuario por token
        $usuario = $this->modeloUsuario->buscarPorToken($token);
        if (!$usuario) {
            $mensaje = "Token inválido o expirado.";
            include 'views/recuperar_form.php';
            return;
        }

        // Actualizar contraseña y eliminar token
        $this->modeloUsuario->actualizarContrasena($usuario['id_usuario'], $nueva);
        $this->modeloUsuario->eliminarTokenRecuperacion($usuario['id_usuario']);

        $mensaje = "Contraseña actualizada correctamente. Ahora puedes iniciar sesión.";
        include 'views/login.php';
    }
}
?>

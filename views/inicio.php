<?php
require_once RUTA_BASE .'/models/actividad.php';
require_once RUTA_BASE .'/models/configuracion.php';

$config = new Configuracion();
$fondo = $config->obtenerFondo('inicio');

$actividadModel = new Actividad();
$actividades = $actividadModel->obtenerTodas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ IMPORTANTE -->
  <title>Inicio - Ahuanoruna</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="public/css/inicio.css">
  <style>
    body.inicio-body {
      background-image: url('<?= $fondo ?>');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
  </style>
</head>

<body class="inicio-body">
  <header class="encabezado">
    <div class="logo">
      <img src="public/images/logo.png" alt="Ahuanoruna">
      <span>Ahuanoruna</span>
    </div>
    <nav class="menu">
      <a href="#actividades">Actividades</a>
      <a href="#contacto">Contacto</a>
      <a href="index.php?action=login">Iniciar sesión</a>
    </nav>
  </header>

  <section class="encabezado-banner">
    <div class="banner-overlay"></div>
    <img src="public/images/imagentipo.png" alt="Banner de turismo">
    <div class="texto-banner">
      <h1>AHUANORUNA</h1>
      <p>Turismo natural y aventura en la Amazonía</p>
    </div>
  </section>

  <main class="container" id="actividades">
    <h2>Paquetes Disponibles</h2>
    <div class="grid-actividades">
      <?php if (!empty($actividades)): ?>
        <?php foreach ($actividades as $actividad): ?>
          <div class="card-actividad fade-in">
            <img src="<?= $actividad['imagen'] ?>" alt="Imagen de <?= $actividad['nombre'] ?>">
            <h3><?= $actividad['nombre'] ?></h3>
            <p><?= $actividad['descripcion'] ?></p>
            <p>
              <i class="fas fa-dollar-sign"></i> $<?= $actividad['precio'] ?> -
              <i class="fas fa-clock"></i> <?= $actividad['duracion'] ?> 
            </p>
            <a href="index.php?action=ver_actividad&id=<?= $actividad['id_actividad'] ?>" class="boton-turistico">Reservar</a>
            <a href="index.php?action=detalle_actividad&id=<?= $actividad['id_actividad'] ?>" class="boton">Ver más</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="mensaje">No hay actividades disponibles en este momento.</p>
      <?php endif; ?>
    </div>
  </main>

  <?php
  require_once RUTA_BASE .'/models/Footer.php';
  $footer = new Footer();
  $info = $footer->obtener();
  ?>

  <footer class="footer-turistico" id="contacto">
    <div class="footer-contenido">
      <p><strong>Contacto:</strong></p>
      <p><i class="fas fa-phone"></i> <?= $info['telefono'] ?></p>
      <p><i class="fas fa-envelope"></i> <?= $info['correo'] ?></p>
      <p><i class="fas fa-map-marker-alt"></i> <?= $info['direccion'] ?></p>

      <div class="footer-redes">
        <a href="<?= $info['facebook'] ?>"><i class="fab fa-facebook-f"></i></a>
        <a href="<?= $info['instagram'] ?>"><i class="fab fa-instagram"></i></a>
        <a href="<?= $info['whatsapp'] ?>"><i class="fab fa-whatsapp"></i></a>
      </div>

      <p class="footer-copy">© 2025 Ahuanoruna. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script>
    const elementos = document.querySelectorAll('.fade-in');
    const mostrarElemento = () => {
      elementos.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight - 50) {
          el.classList.add('visible');
        }
      });
    };
    window.addEventListener('scroll', mostrarElemento);
    window.addEventListener('load', mostrarElemento);
  </script>
</body>
</html>

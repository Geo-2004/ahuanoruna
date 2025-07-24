<?php  
require_once RUTA_BASE .'/models/ConfiguracionDashboard.php';  
require_once RUTA_BASE .'/models/GaleriaDashboard.php';  
require_once RUTA_BASE .'/models/configuracion.php';  

if (session_status() === PHP_SESSION_NONE) session_start();  

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
    header('Location: index.php?action=login');
    exit();  
}  

$confDash = new ConfiguracionDashboard();  
$configDashboard = $confDash->obtenerConfiguracion();  

$galeriaModel = new GaleriaDashboard();  
$imagenesGaleria = $galeriaModel->obtenerTodas();  

$config = new Configuracion();  
$fondo = $config->obtenerFondo('dashboard_cliente');  

$bienvenidaTitulo = $configDashboard['bienvenida_titulo'] ?? 'Bienvenido';  
$bienvenidaTexto = $configDashboard['bienvenida_texto'] ?? 'Explora experiencias únicas en turismo natural. Reserva y disfruta.';  
$videoUrl = $configDashboard['video_url'] ?? 'public/videos/ahuano-video.mp4';  
$climaCiudad = $configDashboard['clima_ciudad'] ?? 'Ahuano,EC';  
$mapaLatitud = floatval($configDashboard['mapa_latitud'] ?? -1.0577915);  
$mapaLongitud = floatval($configDashboard['mapa_longitud'] ?? -77.5640581);  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel del Cliente – Ahuanoruna</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/cliente_dashboard.css" />
    <style>
        body {
            background-image: url('<?= htmlspecialchars($fondo) ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    <!-- Fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <!-- Leaflet para mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
</head>
<body>
<header class="header-cliente sombra">
    <h1 class="logo-cliente">🌿 Ahuanoruna</h1>
    <nav class="menu-cliente">
        <a href="index.php?action=actividades">Actividades</a>
        <a href="index.php?action=mis_reservas">Mis Reservas</a>
        <a href="index.php?action=mis_facturas">Mis Facturas</a>
        <a href="index.php?action=logout" class="cerrar-sesion">Cerrar Sesión</a>
    </nav>
</header>

<main class="dashboard-cliente">
    <section class="contenido-cliente tarjeta">
        <h2><?= htmlspecialchars($bienvenidaTitulo) ?> 👋</h2>
        <p><?= nl2br(htmlspecialchars($bienvenidaTexto)) ?></p>
    </section>

    <section class="widget-clima tarjeta">
        <h3>Clima en <?= htmlspecialchars($climaCiudad) ?></h3>
        <div class="clima-info">
            <p id="temperatura">Cargando temperatura...</p>
            <p id="descripcion">Cargando descripción...</p>
        </div>
        <div id="mapa"></div>
        <div id="instrucciones-ruta"></div>
    </section>

    <section class="galeria-video-section tarjeta">
        <h3>Descubre Ahuano en imágenes y video</h3>
        <video controls muted loop playsinline class="video-turismo">
            <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/mp4" />
            Tu navegador no soporta video HTML5.
        </video>
        <div class="galeria-imagenes">
            <?php foreach ($imagenesGaleria as $img): ?>
                <img src="<?= htmlspecialchars($img['url']) ?>" alt="Imagen de galería" />
            <?php endforeach; ?>
        </div>
    </section>
</main>

<!-- Modal imagen -->
<div id="modal-imagen" class="modal-imagen" role="dialog" aria-modal="true">
    <span class="cerrar-modal" aria-label="Cerrar">&times;</span>
    <img class="contenido-modal" id="imagen-ampliada" src="" alt="Imagen ampliada" />
</div>

<script>
    const apiKey = 'ca0b002a8524245fed3306f8ae508fc1';
    const ciudad = '<?= htmlspecialchars(urlencode($climaCiudad)) ?>';
    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${ciudad}&units=metric&lang=es&appid=${apiKey}`)
        .then(res => res.json())
        .then(data => {
            if (data?.main && data?.weather) {
                document.getElementById('temperatura').textContent = `${data.main.temp}°C (sensación ${data.main.feels_like}°C)`;
                document.getElementById('descripcion').textContent = data.weather[0].description;
            }
        })
        .catch(() => {
            document.getElementById('descripcion').textContent = 'No se pudo obtener el clima.';
        });

    const destinoLatLng = [<?= $mapaLatitud ?>, <?= $mapaLongitud ?>];
    const mapa = L.map('mapa').setView(destinoLatLng, 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(mapa);
    L.marker(destinoLatLng).addTo(mapa).bindPopup('🌿 Destino: Ahuanoruna').openPopup();

    const controlRutas = L.Routing.control({
        waypoints: [],
        routeWhileDragging: true,
        container: document.getElementById('instrucciones-ruta'),
        createMarker: (i, waypoint, n) => {
            return L.marker(waypoint.latLng, {
                title: i === n - 1 ? "Destino: Ahuanoruna" : "Ubicación actual"
            });
        }
    }).addTo(mapa);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            const origen = L.latLng(pos.coords.latitude, pos.coords.longitude);
            controlRutas.setWaypoints([origen, destinoLatLng]);
            mapa.setView(origen, 14);
        }, () => {
            controlRutas.setWaypoints([destinoLatLng, destinoLatLng]);
        });
    }

    const modal = document.getElementById('modal-imagen');
    const imagenModal = document.getElementById('imagen-ampliada');
    document.querySelectorAll('.galeria-imagenes img').forEach(img => {
        img.addEventListener('click', () => {
            modal.style.display = 'flex';
            imagenModal.src = img.src;
        });
    });
    document.querySelector('.cerrar-modal').addEventListener('click', () => {
        modal.style.display = 'none';
        imagenModal.src = '';
    });
    window.addEventListener('click', e => {
        if (e.target === modal) {
            modal.style.display = 'none';
            imagenModal.src = '';
        }
    });
</script>
</body>
</html>

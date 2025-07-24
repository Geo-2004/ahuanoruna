<link rel="stylesheet" href="public/css/configuracion_fondos.css">

<h1>Configuración de Fondos de Interfaz</h1>

<?php
require_once RUTA_BASE .'/models/configuracion.php';
$config = new Configuracion();

// Define las vistas que vas a administrar
$vistas = [
    'dashboard_cliente' => 'Dashboard Cliente',
    'actividades' => 'Actividades',
    'login' => 'Login',
    'admin_dashboard' => 'Admin Inicio'
];
?>

<div class="formularios-flex">
    <?php foreach ($vistas as $claveVista => $titulo): 
        $rutaFondo = $config->obtenerFondo($claveVista);
    ?>
        <div class="form-fondo">
            <h2><?= htmlspecialchars($titulo) ?></h2>

            <!-- Imagen actual -->
            <?php if ($rutaFondo && file_exists($rutaFondo)): ?>
                <img src="<?= $rutaFondo ?>" alt="Fondo de <?= $titulo ?>" style="width:100%; max-height:200px; object-fit:cover; margin-bottom:10px; border:1px solid #ccc;">
                <a href="index.php?action=eliminar_fondo&vista=<?= $claveVista ?>" onclick="return confirm('¿Eliminar fondo actual de <?= $titulo ?>?')" class="btn btn-danger" style="display:inline-block; margin-bottom:10px;">🗑 Eliminar fondo</a>
            <?php else: ?>
                <p style="color: #888;">No hay fondo actual.</p>
            <?php endif; ?>

            <!-- Formulario para subir nuevo fondo -->
            <form action="index.php?action=subir_fondo" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="vista" value="<?= $claveVista ?>">
                <input type="file" name="fondo" accept="image/*" required style="margin-bottom: 10px;">
                <button type="submit">Subir</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

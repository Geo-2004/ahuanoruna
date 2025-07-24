<?php
require_once RUTA_BASE .'/models/configuracion.php';
$config = new Configuracion();
$fondo = $config->obtenerFondo('admin_cuentas');
?>

<link rel="stylesheet" href="public/css/admin_cuentas.css">

<div class="contenedor-cuentas" style="background-image: url('<?= $fondo ?>'); background-size: cover; background-repeat: no-repeat;">
    <h2>Cuentas Bancarias para Transferencias</h2>
    <a href="index.php?action=crear_cuenta" class="boton">+ Nueva Cuenta</a>

    <table>
        <thead>
            <tr>
                <th>Banco</th>
                <th>Número</th>
                <th>Tipo</th>
                <th>Titular</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuentas as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['banco']) ?></td>
                <td><?= htmlspecialchars($c['numero_cuenta']) ?></td>
                <td><?= htmlspecialchars($c['tipo_cuenta']) ?></td>
                <td><?= htmlspecialchars($c['nombre_titular']) ?></td>
                <td><?= ucfirst(htmlspecialchars($c['estado'])) ?></td>
                <td>
                    <a href="index.php?action=editar_cuenta&id=<?= $c['id_cuenta'] ?>">Editar</a> |
                    <a href="index.php?action=eliminar_cuenta&id=<?= $c['id_cuenta'] ?>" onclick="return confirm('¿Eliminar cuenta?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagos registrados</title>
</head>
<body>
    <h2>Pagos Realizados</h2>
    <table border="1">
        <tr>
            <th>Usuario</th>
            <th>Actividad</th>
            <th>Monto</th>
            <th>Método</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($pagos as $p): ?>
        <tr>
            <td><?= $p['nombres'] . ' ' . $p['apellidos'] ?></td>
            <td><?= $p['actividad'] ?></td>
            <td>$<?= $p['monto_total'] ?></td>
            <td><?= $p['metodo_pago'] ?></td>
            <td><?= $p['fecha_pago'] ?></td>
            <td>
                <!-- Puedes agregar edición después -->
                <a href="index.php?action=eliminar_pago&id=<?= $p['id_pago'] ?>" onclick="return confirm('¿Eliminar este pago?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

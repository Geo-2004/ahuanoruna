<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva</title>
</head>
<body>
    <h2>Editar Reserva</h2>
    <form action="index.php?action=editar_reserva" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($datos['id_reserva']) ?>">

        <label>Fecha de la actividad:</label>
        <input type="date" name="fecha_actividad" value="<?= htmlspecialchars($datos['fecha_actividad']) ?>" required><br><br>

        <label>Cantidad de personas:</label>
        <input type="number" name="cantidad_personas" value="<?= htmlspecialchars($datos['cantidad_personas']) ?>" required><br><br>

        <label>Estado reserva:</label>
        <select name="estado_reserva" required>
            <option value="pendiente" <?= $datos['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="confirmada" <?= $datos['estado'] == 'confirmada' ? 'selected' : '' ?>>Confirmada</option>
            <option value="cancelada" <?= $datos['estado'] == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
        </select><br><br>

        <label>Estado pago:</label>
        <select name="estado_pago" required>
            <option value="pendiente" <?= (isset($datosPago['estado']) && $datosPago['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
            <option value="confirmado" <?= (isset($datosPago['estado']) && $datosPago['estado'] == 'confirmado') ? 'selected' : '' ?>>Confirmado</option>
            <option value="rechazado" <?= (isset($datosPago['estado']) && $datosPago['estado'] == 'rechazado') ? 'selected' : '' ?>>Rechazado</option>
        </select><br><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>

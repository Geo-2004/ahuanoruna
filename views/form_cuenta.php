<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($datos) ? 'Editar Cuenta' : 'Nueva Cuenta' ?></title>
    <link rel="stylesheet" href="public/css/admin_cuentas.css">
</head>
<body>
    <div class="formulario-cuenta">
        <h2><?= isset($datos) ? 'Editar Cuenta Bancaria' : 'Registrar Nueva Cuenta' ?></h2>

        <form action="index.php?action=<?= isset($datos) ? 'editar_cuenta' : 'crear_cuenta' ?>" method="POST">
            <?php if (isset($datos)): ?>
                <input type="hidden" name="id" value="<?= $datos['id_cuenta'] ?>">
            <?php endif; ?>

            <label>Banco:</label>
            <input type="text" name="banco" value="<?= $datos['banco'] ?? '' ?>" required>

            <label>Número de Cuenta:</label>
            <input type="text" name="numero_cuenta" value="<?= $datos['numero_cuenta'] ?? '' ?>" required>

            <label>Tipo de Cuenta:</label>
            <input type="text" name="tipo_cuenta" value="<?= $datos['tipo_cuenta'] ?? 'Ahorros' ?>" required>

            <label>Nombre del Titular:</label>
            <input type="text" name="nombre_titular" value="<?= $datos['nombre_titular'] ?? '' ?>" required>

            <label>Estado:</label>
            <select name="estado">
                <option value="activa" <?= (isset($datos) && $datos['estado'] === 'activa') ? 'selected' : '' ?>>Activa</option>
                <option value="inactiva" <?= (isset($datos) && $datos['estado'] === 'inactiva') ? 'selected' : '' ?>>Inactiva</option>
            </select>

            <button type="submit"><?= isset($datos) ? 'Actualizar' : 'Guardar' ?></button>
        </form>
    </div>
</body>
</html>
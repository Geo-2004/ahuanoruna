<h2 class="titulo-seccion">Editar Usuario</h2>

<form id="form-editar-usuario" method="POST" action="index.php?action=editar_usuario" class="formulario">
    <input type="hidden" name="id" value="<?= htmlspecialchars($datos['id_usuario']) ?>">

    <div class="form-grid">
        <div>
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" value="<?= htmlspecialchars($datos['nombres']) ?>" required>
        </div>
        <div>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($datos['apellidos']) ?>" required>
        </div>
        <div>
            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" value="<?= htmlspecialchars($datos['cedula'] ?? '') ?>" required>
        </div>
        <div>
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($datos['correo']) ?>" required>
        </div>
        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($datos['telefono']) ?>" required>
        </div>
        <div>
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="cliente" <?= $datos['rol'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                <option value="admin" <?= $datos['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
        </div>
        <div>
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="activo" <?= $datos['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                <option value="inactivo" <?= $datos['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
    </div>

    <button type="submit" class="btn">Guardar cambios</button>
</form>

<script>
document.getElementById('form-editar-usuario').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(resp => resp.text())
    .then(html => {
        fetch('index.php?action=gestionar_usuarios')
            .then(res => res.text())
            .then(html => {
                document.getElementById('content-area').innerHTML = html;
            });
    })
    .catch(error => console.error('Error al guardar:', error));
});
</script>

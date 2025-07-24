<h2 class="titulo-seccion">Usuarios Registrados</h2>

<div class="contenedor-usuarios">
    <form method="GET" action="index.php" class="form-busqueda">
        <input type="hidden" name="action" value="gestionar_usuarios">
        <input type="text" name="busqueda" placeholder="Buscar por nombre, apellido o cédula" value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>" class="input-busqueda">
        <button type="submit" class="btn-buscar"><span class="icon-search">🔍</span> Buscar</button>
        <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] !== ''): ?>
            <a href="index.php?action=gestionar_usuarios" class="btn-ver-todos">Ver todos</a>
        <?php endif; ?>
    </form>

    <div class="tabla-responsive">
        <table class="tabla-usuarios">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Cédula</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['nombres'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['apellidos'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['cedula'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['correo'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['telefono'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['rol'] ?? '') ?></td>
                        <td>
                            <span class="estado-usuario <?= $u['estado'] == 'activo' ? 'activo' : 'inactivo' ?>">
                                <?= htmlspecialchars($u['estado'] ?? '') ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?action=editar_usuario&id=<?= $u['id_usuario'] ?? '' ?>" class="btn-accion" title="Editar usuario">✏️</a>
                            <a href="index.php?action=eliminar_usuario&id=<?= $u['id_usuario'] ?? '' ?>" class="btn-accion btn-eliminar" title="Eliminar usuario" onclick="return confirm('¿Eliminar este usuario?')">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="sin-usuarios">No se encontraron usuarios.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

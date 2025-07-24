    <h2>Actividades Registradas</h2>
    <a href="index.php?action=crear_actividad" class="boton-turistico">+ Nueva Actividad</a>

    <?php if (!empty($actividades)): ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Duración</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($actividades as $act): ?>
                    <tr>
                        <td><?= htmlspecialchars($act['nombre']) ?></td>
                        <td><?= htmlspecialchars($act['descripcion']) ?></td>
                        <td>$<?= number_format($act['precio'], 2) ?></td>
                        <td><?= htmlspecialchars($act['duracion']) ?> </td>
                        <td><?= ucfirst(htmlspecialchars($act['estado'])) ?></td>
                        <td><img src="<?= htmlspecialchars($act['imagen']) ?>" class="img-miniatura" alt="imagen"></td>
                        <td>
                            <a href="index.php?action=editar_actividad&id=<?= $act['id_actividad'] ?>" class="btn-editar">Editar</a>
                            <a href="index.php?action=eliminar_actividad&id=<?= $act['id_actividad'] ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar esta actividad?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-actividades">No hay actividades registradas.</p>
    <?php endif; ?>
</div>

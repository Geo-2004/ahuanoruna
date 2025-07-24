    <h2>Reservas Registradas</h2>

    <table class="tabla">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Actividad</th>
                <th>Fecha</th>
                <th>Personas</th>
                <th>Estado</th>
                <th>Comprobante</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['nombres'] . ' ' . $r['apellidos']) ?></td>
                    <td><?= htmlspecialchars($r['actividad']) ?></td>
                    <td><?= htmlspecialchars($r['fecha_actividad']) ?></td>
                    <td><?= htmlspecialchars($r['cantidad_personas']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($r['estado'])) ?></td>
                    <td><?= $r['numero_comprobante'] ?? 'No enviado' ?></td>
                    <td>
                        <?php if (!empty($r['imagen_comprobante'])): ?>
                            <a href="<?= htmlspecialchars($r['imagen_comprobante']) ?>" target="_blank">Ver imagen</a>
                        <?php else: ?>
                            No hay imagen
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="index.php?action=editar_reserva&id=<?= $r['id_reserva'] ?>" class="btn-editar">Editar</a>
                        <a href="index.php?action=eliminar_reserva&id=<?= $r['id_reserva'] ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar esta reserva?')">Eliminar</a>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

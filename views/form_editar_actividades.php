
    <h2>Editar Actividad</h2>
    <form action="index.php?action=editar_actividad" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $actividad['id_actividad'] ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $actividad['nombre'] ?>" required>

        <label>Descripción corta:</label>
        <textarea name="descripcion" required><?= $actividad['descripcion'] ?></textarea>

        <label>Descripción larga:</label>
        <textarea name="descripcion_larga" required><?= $actividad['descripcion_larga'] ?></textarea>

        <label>Precio:</label>
        <input type="number" name="precio" value="<?= $actividad['precio'] ?>" step="0.01" required>

        <label>Duración (en horas):</label>
        <input type="text" name="duracion" value="<?= $actividad['duracion'] ?>" required>

        <label>Estado:</label>
        <select name="estado">
            <option value="disponible" <?= $actividad['estado'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
            <option value="no disponible" <?= $actividad['estado'] == 'no disponible' ? 'selected' : '' ?>>No disponible</option>
        </select>

        <label>Imagen actual:</label><br>
        <?php if (!empty($actividad['imagen'])): ?>
            <img src="<?= $actividad['imagen'] ?>" alt="Imagen actual" class="imagen-actual">
        <?php endif; ?>
        <input type="hidden" name="imagen_actual" value="<?= $actividad['imagen'] ?>">

        <label>Nueva imagen (opcional):</label>
        <input type="file" name="imagen" accept="image/*">

        <button type="submit">Actualizar</button>
    </form>
</div>

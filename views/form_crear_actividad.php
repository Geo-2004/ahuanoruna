<h2>Crear Nueva Actividad</h2>

<form action="index.php?action=crear_actividad" method="POST" enctype="multipart/form-data">
    <label>Nombre:</label>
    <input type="text" name="nombre" required><br><br>

    <label>Descripción corta:</label>
    <textarea name="descripcion" required></textarea><br><br>

    <label>Descripción larga:</label>
    <textarea name="descripcion_larga" required></textarea><br><br>

    <label>Precio:</label>
    <input type="number" name="precio" step="0.01" required><br><br>

    <label>Duración (horas):</label>
    <input type="text" name="duracion" required><br><br>

    <label>Estado:</label>
    <select name="estado" required>
        <option value="disponible">Disponible</option>
        <option value="no disponible">No disponible</option>
    </select><br><br>

    <label>Imagen principal:</label>
    <input type="file" name="imagen" accept="image/*" required><br><br>

    <button type="submit" class="boton-turistico">Crear Actividad</button>
</form>

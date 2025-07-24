<h2>Configuración del pie de página</h2>

<form action="index.php?action=guardar_footer" method="POST">
    <label>Teléfono:</label>
    <input type="text" name="telefono" value="<?= $datos['telefono'] ?>"><br><br>

    <label>Correo:</label>
    <input type="email" name="correo" value="<?= $datos['correo'] ?>"><br><br>

    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?= $datos['direccion'] ?>"><br><br>

    <label>Facebook:</label>
    <input type="text" name="facebook" value="<?= $datos['facebook'] ?>"><br><br>

    <label>Instagram:</label>
    <input type="text" name="instagram" value="<?= $datos['instagram'] ?>"><br><br>

    <label>WhatsApp:</label>
    <input type="text" name="whatsapp" value="<?= $datos['whatsapp'] ?>"><br><br>

    <button type="submit">Guardar cambios</button>
</form>

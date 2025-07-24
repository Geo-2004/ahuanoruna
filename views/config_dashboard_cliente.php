<form method="POST" action="index.php?action=guardar_dashboard_cliente" enctype="multipart/form-data" class="form-dashboard">

    <fieldset>
        <legend>Bienvenida</legend>
        <label>Título:</label>
        <input type="text" name="bienvenida_titulo" value="<?= htmlspecialchars($conf['bienvenida_titulo'] ?? '') ?>">
        
        <label>Texto:</label>
        <textarea name="bienvenida_texto"><?= htmlspecialchars($conf['bienvenida_texto'] ?? '') ?></textarea>
    </fieldset>

    <fieldset>
        <legend>Clima</legend>
        <label>Ciudad:</label>
        <input type="text" name="clima_ciudad" value="<?= htmlspecialchars($conf['clima_ciudad'] ?? '') ?>">
    </fieldset>

    <fieldset>
        <legend>Mapa</legend>
        <label>Latitud:</label>
        <input type="text" name="mapa_latitud" value="<?= htmlspecialchars($conf['mapa_latitud'] ?? '') ?>">

        <label>Longitud:</label>
        <input type="text" name="mapa_longitud" value="<?= htmlspecialchars($conf['mapa_longitud'] ?? '') ?>">
    </fieldset>

    <fieldset>
        <legend>Video</legend>
        <?php if (!empty($conf['video_url'])): ?>
            <video width="320" controls>
                <source src="<?= htmlspecialchars($conf['video_url']) ?>" type="video/mp4">
            </video><br>
            <a href="index.php?action=eliminarVideo">🗑 Eliminar video</a><br><br>
        <?php endif; ?>

        <label>Subir nuevo video (mp4):</label>
        <input type="file" name="video_file" accept="video/mp4">
    </fieldset>

    <fieldset>
        <legend>Galería de Imágenes</legend>
        <label>Subir imágenes:</label>
        <input type="file" name="imagenes_files[]" multiple accept="image/*">
        
        <div class="galeria-imagenes">
            <?php foreach ($imagenesGaleria as $imagen): ?>
                <div class="imagen-item">
                    <img src="<?= htmlspecialchars($imagen['url']) ?>" width="150">
                    <a href="index.php?action=eliminarImagen&id=<?= urlencode($imagen['id']) ?>">🗑 Eliminar</a>
                </div>
            <?php endforeach; ?>
        </div>
    </fieldset>

    <br>
    <button type="submit">💾 Guardar cambios</button>
</form>

<style>


.form-dashboard fieldset {
    border: 2px solid var(--clr-accent-light);
    border-radius: 12px;
    background: var(--clr-white);
    box-shadow: var(--shadow-sm);
    padding: 22px 18px;
    margin: 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px 32px;
    align-items: start;
}

.form-dashboard legend {
    grid-column: 1 / -1;
    color: var(--clr-accent-dark);
    font-weight: bold;
    font-size: 1.2rem;
    padding: 0 10px 10px 0;
    letter-spacing: 1px;
}

.form-dashboard label {
    margin-bottom: 6px;
    color: var(--clr-black);
    font-weight: 600;
    display: block;
}

.form-dashboard input[type="text"],
.form-dashboard input[type="file"],
.form-dashboard input[type="number"],
.form-dashboard textarea,
.form-dashboard select {
    width: 100%;
    padding: 0.7rem;
    border: 1.5px solid var(--clr-accent-light);
    border-radius: 8px;
    background: #f4fce3;
    font-size: 1rem;
    margin-bottom: 8px;
    transition: border 0.2s;
    box-sizing: border-box;
}

.form-dashboard textarea {
    min-height: 70px;
    resize: vertical;
    grid-column: 1 / -1; /* Ocupa ambas columnas si lo deseas */
}

.form-dashboard video,
.form-dashboard .galeria-imagenes {
    grid-column: 1 / -1;
}

.form-dashboard .galeria-imagenes {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    margin-top: 10px;
}

.form-dashboard .imagen-item {
    background: var(--clr-bg-dark);
    border-radius: 10px;
    box-shadow: var(--shadow-sm);
    padding: 10px;
    text-align: center;
    position: relative;
    min-width: 150px;
}

.form-dashboard .imagen-item img {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(56,142,60,0.08);
    margin-bottom: 6px;
    max-width: 100%;
    height: auto;
}

.form-dashboard .imagen-item a {
    color: var(--clr-danger);
    font-size: 1.1rem;
    text-decoration: none;
    display: inline-block;
    margin-top: 4px;
    transition: color 0.2s;
}

.form-dashboard .imagen-item a:hover {
    color: #b71c1c;
}

.form-dashboard button[type="submit"] {
    background: linear-gradient(90deg, var(--clr-accent-dark) 0%, var(--clr-accent) 100%);
    color: var(--clr-white);
    border: none;
    border-radius: 8px;
    padding: 0.9rem 1.7rem;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: var(--shadow-sm);
    transition: background 0.2s;
    margin-top: 18px;
    align-self: center;
}

.form-dashboard button[type="submit"]:hover {
    background: linear-gradient(90deg, var(--clr-accent) 0%, var(--clr-accent-dark) 100%);
}

@media (max-width: 900px) {
    .form-dashboard {
        padding: 18px 8px;
        max-width: 98vw;
    }
    .form-dashboard fieldset {
        grid-template-columns: 1fr;
        gap: 18px;
        padding: 12px 6px;
    }
    .form-dashboard .galeria-imagenes {
        gap: 10px;
    }
}
</style>

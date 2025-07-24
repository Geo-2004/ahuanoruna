
<div class="container">
    <h2>Restablecer Contraseña</h2>
    <form action="index.php?action=recuperar_cambiar" method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
        <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
        <input type="password" name="confirmar_contrasena" placeholder="Confirmar contraseña" required>
        <button type="submit">Cambiar contraseña</button>
    </form>
    <p>
        <a href="index.php?action=login">Volver al login</a>
    </p>
</div>
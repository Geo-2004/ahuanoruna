<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Establecer Límite de Reservas</title>
</head>
<body>
    <h2>Definir límite de reservas por día</h2>
    <form action="index.php?action=guardar_limite_reservas" method="POST">
        <label>Fecha:</label>
        <input type="date" name="fecha" required><br><br>

        <label>Cantidad máxima de reservas:</label>
        <input type="number" name="maximo" min="1" required><br><br>

        <button type="submit">Guardar Límite</button>
    </form>
</body>
</html>

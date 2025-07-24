<div style="display: flex; gap: 30px;">
  <!-- Formulario de reserva -->
  <div style="flex: 1;">
    <h2>Reservar Actividad</h2>
    <form id="formReservar">
      <input type="hidden" name="actividad_id" value="<?= $actividad_id ?>"> <!-- dinámico -->
      <label>Fecha:</label><br>
      <input type="date" name="fecha" required><br><br>
      <button type="submit">Reservar</button>
    </form>
  </div>

  <!-- Aquí se mostrará el formulario de pago -->
  <div style="flex: 1;" id="formularioPago">
    <!-- AJAX llenará esto -->
  </div>
</div>

<script>
document.getElementById('formReservar').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('index.php?action=reservar', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    document.getElementById('formularioPago').innerHTML = data;

    // Escuchar el formulario de pago cuando aparece
    document.getElementById('formPagar').addEventListener('submit', function(e) {
      e.preventDefault();
      const pagoData = new FormData(this);

      fetch('index.php?action=pagar', {
        method: 'POST',
        body: pagoData
      })
      .then(res => res.text())
      .then(resp => {
        alert("¡Pago enviado con éxito!");
        document.getElementById('formularioPago').innerHTML = '';
      })
      .catch(err => {
        alert("Error al enviar el pago.");
      });
    });
  })
  .catch(err => {
    alert("Error al hacer la reserva.");
  });
});
</script>

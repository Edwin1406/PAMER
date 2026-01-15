  <!-- NOMBRE DEL CLIENTE -->
  <div class="col-md-6 col-12">
      <div class="form-group">
          <label for="nombre_cliente">Nombre del Cliente</label>
          <input type="text" id="nombre_cliente" class="form-control"
              placeholder="Nombre del Cliente" name="nombre_cliente"
                 value="<?php echo isset($diseno) ? s($diseno->nombre_cliente) : ''; ?>">
      </div>
  </div>


  <!-- NOMBRE DEL PROVEEDOR -->

  <div class="col-md-6 col-12">
      <div class="form-group">
          <label for="proveedor">Nombre del Proveedor</label>
          <input type="text" id="proveedor" class="form-control"
              placeholder="Nombre del Proveedor" name="proveedor"
              value="<?php echo isset($diseno) ? s($diseno->proveedor) : ''; ?>">
      </div>
  </div>

  <!-- NOMBRE DEL PRODUCTO -->
  <div class="col-md-6 col-12">
      <div class="form-group">
          <label for="nombre_producto">Nombre del Producto</label>
          <input type="text" id="nombre_producto" class="form-control"
              placeholder="Nombre del Producto" name="nombre_producto"
              value="<?php echo isset($diseno) ? s($diseno->nombre_producto) : ''; ?>">
      </div>
  </div>

  <!-- COD. PRODUCTO -->

  <div class="col-md-6 col-12">
      <div class="form-group">
          <label for="codigo_producto">Código del Producto</label>
          <input type="text" id="codigo_producto" class="form-control"
              placeholder="Código del Producto" name="codigo_producto"
              value="<?php echo isset($diseno) ? s($diseno->codigo_producto) : ''; ?>">
      </div>
  </div>

  <!-- estado enviado,pausado,terminado-->
  <div class="col-md-6 col-12">
      <div class="form-group">
          <label for="estado">Estado</label>
          <select class="form-select" name="estado" id="estado">
              <option value="ARTE" <?php echo isset($diseno) && s($diseno->estado) === 'ARTE' ? 'selected' : ''; ?>>Arte</option>
              <option value="APROBADO" <?php echo isset($diseno) && s($diseno->estado) === 'APROBADO' ? 'selected' : ''; ?>>Aprobado</option>
              <option value="CLICHE" <?php echo isset($diseno) && s($diseno->estado) === 'CLICHE' ? 'selected' : ''; ?>>Cliché</option>
          </select>
      </div>
  </div>


  <div class="col-md-6 col-12">
      <div class="form-group">
          <label for="pdf">Subir PDF del diseño</label>
          <input type="file" class="form-control" id="pdf" name="pdf" accept="application/pdf">
          <small class="form-text text-muted">Solo se permiten archivos PDF.</small>
      </div>
  </div>
  <?php if (isset($diseno->pdf)) : ?>
      <div class="col-md-6 col-12">
          <div class="form-group">
              <label>Archivo actual:</label><br>
              <!-- eliminar espacio em blanco -->
              <a href="<?php echo $_ENV['HOST'] . '/src/visor/' . $diseno->pdf; ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                  Ver / Descargar PDF
              </a>
              <br><br>

              <?php if ($diseno->pdf): ?>
                  <div id="pdf-actual">
                      <p>PDF actual: <?php echo htmlspecialchars($diseno->pdf); ?> </p>
                      <a href="#"
                          id="btnEliminarPDF"
                          data-id="<?php echo $diseno->id; ?>"
                          class="btn btn-danger btn-sm">
                          Eliminar PDF
                      </a>
                  </div>
              <?php endif; ?>


          </div>
      </div>
  <?php endif; ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnEliminar = document.getElementById('btnEliminarPDF');

    if (btnEliminar) {
      btnEliminar.addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
          title: '¿Estás seguro?',
          text: 'No podrás recuperar este archivo después de eliminarlo.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            const idDiseno = this.dataset.id;

            fetch('/admin/diseno/eliminarPDF', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: 'id=' + encodeURIComponent(idDiseno)
            })
              .then(res => res.json())
              .then(data => {
                if (data.success) {
                  Swal.fire({
                    icon: 'success',
                    title: '¡Eliminado!',
                    text: 'El archivo PDF ha sido eliminado correctamente.'
                  });

                  document.getElementById('pdf-actual').innerHTML = '<p>PDF eliminado correctamente.</p>';
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error || 'Ocurrió un error al eliminar el archivo.'
                  });
                }
              })
              .catch(err => {
                console.error('Error AJAX:', err);
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error en la solicitud. Intenta de nuevo.'
                });
              });
          }
        });
      });
    }
  });
</script>

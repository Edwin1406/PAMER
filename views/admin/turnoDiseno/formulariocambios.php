<!--  Observaciones -->

<input type="hidden" name="id_turno" value="<?php echo $id_turno ?? ''; ?>">

<div class="col-md-6 col-12">
  <div class="form-group">
    <label for="cambios">Cambios</label>
    <input type="text" id="cambios" class="form-control"
      placeholder="Cambios" name="cambios"
      value="<?php echo isset($turno) ? s($turno->cambios) : ''; ?>">
  </div>
</div>


<!-- fecha de entrega -->
<?php if ($email !== 'ventas@megaecuador.com') { ?>
  <div class="col-md-6 col-12">
    <div class="form-group">
      <label for="fecha_entrega">Fecha y Hora de Entrega</label>
      <input type="datetime-local" id="fecha_entrega" class="form-control"
        placeholder="Fecha y Hora de Entrega" name="fecha_entrega"
        value="<?= $turno?->fecha_entrega
                  ? date('Y-m-d\TH:i', strtotime($turno->fecha_entrega))
                  : '' ?>">
    </div>

  </div>
  <!-- estado -->
  <div class="col-md-6 col-12">
    <div class="form-group">
      <label for="estado">Estado</label>
      <select id="estado" class="form-control" name="estado">
        <option value="" disabled <?php echo !isset($turno) ? 'selected' : ''; ?>>Seleccione un estado</option>
        <option value="PENDIENTE" <?php echo isset($turno) && $turno->estado === 'PENDIENTE' ? 'selected' : ''; ?>>Pendiente</option>
        <option value="EN PROCESO" <?php echo isset($turno) && $turno->estado === 'EN_PROCESO' ? 'selected' : ''; ?>>En Proceso</option>
        <option value="ENTREGADO" <?php echo isset($turno) && $turno->estado === 'ENTREGADO' ? 'selected' : ''; ?>>Entregado</option>
      </select>
    </div>
  </div>
<?php } ?>
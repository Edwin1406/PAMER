  <?php if (!empty($alertas)) : ?>
      <?php foreach ($alertas as $tipo => $mensajes) : ?>
          <?php
            $color = $tipo === 'error' ? 'danger' : $tipo;
            ?>
          <?php foreach ($mensajes as $mensaje) : ?>
              <div class="border-start border-4 border-<?php echo $color; ?> ps-3 py-2 mb-3 bg-light text-<?php echo $color; ?> rounded">
                  <?php echo $mensaje; ?>
              </div>
          <?php endforeach; ?>
      <?php endforeach; ?>
  <?php endif; ?>
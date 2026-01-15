 <!-- <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header> -->
 <div class="page-heading">
     <div class="page-title">
         <div class="row">
             <div class="col-12 col-md-6 order-md-1 order-last">
                 <h3><?php echo $titulo; ?></h3>
                 <p class="text-subtitle text-muted">Resumen de <?php echo $subtitulo; ?></p>
             </div>
             <div class="col-12 col-md-6 order-md-2 order-first">
                 <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                     <ol class="breadcrumb">
                         <li class="breadcrumb-item"><a > <?php echo $nombre; ?></a></li>
                         <li class="breadcrumb-item"><a href="/cerrarSesion">Cerrar Sesión</a></li>
                     </ol>
                 </nav>
             </div>

             <div class="toast-container position-fixed top-0 end-0 p-3">
                 <div id="toastExito" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                     <div class="d-flex">
                         <div class="toast-body">
                             ¡Registro eliminado!
                         </div>
                         <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                     </div>
                 </div>
             </div>
             <?php if (isset($_GET['exito']) && $_GET['exito'] == '1') : ?>
                 <script>
                     window.addEventListener('DOMContentLoaded', function() {
                         // Mostrar el toast
                         var toastEl = document.getElementById('toastExito');
                         var toast = new bootstrap.Toast(toastEl);
                         toast.show();

                         // Quitar el parámetro ?exito=1 de la URL sin recargar
                         const url = new URL(window.location);
                         url.searchParams.delete('exito');
                         window.history.replaceState({}, document.title, url.toString());
                     });
                 </script>
             <?php endif; ?>
         </div>
     </div>

     <section class="section">
         <div class="card">
             <ul class="nav nav-tabs">
                 <li class="nav-item">
                     <a class="nav-link active" href="/admin/control/doblado/consumo_doblado">Registro Consumo Doblado</a>
                 </li>
             </ul>
         </div>
     </section>

                        <?php require_once __DIR__ . '../../../../templates/alertas.php'  ?>


     <section class="section">
         <div class="card">
             <div class="card-header">
                 Tabla de consumo
             </div>
             <div class="card-body">
                 <table class="table table-striped" id="table1">
                     <thead>
                         <tr>
                             <th class="fs-6" style="min-width: 90px;">Fecha</th>
                             <th class="fs-6" style="min-width: 80px;">Turno</th>
                             <th class="fs-6" style="min-width: 155px;">Area</th>
                             <th class="fs-6" style="min-width: 130px;">Horas Programadas</th>
                             <th class="fs-6" style="min-width: 93px;">Cantidad Laminas</th>
                             <th class="fs-6" style="min-width: 98px;">Cantidad x hora</th>
                             <th class="fs-6" style="min-width: 110px;">N° Cambio</th>
                             <th class="fs-6" style="min-width: 130px;">Consumo Goma</th>
                             <th class="fs-6" style="min-width: 100px;">Desperdicio</th>
                             <th class="fs-6" style="min-width: 100px;">Acciones</th>
                         </tr>
                     </thead>

                     <tbody>
                         <?php foreach ($control_doblado as $control_dob): ?>
                             <tr>
                                 <td><?= $control_dob->fecha ?></td>
                                 <td><?= $control_dob->turno ?></td>
                                 <td><?= $control_dob->area ?></td>
                                 <td><?= $control_dob->horas_programadas ?></td>
                                 <td><?= $control_dob->cantidad_laminas ?></td>
                                 <td><?= $control_dob->cantidad_lamina_hora ?></td>
                                 <td><?= $control_dob->n_cambio ?></td>
                                    <td><?= $control_dob->consumo_goma ?></td>
                                 <td><?= $control_dob->desperdicio_kg ?></td>

                                 <!-- los botones en horizontal -->

                                 <td>
                                     <div class="d-flex gap-1">
                                         <!-- <a href="/admin/editarConsumo?id=<?= $contro->id ?>" class="btn btn-primary btn-sm">Editar</a> -->
                                         <form action="/admin/eliminarConsumoDoblado" method="POST">
                                             <input type="hidden" name="id" value="<?= $control_dob->id ?>">
                                             <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                         </form>
                                     </div>
                                 </td>

                             </tr>
                         <?php endforeach; ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </section>
 </div>


 <script>
     document.addEventListener("DOMContentLoaded", function() {
         const dataTable = new simpleDatatables.DataTable("#table1", {
             scrollX: true,
             columnDefs: [{
                     width: "110px",
                     targets: [6, 7, 8]
                 } // índices de columnas Hora Inicio, Hora Fin, Total Horas
             ]
         });
     });
 </script>
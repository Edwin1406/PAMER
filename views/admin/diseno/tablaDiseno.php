
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
                         <li class="breadcrumb-item"><a> <?php echo $nombre; ?></a></li>
                         <li class="breadcrumb-item"><a href="/cerrarSesion">Cerrar Sesión</a></li>
                     </ol>
                 </nav>
             </div>

             <?php
                $toastId = null;
                $toastMessage = null;
                $toastClass = null;
                $paramToRemove = null;

                if (isset($_GET['exito']) && $_GET['exito'] == '1') {
                    $toastId = 'toastExito';
                    $toastMessage = '¡Registro creado!';
                    $toastClass = 'text-bg-success';
                    $paramToRemove = 'exito';
                } elseif (isset($_GET['editado']) && $_GET['editado'] == '2') {
                    $toastId = 'toastEditado';
                    $toastMessage = '¡Registro editado correctamente!';
                    $toastClass = 'text-bg-primary';
                    $paramToRemove = 'editado';
                } elseif (isset($_GET['eliminado']) && $_GET['eliminado'] == '3') {
                    $toastId = 'toastEliminado';
                    $toastMessage = '¡Registro eliminado correctamente!';
                    $toastClass = 'text-bg-danger';
                    $paramToRemove = 'eliminado';
                }
                ?>

             <?php if ($toastId) : ?>
                 <!-- Toast HTML -->
                 <div class="toast-container position-fixed top-0 end-0 p-3">
                     <div id="<?php echo $toastId; ?>" class="toast align-items-center <?php echo $toastClass; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                         <div class="d-flex">
                             <div class="toast-body">
                                 <?php echo $toastMessage; ?>
                             </div>
                             <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                         </div>
                     </div>
                 </div>

                 <!-- Toast JS -->
                 <script>
                     window.addEventListener('DOMContentLoaded', function() {
                         var toastEl = document.getElementById('<?php echo $toastId; ?>');
                         if (toastEl) {
                             var toast = new bootstrap.Toast(toastEl);
                             toast.show();
                         }

                         const url = new URL(window.location);
                         url.searchParams.delete('<?php echo $paramToRemove; ?>');
                         window.history.replaceState({}, document.title, url.toString());
                     });
                 </script>
             <?php endif; ?>









         </div>
     </div>

     <section class="section">
         <div class="card">
             <ul class="nav nav-tabs">

                 <?php if ($email !== 'ventas@megaecuador.com') { ?>
                     <li class="nav-item">
                         <a class="nav-link active" href="/admin/diseno/crearDiseno">Registro Diseño</a>
                     </li>
                 <?php } ?>
             </ul>
         </div>
     </section>




     <section class="section">
         <div class="card">
             <div class="card-header">
                 Tabla de consumo
             </div>
             <div class="card-body">
                 <table class="table table-striped" id="table1">
                     <thead>
                         <tr>
                             <th class="fs-6" style="min-width: 90px;">Id</th>
                             <th class="fs-6" style="min-width: 93px;">Codigo producto</th>
                             <th class="fs-6" style="min-width: 80px;">Nombre Cliente</th>
                             <th class="fs-6" style="min-width: 100px;">Nombre Producto</th>
                             <th class="fs-6" style="min-width: 100px;">Proveedor</th>
                             <th class="fs-6" style="min-width: 80px;">Fecha</th>
                             <th class="fs-6" style="min-width: 88px;">Estado</th>
                             <th class="fs-6" style="min-width: 100px;">Pdf</th>
                                <th class="fs-6" style="min-width: 100px;">Descargar</th>

                             <th class="fs-6" style="min-width: 100px;">Acciones</th>
                         </tr>
                     </thead>

                     <tbody>
                         <?php foreach ($disenos as $diseno): ?>
                             <tr>
                                 <td><?= $diseno->id ?></td>
                                 <td><?= $diseno->codigo_producto ?></td>
                                 <td><?= $diseno->nombre_cliente ?></td>
                                 <td><?= $diseno->nombre_producto ?></td>
                                 <td><?= $diseno->proveedor ?></td>
                                 <td><?= $diseno->fecha ?></td>
                                 <?php
                                    $estado = trim($diseno->estado);
                                    switch ($estado) {
                                        case 'ARTE':
                                            $badgeClass = 'bg-secondary'; // CELESTE
                                            break;
                                        case 'APROBADO':
                                            $badgeClass = 'bg-success'; // verde
                                            break;
                                        case 'CLICHE':
                                            $badgeClass = 'bg-warning'; // naranja
                                            break;
                                        default:
                                            $badgeClass = 'bg-secondary'; // gris por defecto
                                    }
                                    ?>
                                 <td data-id="<?php echo $diseno->id; ?>">
                                     <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($estado); ?></span>
                                 </td>

                              
                                     <?php
                                        $rutaArchivo = "/src/visor/" . htmlspecialchars($diseno->pdf);
                                        ?>
                                     <!-- <a href="<?php echo $rutaArchivo ?>" target="_blank" class="btn btn-info rounded-pill">Ver PDF</a> -->
                                 

                                 <td>
                                     <!-- Ver PDF en navegador -->
                                     <a href="<?php echo $rutaArchivo ?>" target="_blank" class="btn btn-info btn-sm">Ver PDF</a>

                                     <!-- Descargar con nombre personalizado -->

                                 </td>
                                 <td>
                                     <a href="/descargar.php?file=<?= urlencode($diseno->pdf) ?>&nombre=<?= urlencode($diseno->codigo_producto . " - " . $diseno->nombre_producto) ?>"
                                         class="btn btn-success btn-sm">Descargar</a>
                                 </td>



                                 <td>
                                     <!-- usuario -->


                                     <?php if ($email !== 'ventas@megaecuador.com') { ?>
                                         <div class="d-flex gap-1">
                                             <a href="/admin/diseno/editarDiseno?id=<?= $diseno->id ?>" class="btn btn-primary btn-sm">Editar</a>
                                             <form action="/admin/eliminarDiseno" method="POST">
                                                 <input type="hidden" name="id" value="<?= $diseno->id ?>">
                                                 <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                             </form>
                                         </div>
                                     <?php } ?>



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
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


                 <li class="nav-item">
                     <a class="nav-link active" href="/admin/turnoDiseno/generarTurno">Registro Turno</a>
                 </li>

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
                             <th class="fs-6" style="min-width: 90px;">Codigo</th>
                             <th class="fs-6" style="min-width: 90px;">Tipo producto</th>
                             <th class="fs-6" style="min-width: 90px;">Tipo componente</th>
                             <th class="fs-6" style="min-width: 100px;">Observaciones</th>
                             <th class="fs-6" style="min-width: 98px;">Estado</th>
                             <th class="fs-6" style="min-width: 80px;">Fecha Creación</th>
                             <th class="fs-6" style="min-width: 80px;">Fecha Entrega</th>
                             <th class="fs-6" style="min-width: 100px;">Acciones</th>
                         </tr>
                     </thead>

                     <tbody>
                         <?php foreach ($turnos as $turno): ?>
                             <tr>

                                 <td><?= $turno->codigo ?></td>
                                 <td><?= $turno->tipo_producto ?></td>
                                 <td><?= $turno->tipo_componente ?></td>

                                 <td><?= $turno->observaciones ?></td>

                                 <?php
                                    $estado = trim($turno->estado);
                                    switch ($estado) {
                                        case 'EN PROCESO':
                                            $badgeClass = 'bg-info'; // AZUL
                                            break;
                                        case 'ENTREGADO':
                                            $badgeClass = 'bg-success'; // verde
                                            break;
                                        case 'PENDIENTE':
                                            $badgeClass = 'bg-danger'; // rojo
                                            break;
                                        default:
                                            $badgeClass = 'bg-secondary'; // gris por defecto
                                    }
                                    ?>
                                 <td data-id="<?php echo $diseno->id; ?>">
                                     <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($estado); ?></span>
                                 </td>

                                 <td><?= $turno->fecha_creacion ?></td>
                                 <td><?= $turno->fecha_entrega ?></td>



                                 <td>
                                     <!-- usuario -->


                                     <div class="d-flex gap-1">
                                         <a href="/admin/turnoDiseno/editarTurno?id=<?= $turno->id ?>" class="btn btn-primary btn-sm">Editar</a>
                                         <a href="/admin/turnoDiseno/cambios?id=<?= $turno->id ?>" class="btn btn-secondary btn-sm">Cambios</a>
                                         <!-- ver detalle un boton -->

                                         <!-- BOTÓN -->
                                         <button class="btn btn-info btn-sm btn-detalle" data-id="<?= $turno->id ?>">Detalle</button>

                                         <?php if ($email !== 'ventas@megaecuador.com') { ?>
                                             <form action="/admin/eliminarTurnoDiseno" method="POST">
                                                 <input type="hidden" name="id" value="<?= $turno->id ?>">
                                                 <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                             </form>

                                         <?php } ?>
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


 <!-- Modal reutilizable -->
 <div class="modal fade text-left" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header bg-info">
                 <h5 class="modal-title white" id="detalleLabel">Detalle del Turno</h5>
                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <i data-feather="x"></i>
                 </button>
             </div>
             <div class="modal-body">

                 <!-- Contenedor de detalle -->
                 <div id="detalleContenido">Cargando información...</div>

                 <div class="table-responsive mt-3">
                     <table id="tablaCambios" class="table table-striped table-bordered table-hover w-100">
                         <thead>
                             <tr>
                                 <th>id</th>
                                 <th>id_turno</th>
                                 <th>codigo</th>
                                 <th>cambios</th>
                                 <th>fecha_creacion</th>
                                 <th>fecha_entrega</th>
                                 <th>estado</th>
                                 <th>Acciones</th>
                             </tr>
                         </thead>
                         <tbody></tbody>
                     </table>
                 </div>
             </div>

             <div class="modal-footer">
                 <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cerrar</button>
             </div>
         </div>
     </div>
 </div>

 <script>
     document.addEventListener('click', async function(e) {
         if (e.target.matches('.btn-detalle')) {
             const id = e.target.getAttribute('data-id');
             const contenido = document.getElementById('detalleContenido');
             contenido.innerHTML = "Cargando información...";

             // 👉 Traer detalle
             const datos = await ApiDetalle(id);

             if (datos) {
                 let tabla = `<table class="table table-sm table-bordered"><tbody><tr>`;
                 let contador = 0;

                 for (const [campo, valor] of Object.entries(datos)) {
                     if (valor !== null && valor !== "" && valor !== 0 && valor !== "0") {
                         let celda;
                         if (campo === "pdf") {
                             celda = `
                                <th style="width:15%">${campo}</th>
                                <td style="width:35%"><a href="/src/turnos/${valor}" target="_blank">Ver archivo</a></td>
                            `;
                         } else {
                             celda = `
                                <th style="width:15%">${campo}</th>
                                <td style="width:35%">${valor}</td>
                            `;
                         }

                         tabla += celda;
                         contador++;

                         // 👉 Cada 2 pares (4 celdas) cerramos fila y abrimos otra
                         if (contador % 2 === 0) {
                             tabla += `</tr><tr>`;
                         }
                     }
                 }

                 tabla += `</tr></tbody></table>`;
                 contenido.innerHTML = tabla;
             } else {
                 contenido.innerHTML = `<p class="text-danger">No se pudo cargar el detalle.</p>`;
             }

             // 👉 Ahora cargo los cambios usando el CODIGO del detalle
             const cambios = await ApiCambios(datos.codigo);

             if ($.fn.DataTable.isDataTable('#tablaCambios')) {
                 $('#tablaCambios').DataTable().clear().rows.add(cambios).draw();
             } else {
                 $('#tablaCambios').DataTable({
                     data: cambios,
                     columns: [{
                             data: 'id'
                         },
                         {
                             data: 'id_turno'
                         },
                         {
                             data: 'codigo'
                         },
                         {
                             data: 'cambios'
                         },
                         {
                             data: 'fecha_creacion'
                         },
                         {
                             data: 'fecha_entrega'
                         },
                         {
                             data: 'estado',
                             render: function(data, type, row) {
                                 let badgeClass = 'bg-secondary'; // gris por defecto

                                 switch (data.trim()) {
                                     case 'EN PROCESO':
                                         badgeClass = 'bg-info'; // azul
                                         break;
                                     case 'ENTREGADO':
                                         badgeClass = 'bg-success'; // verde
                                         break;
                                     case 'PENDIENTE':
                                         badgeClass = 'bg-danger'; // rojo
                                         break;
                                 }

                                 return `<span class="badge ${badgeClass}">${data}</span>`;
                             }
                         },
                         {
                             data: null,
                             render: function(data, type, row) {
                                 return `
                                    <a href="/admin/turnoDiseno/editarCambios?id=${row.id}" class="btn btn-sm btn-primary">Editar</a>
                                `;
                             }
                         },
                     ],
                     language: {
                         url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                     },
                     responsive: true
                 });
             }

             // Mostrar modal
             const modal = new bootstrap.Modal(document.getElementById('detalleModal'));
             modal.show();
         }
     });

     async function ApiDetalle(id) {
         try {
             const url = `${location.origin}/admin/api/apiDetalle?id=${id}`;
             const resultado = await fetch(url);
             return await resultado.json();
         } catch (e) {
             console.log(e);
             return null;
         }
     }

     async function ApiCambios(codigo) {
         try {
             const url = `${location.origin}/admin/api/apiCambiosDiseno?codigo=${codigo}`;
             const resultado = await fetch(url);
             const data = await resultado.json();
             console.log("Respuesta de ApiCambios:", data);
             return data;
         } catch (e) {
             console.log("Error:", e);
             return [];
         }
     }
 </script>

 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

 <!-- DataTables CSS -->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

 <!-- DataTables JS -->
 <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

 <!-- DataTables Responsive (CSS + JS) -->
 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
 <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

 <!-- Y recién tu script -->
 <script>
     $(document).ready(function() {
         console.log("jQuery ya funciona 👍");
     });
 </script>
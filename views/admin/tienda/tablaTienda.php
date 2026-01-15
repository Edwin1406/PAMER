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

                <li class="nav-item"></li>
                <a class="nav-link" href="/admin/tienda/crearTienda">Crear Tienda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="/admin/tienda/tablaTienda">Tiendas</a>
                </li>


            </ul>
        </div>
    </section>




    <section class="section">
        <div class="card">
            <div class="card-header">
                Tabla de registros de Tiendas
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th class="fs-6" style="min-width: 90px;">Id</th>
                            <th class="fs-6" style="min-width: 93px;">Nombre Tienda</th>
                            <th class="fs-6" style="min-width: 100px;">Ciudad Tienda</th>
                            <th class="fs-6" style="min-width: 100px;">Foto Tienda</th>

                            <th class="fs-6" style="min-width: 100px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($tienda as $tiendaItem): ?>
                            <tr>
                                <td><?= $tiendaItem->id ?></td>
                                <td><?= $tiendaItem->Nombre_Tienda ?></td>
                                <td><?= $tiendaItem->Ciudad_Tienda ?></td>
                                <td>
                                    <?php if (!empty($tiendaItem->Foto_Tienda)): ?>
                                        <a href="<?php echo $_ENV['HOST'] . '/src/tiendas/' . $tiendaItem->Foto_Tienda; ?>"
                                            target="_blank"
                                            class="text-primary text-decoration-underline">
                                            Ver imagen
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">No disponible</span>
                                    <?php endif; ?>
                                </td>
                                <td>

                                    <div class="d-flex gap-1">
                                        <a href="/admin/tienda/editarTienda?id=<?= $tiendaItem->id ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <form action="/admin/eliminarTienda" method="POST">
                                            <input type="hidden" name="id" value="<?= $tiendaItem->id ?>">
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
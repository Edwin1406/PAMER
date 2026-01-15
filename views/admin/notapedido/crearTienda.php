<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?php echo $titulo ?> </h3>
                <p class="text-subtitle text-muted">Ingrese la secuencia de la Nota de Pedido</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a><?php echo $nombre; ?></a></li>
                        <!--  cerrar sesión -->
                        <li class="breadcrumb-item"><a href="/cerrarSesion">Cerrar Sesión</a></li>

                    </ol>
                </nav>
            </div>
        </div>
    </div>



    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <!-- <div class="card"> -->
                <div class="card-content mt-0">
                    <div class="card-body">
                        <div class="alert alert-warning py-2">
                            <div class="row align-items-center">

                                <div class="col-md-2 col-6">
                                    <small class="text-muted"><b>Nota de pedido N°</b></small><br>
                                    <span class="fw-bold"><?php echo $informacionNota->Codigo_Nota_Pedido; ?></span>
                                </div>

                                <div class="col-md-1 col-6">
                                    <small class="text-muted"><b># Pedido</b></small><br>
                                    <span class="fw-bold"><?php echo $informacionNota->Numero_Nota_Pedido; ?></span>
                                </div>

                                <div class="col-md-1 col-6">
                                    <small class="text-muted"><b># Import</b></small><br>
                                    <span class="fw-bold"><?php echo $informacionNota->Codigo_Importacion ?? '-'; ?></span>
                                </div>

                                <div class="col-md-2 col-6">
                                    <small class="text-muted"><b>Fecha</b></small><br>
                                    <span class="fw-bold"><?php echo date("d/m/Y", strtotime($informacionNota->Fecha_Nota_Pedido)) ?></span>
                                </div>

                                <div class="col-md-3 col-12">
                                    <small class="text-muted"><b>Importador</b></small><br>
                                    <span class="fw-bold"><?php echo $informacionNota->Codigo_Importador ?? '-'; ?></span>
                                </div>

                                <div class="col-md-3 col-12">
                                    <small class="text-muted"><b>Exportador</b></small><br>
                                    <span class="fw-bold"><?php echo $informacionNota->Codigo_Exportador ?? '-'; ?></span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </section>






    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="toastExito" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ¡Registro guardado exitosamente!
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
                url.searchParams.delete('exito'); // Eliminar solo 'exito'
                // Mantener el parámetro 'id'
                const idNotaPedido = url.searchParams.get('id');
                if (idNotaPedido) {
                    url.searchParams.set('id', idNotaPedido);
                }
                window.history.replaceState({}, document.title, url.toString());
            });
        </script>
    <?php endif; ?>






    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <?php
                            $mapa = [
                                'error'   => 'danger',
                                'exito'   => 'success',
                                'warning' => 'warning',
                                'info'    => 'info',
                            ];
                            ?>

                            <?php foreach ($alertas as $tipo => $mensajes) : ?>
                                <?php
                                $clase = $mapa[$tipo] ?? 'info';
                                ?>
                                <?php foreach ($mensajes as $mensaje) : ?>
                                    <div class="alert alert-<?= $clase ?> alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($mensaje) ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>


                            <form class="form" method="POST" action="/admin/notaPedido/crearTienda" onsubmit="return bloquearBoton(this)">

                                <input type="hidden" name="id_nota_pedido" value="<?php echo $id_nota_pedido; ?>">


                                <div class="row">

                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Codigo_Nota_Pedido">N° Nota Pedido</label>
                                            <input type="number" id="Codigo_Nota_Pedido" class="form-control"
                                                placeholder="Nota de pedido N°" name="Codigo_Nota_Pedido"
                                                value="<?php echo $id_nota_pedido; ?>" readonly>
                                        </div>
                                    </div>



                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="tienda">Tienda</label>

                                            <?php
                                            // Prioridad: old (cuando hay redirect) -> tiendaNota (cuando renderizas sin redirect)
                                            $paisSeleccionado = $old['tienda'] ?? ($tiendaNota->tienda ?? '');
                                            ?>

                                            <select id="tienda" class="form-select" name="tienda">
                                                <option value="" <?= empty($paisSeleccionado) ? 'selected' : '' ?> disabled>Seleccione Tienda</option>

                                                <?php foreach ($tiendas as $tiendaOption) : ?>
                                                    <?php $valor = $tiendaOption->Nombre_Tienda; ?>
                                                    <option value="<?= htmlspecialchars($valor) ?>"
                                                        <?= ($paisSeleccionado === $valor) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($valor) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="ciudad">Ciudad</label>

                                            <?php
                                            // Prioridad: old (cuando hay redirect) -> tiendaNota (cuando renderizas sin redirect)
                                            $paisSeleccionado = $old['ciudad'] ?? ($tiendaNota->pais ?? '');
                                            ?>

                                            <select id="ciudad" class="form-select" name="ciudad">
                                                <option value="" <?= empty($paisSeleccionado) ? 'selected' : '' ?> disabled>Seleccione Ciudad</option>

                                                <?php foreach ($ciudad as $ciudadOption) : ?>
                                                    <?php $valor = $ciudadOption->Nombre_Ciudad; ?>
                                                    <option value="<?= htmlspecialchars($valor) ?>"
                                                        <?= ($paisSeleccionado === $valor) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($valor) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="pais">Pais</label>

                                            <?php
                                            // Prioridad: old (cuando hay redirect) -> tiendaNota (cuando renderizas sin redirect)
                                            $paisSeleccionado = $old['pais'] ?? ($tiendaNota->pais ?? '');
                                            ?>

                                            <select id="pais" class="form-select" name="pais">
                                                <option value="" <?= empty($paisSeleccionado) ? 'selected' : '' ?> disabled>Seleccione Pais</option>

                                                <?php foreach ($paises as $paisOption) : ?>
                                                    <?php $valor = $paisOption->Pais_Origen; ?>
                                                    <option value="<?= htmlspecialchars($valor) ?>"
                                                        <?= ($paisSeleccionado === $valor) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($valor) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>








                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="marca">Marca</label>

                                            <?php
                                            // Prioridad: old (cuando hay redirect) -> tiendaNota (cuando renderizas sin redirect)
                                            $marcaSeleccionada = $old['marca'] ?? ($tiendaNota->marca ?? '');
                                            ?>

                                            <select id="marca" class="form-select" name="marca">
                                                <option value="" <?= empty($marcaSeleccionada) ? 'selected' : '' ?> disabled>Seleccione Marca</option>
                                                <?php foreach ($marca as $marcaOption) : ?>
                                                    <?php $valor = $marcaOption->Nombre_Marca; ?>
                                                    <option value="<?= htmlspecialchars($valor) ?>"
                                                        <?= ($marcaSeleccionada === $valor) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($valor) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>






                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="fecha">Fecha</label>
                                            <input type="date" id="fecha" class="form-control"
                                                placeholder="Fecha" name="fecha"
                                                value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="num_factura">Num_Factura</label>
                                            <input type="text" id="num_factura" class="form-control"
                                                placeholder="Num_Factura" name="num_factura">
                                        </div>
                                    </div>

                                </div>


                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" id="btnRegistrar" class="btn btn-primary me-1 mb-1">Registrar</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Limpiar</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>




<section class="section">
    <div class="card">
        <div class="card-header">
            Tabla de registros de Tiendas asociadas a la Nota de Pedido
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th class="fs-6" style="min-width: 90px;">Id</th>
                        <th class="fs-6" style="min-width: 93px;">Codigo Nota</th>
                        <th class="fs-6" style="min-width: 80px;">Tienda</th>
                        <th class="fs-6" style="min-width: 80px;">Marca</th>
                        <th class="fs-6" style="min-width: 80px;">Ciudad</th>
                        <th class="fs-6" style="min-width: 80px;">Pais</th>
                        <th class="fs-6" style="min-width: 80px;">Fecha</th>

                        <th class="fs-6" style="min-width: 100px;">Num_Factura</th>

                        <th class="fs-6" style="min-width: 100px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($tiendaNotas as $tiendaItem): ?>
                        <tr>
                            <td><?= $tiendaItem->id ?></td>
                            <td><?= $tiendaItem->Codigo_Nota_Pedido ?></td>
                            <td><?= $tiendaItem->tienda ?></td>
                            <td><?= $tiendaItem->marca ?></td>
                            <td><?= $tiendaItem->ciudad ?></td>
                            <td><?= $tiendaItem->pais ?></td>
                            <td><?= $tiendaItem->fecha ?></td>
                            <td><?= $tiendaItem->num_factura ?></td>
                            <td>

                                <div class="d-flex gap-1">
                                    <a href="/admin/pruebas/crearPruebas?id=<?= $tiendaItem->id ?>" class="btn btn-primary btn-sm">idnota</a>

                                </div>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>





<script>
    function bloquearBoton(form) {
        const btn = form.querySelector('#btnRegistrar');
        btn.disabled = true; // Deshabilita el botón
        btn.innerText = "Registrando..."; // Cambia el texto (opcional)
        return true; // Permite que el formulario se envíe
    }
</script>
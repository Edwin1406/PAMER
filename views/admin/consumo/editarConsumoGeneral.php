<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?php echo $titulo ?> </h3>
                <p class="text-subtitle text-muted">Ingrese los datos del consumo</p>
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
                url.searchParams.delete('exito');
                window.history.replaceState({}, document.title, url.toString());
            });
        </script>
    <?php endif; ?>



    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">EDITAR CONSUMO GENERAL</h4>
                        <?php include_once __DIR__ . '/../../templates/alertas.php'  ?>


                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST">
                                <div class="row">





                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="created_at">Fecha</label>
                                            <input type="date" id="created_at" class="form-control"
                                                placeholder="Fecha" name="created_at"
                                                value="<?= htmlspecialchars($consumoGeneral->created_at ?? '') ?>"
                                                >
                                        </div>
                                    </div>



                                    <!-- operador SELECCIONAR NO MULTIPLE -->
                                    <div class="col-md-6 col-12">
                                        <label for="tipo_maquina">Escoja tipo_maquina</label>
                                        <div class="form-group">
                                            <select class="form-select" name="tipo_maquina" id="tipo_maquina">
                                                <option value="" disabled selected>Seleccione tipo de máquina</option>
                                                <option value="CORRUGADOR" <?= $consumoGeneral->tipo_maquina === 'CORRUGADOR' ? 'selected' : '' ?>>CORRUGADOR</option>
                                                <option value="MICRO" <?= $consumoGeneral->tipo_maquina === 'MICRO' ? 'selected' : '' ?>>MICRO</option>
                                                <option value="TROQUEL" <?= $consumoGeneral->tipo_maquina === 'TROQUEL' ? 'selected' : '' ?>>TROQUEL</option>
                                                <option value="FLEXOGRAFICA" <?= $consumoGeneral->tipo_maquina === 'FLEXOGRAFICA' ? 'selected' : '' ?>>FLEXOGRAFICA</option>
                                                <option value="PRE-PRINTER" <?= $consumoGeneral->tipo_maquina === 'PRE-PRINTER' ? 'selected' : '' ?>>PRE-PRINTER</option>
                                                <option value="DOBLADO" <?= $consumoGeneral->tipo_maquina === 'DOBLADO' ? 'selected' : '' ?>>DOBLADO</option>
                                                <option value="CORTE CEJA" <?= $consumoGeneral->tipo_maquina === 'CORTE CEJA' ? 'selected' : '' ?>>CORTE CEJA</option>
                                                <option value="CONVERTIDOR" <?= $consumoGeneral->tipo_maquina === 'CONVERTIDOR' ? 'selected' : '' ?>>CONVERTIDOR</option>
                                                <option value="GUILLLOTINA LAMINA" <?= $consumoGeneral->tipo_maquina === 'GUILLLOTINA LAMINA' ? 'selected' : '' ?>>GUILLLOTINA LAMINA</option>
                                                <option value="GUILLOTINA PAPEL" <?= $consumoGeneral->tipo_maquina === 'GUILLOTINA PAPEL' ? 'selected' : '' ?>>GUILLOTINA PAPEL</option>
                                                <option value="EMPAQUE" <?= $consumoGeneral->tipo_maquina === 'EMPAQUE' ? 'selected' : '' ?>>EMPAQUE</option>
                                                <option value="BODEGA" <?= $consumoGeneral->tipo_maquina === 'BODEGA' ? 'selected' : '' ?>>BODEGA</option>

                                            </select>
                                        </div>
                                    </div>


                                    <!-- fecha created -->


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="total_general">TOTAL GENERAL</label>
                                            <input type="text" id="total_general" class="form-control"
                                                placeholder="Total General" name="total_general"
                                                value="<?= htmlspecialchars($consumoGeneral->total_general ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Atualizar</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Limpiar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<!-- <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header> -->



<div class="page-heading" id="contenido-dinamico">
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


    <section class="section">
        <div class="card">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="/admin/control/convertidor/tablaConsumoConvertidor">Tabla Consumo Convertidor</a>
                </li>
            </ul>
        </div>
    </section>

    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">REGISTRO DE CONTROL CONVERTIDOR</h4>
                        <?php require_once __DIR__ . '../../../../templates/alertas.php'  ?>


                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="/admin/control/convertidor/consumo_convertidor">
                                <div class="row">

                                    <!-- fecha -->

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="fecha">Fecha</label>
                                            <input type="date" id="fecha" class="form-control"
                                                placeholder="Fecha" name="fecha">
                                        </div>
                                    </div>
                                    <!-- turno -->


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="turno">Turno</label>
                                            <input type="number" id="turno" class="form-control"
                                                placeholder="Turno" name="turno">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label for="personal">Escoja el Personal</label>
                                        <div class="form-group">
                                            <select class="form-select" name="personal" id="personal">
                                                <option value="Simon Chucuri">Simon Chucuri</option>
                                                <option value="Gabriel Silva">Gabriel Silva</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- horas_programadas -->

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="horas_programadas">Horas Programadas</label>
                                            <input type="time" id="horas_programadas" class="form-control"
                                                placeholder="Horas Programadas" name="horas_programadas">
                                        </div>
                                    </div>

                                    <!-- cantidad_laminas -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="cantidad_resmas">Cantidad de Resmas</label>
                                            <input type="number" id="cantidad_resmas" class="form-control"
                                                placeholder="Cantidad de Resmas" name="cantidad_resmas">
                                        </div>
                                    </div>
                                    <!-- ancho_papel -->
                                    <div class="col-md-6 col-12">

                                        <div class="form-group">
                                            <label for="ancho_papel">Ancho de Papel</label>
                                            <input type="number" id="ancho_papel" class="form-control"
                                                placeholder="Ancho de Papel" name="ancho_papel">
                                        </div>
                                    </div>


                                    <!-- n_cambio -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="n_cambios">N° de Cambio</label>
                                            <input type="number" id="n_cambios" class="form-control"
                                                placeholder="N° de Cambio" name="n_cambios">
                                        </div>
                                    </div>

                                    <!-- gramaje -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gramaje">Gramaje</label>
                                            <input type="number" id="gramaje" class="form-control"
                                                placeholder="Gramaje" name="gramaje">
                                        </div>
                                    </div>

                                    <!-- desperdicio_k -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="desperdicio_kg">Desperdicio (KL)</label>
                                            <input type="number" id="desperdicio_kg" class="form-control"
                                                placeholder="Desperdicio (kl)" name="desperdicio_kg"
                                                step="any" min="0">
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Registrar</button>
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
<!-- <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header> -->

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

    <section class="section">
        <div class="card">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="/admin/tablaConsumoTroquel">Tabla Consumo Troquel</a>
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
                        <h4 class="card-title">REGISTRO DE CONTROL TROQUEL</h4>
                        <?php include_once __DIR__ . '/../../templates/alertas.php'  ?>


                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="/admin/control_troquel">
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
                                            <label for="turnos">Turno</label>
                                            <input type="number" id="turnos" class="form-control"
                                                placeholder="Turno" name="turnos">
                                        </div>
                                    </div>


                                    <!-- OPERADOR SELECCIONAR NO MULTIPLE -->
                                    <div class="col-md-6 col-12">
                                        <label for="operador">Escoja el Operador</label>
                                        <div class="form-group">
                                            <select class="form-select" name="operador" id="operador">
                                                <option value="Luis Govea">Luis Govea</option>
                                                <option value="Guillermo Bonilla">Guillermo Bonilla</option>
                                            </select>
                                        </div>
                                    </div>


                                    <!-- hora de inicio  -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="horas_programadas">Hora Programadas</label>
                                            <input type="time" id="horas_programadas" class="form-control"
                                                placeholder="Hora Programadas" name="horas_programadas">
                                        </div>
                                    </div>



                                    <!-- golpes maquina  -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="golpes_maquina">Golpes Maquina(UND)</label>
                                            <input type="number" id="golpes_maquina" class="form-control"
                                                placeholder="Golpes Maquina" name="golpes_maquina">
                                        </div>
                                    </div>

                                    <!-- cambios de medida  -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="cambios_medida">Cambios de Medida</label>
                                            <input type="number" id="cambios_medida" class="form-control"
                                                placeholder="Cambios de Medida" name="cambios_medida">
                                        </div>
                                    </div>

                                    <!-- cantidad separadores  -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="cantidad_separadores">Cantidad Separadores(UND)</label>
                                            <input type="number" id="cantidad_separadores" class="form-control"
                                                placeholder="Cantidad Separadores" name="cantidad_separadores">
                                        </div>
                                    </div>

                                    <!-- cantidad cajas  -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="cantidad_cajas">Cantidad Cajas(UND)</label>
                                            <input type="number" id="cantidad_cajas" class="form-control"
                                                placeholder="Cantidad Cajas" name="cantidad_cajas">
                                        </div>
                                    </div>

                                    <!-- cantidad papel  -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="cantidad_papel">Cantidad Papel(UND)</label>
                                            <input type="number" id="cantidad_papel" class="form-control"
                                                placeholder="Cantidad Papel" name="cantidad_papel">

                                        </div>
                                    </div>

                                    <!-- desperdicio kg  -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="desperdicio_kg">Desperdicio (KL)</label>
                                            <input type="number" id="desperdicio_kg" class="form-control"
                                                placeholder="Desperdicio (kg)" name="desperdicio_kg"
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
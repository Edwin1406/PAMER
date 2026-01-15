




<div class="page-heading" id="contenido-dinamico">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?php echo $titulo ?> </h3>
                <p class="text-subtitle text-muted">Ingrese los datos de mantenimiento</p>
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
                    <a class="nav-link active" href="/admin/">Tabla Consumo mantenimiento</a>
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
                        <h4 class="card-title">REGISTRO DE CONTROL DE MANTENIMIENTO</h4>
                        <?php require_once __DIR__ . '../../../templates/alertas.php'  ?>


                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="/admin/mantenimiento/registroMantenimiento">
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
                                        <label for="tipo_doc">Tipo Doc</label>
                                        <div class="form-group">
                                            <select class="form-select" name="tipo_doc" id="tipo_doc">
                                                <option value="" disabled>Seleccione un tipo de documento</option>
                                                  <option value="FACTURA" <?php echo isset($mantenimiento) && s($mantenimiento->tipo_doc) === 'FACTURA' ? 'selected' : ''; ?>>Factura</option>
                                                  <option value="NOTAS DE VENTAS" <?php echo isset($mantenimiento) && s($mantenimiento->tipo_doc) === 'NOTAS DE VENTAS' ? 'selected' : ''; ?>>Notas de Ventas</option>
                                                  <option value="COTIZACION" <?php echo isset($mantenimiento) && s($mantenimiento->tipo_doc) === 'COTIZACION' ? 'selected' : ''; ?>>Cotización</option>
                                                  <option value="PROFORMA" <?php echo isset($mantenimiento) && s($mantenimiento->tipo_doc) === 'PROFORMA' ? 'selected' : ''; ?>>Proforma</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- horas_programadas -->

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="numero">Numero</label>
                                            <input type="number" id="numero" class="form-control"
                                                placeholder="Numero" name="numero">
                                        </div>
                                    </div>

                                    <!-- cantidad_laminas -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="proveedor">Proveedor</label>
                                            <input type="text" id="proveedor" class="form-control"
                                                placeholder="Proveedor" name="proveedor">
                                        </div>
                                    </div>
                                    <!-- ancho_papel -->
                                  <div class="col-md-6 col-12">
                                        <label for="maquina">Maquina</label>
                                        <div class="form-group">
                                            <select class="form-select" name="maquina" id="maquina">
                                                <option value="CALDERO">Caldero</option>
                                                <option value="MONTACARGAS">Montacargas</option>
                                                <option value="TROQUELADORA">Troqueladora</option>
                                                <option value="PRE-PRINTER">Pre-Printer</option>
                                                <option value="DOBLADORA">Dobladora</option>
                                                <option value="GENERAL-PLANTA">General Planta</option>
                                                <option value="CORRUGADOR">Corrugador</option>
                                                <option value="MICRO">Micro</option>
                                            </select>
                                        </div>
                                    </div>

                         
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="trabajo">Trabajo o repuesto</label>
                                            <input type="text" id="trabajo" class="form-control"
                                                placeholder="Trabajo o repuesto" name="trabajo">
                                        </div>
                                    </div>

                            
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="valor">valor</label>
                                            <input type="number" id="valor" class="form-control"
                                                placeholder="valor" name="valor" step="any" min="0">
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="descuento">Descuento</label>
                                            <input type="number" id="descuento" class="form-control"
                                                placeholder="Descuento" name="descuento"
                                                step="any" min="0">
                                        </div>
                                    </div>

                                    <!-- observacion -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="observacion">Observación</label>
                                            <textarea id="observacion" class="form-control"
                                                placeholder="Observación" name="observacion"></textarea>
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
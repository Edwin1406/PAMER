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
                    <a class="nav-link active" href="/admin/tablaConsumoGeneral">Tabla Consumo General</a>
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
                        <h4 class="card-title">REGISTRO DE CONSUMO GENERAL</h4>
                        <?php include_once __DIR__ . '/../../templates/alertas.php'  ?>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="/admin/consumo_general" onsubmit="return bloquearBoton(this)">
                                <div class="row">

                                  <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="created_at">Fecha</label>
                                            <input type="date" id="created_at" class="form-control"
                                                placeholder="Fecha" name="created_at" >
                                        </div>
                                    </div>

                                    <!-- operador SELECCIONAR NO MULTIPLE -->
                                    <div class="col-md-6 col-12">
                                        <label for="tipo_maquina">Escoja tipo_maquina</label>
                                        <div class="form-group"> 
                                            <select class="form-select" name="tipo_maquina" id="tipo_maquina">
                                                <option value="" disabled selected>Seleccione tipo de máquina</option>
                                                <option value="CORRUGADOR">CORRUGADOR</option>
                                                <option value="MICRO">MICRO</option>
                                                <option value="TROQUEL">TROQUEL</option>
                                                <option value="FLEXOGRAFICA">FLEXOGRAFICA</option>
                                                <option value="PRE-PRINTER">PRE-PRINTER</option>
                                                <option value="DOBLADO">DOBLADO</option>
                                                <option value="CORTE CEJA">CORTE CEJA</option>
                                                <option value="CONVERTIDOR">CONVERTIDOR</option>
                                                <option value="GUILLOTINA LAMINA">GUILLOTINA LAMINA</option>
                                                <option value="GUILLOTINA PAPEL">GUILLOTINA PAPEL</option>
                                                <option value="EMPAQUE">EMPAQUE</option>
                                                <option value="BODEGA">BODEGA</option>
                                                <option value="DESHOJE-MICRO">DESHOJE-MICRO</option>
                                                <option value="DESHOJE-CORRGADOR">DESHOJE-CORRGADOR</option>
                                                <option value="DESHOJE-PRE-PRINTER">DESHOJE-PRE-PRINTER</option>
                                                <option value="DESHOJE-CONVERTIDOR">DESHOJE-CONVERTIDOR</option>
                                                <option value="CANUTOS">CANUTOS</option>
                                                <option value="MATERIA-DE-BAJA">MATERIA-DE-BAJA</option>
                                                <option value="RETAZOS-BOBINA">RETAZOS-BOBINA</option>
                                                <option value="PACAS">PACAS</option>


                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="total_general">TOTAL GENERAL</label>
                                            <input type="text" id="total_general" class="form-control"
                                                placeholder="Total General" step="0.01" name="total_general">
                                        </div>
                                    </div>


                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="btnRegistrar" class="btn btn-primary me-1 mb-1">Registrar</button>
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





<script>
function bloquearBoton(form) {
  const btn = form.querySelector('#btnRegistrar');
  btn.disabled = true; // Deshabilita el botón
  btn.innerText = "Registrando..."; // Cambia el texto (opcional)
  return true; // Permite que el formulario se envíe
}
</script>


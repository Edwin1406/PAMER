<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?php echo $titulo ?> </h3>
                <p class="text-subtitle text-muted">Actualizar los datos de la Tienda</p>
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
    <?php if (isset($_GET['editado']) && $_GET['editado'] == '2') : ?>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                // Mostrar el toast
                var toastEl = document.getElementById('toastExito');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();

                // Quitar el parámetro ?editado=2 de la URL sin recargar
                const url = new URL(window.location);
                url.searchParams.delete('editado');
                window.history.replaceState({}, document.title, url.toString());
            });
        </script>
    <?php endif; ?>

    <section class="section">
        <div class="card">
            <ul class="nav nav-tabs">
                <li class="nav-item"></li>
                <a class="nav-link" href="/admin/tienda/crearTienda">Crear Tienda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/admin/tienda/tablaTienda">Tiendas</a>
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
                        <h4 class="card-title">EDITAR TIENDA EXISTENTE</h4>
                        <?php include_once __DIR__ . '/../../templates/alertas.php'  ?>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="/admin/tienda/editarTienda?id=<?php echo $tienda->id; ?>" onsubmit="return bloquearBoton(this)">
                                <div class="row">


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Codigo_Tienda">Codigo_Tienda</label>
                                            <input type="number" id="Codigo_Tienda" class="form-control"
                                                placeholder="Codigo_Tienda" name="Codigo_Tienda"
                                                value="<?php echo s($tienda->Codigo_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Nombre_Tienda">Nombre_Tienda</label>
                                            <input type="text" id="Nombre_Tienda" class="form-control"
                                                placeholder="Nombre_Tienda" name="Nombre_Tienda"
                                                value="<?php echo s($tienda->Nombre_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Nombre_Tienda">Nombre_Tienda</label>
                                            <input type="text" id="Nombre_Tienda" class="form-control"
                                                placeholder="Nombre_Tienda" name="Nombre_Tienda"
                                                value="<?php echo s($tienda->Nombre_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Direccion_Tienda">Direccion_Tienda</label>
                                            <input type="text" id="Direccion_Tienda" class="form-control"
                                                placeholder="Direccion_Tienda" name="Direccion_Tienda"
                                                value="<?php echo s($tienda->Direccion_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Telefono_Tienda">Telefono_Tienda</label>
                                            <input type="number" id="Telefono_Tienda" class="form-control"
                                                placeholder="Telefono_Tienda" name="Telefono_Tienda"
                                                value="<?php echo s($tienda->Telefono_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Telefono1_Tienda">Telefono1_Tienda</label>
                                            <input type="number" id="Telefono1_Tienda" class="form-control"
                                                placeholder="Telefono1_Tienda" name="Telefono1_Tienda"
                                                value="<?php echo s($tienda->Telefono1_Tienda); ?>">
                                        </div>
                                    </div>



                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Fax_Tienda">Fax_Tienda</label>
                                            <input type="text" id="Fax_Tienda" class="form-control"
                                                placeholder="Fax_Tienda" name="Fax_Tienda"
                                                value="<?php echo s($tienda->Fax_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Email_Tienda">Email_Tienda</label>
                                            <input type="text" id="Email_Tienda" class="form-control"
                                                placeholder="Email_Tienda" name="Email_Tienda"
                                                value="<?php echo s($tienda->Email_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Ciudad_Tienda">Ciudad_Tienda</label>
                                            <input type="text" id="Ciudad_Tienda" class="form-control"
                                                placeholder="Ciudad_Tienda" name="Ciudad_Tienda"
                                                value="<?php echo s($tienda->Ciudad_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Pais_Tienda">Pais_Tienda</label>
                                            <input type="text" id="Pais_Tienda" class="form-control"
                                                placeholder="Pais_Tienda" name="Pais_Tienda"
                                                value="<?php echo s($tienda->Pais_Tienda); ?>">
                                        </div>
                                    </div>



                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Contacto_Tienda">Contacto_Tienda</label>
                                            <input type="text" id="Contacto_Tienda" class="form-control"
                                                placeholder="Contacto_Tienda" name="Contacto_Tienda"
                                                value="<?php echo s($tienda->Contacto_Tienda); ?>">
                                        </div>
                                    </div>



                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Tipo_Tienda">Tipo_Tienda</label>
                                            <input type="text" id="Tipo_Tienda" class="form-control"
                                                placeholder="Tipo_Tienda" name="Tipo_Tienda"
                                                value="<?php echo s($tienda->Tipo_Tienda); ?>">
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Foto_Tienda">Subir archivo (PDF o imagen)</label>
                                            <input type="file" class="form-control" id="Foto_Tienda" name="Foto_Tienda" accept="application/pdf,image/*">
                                            <small class="form-text text-muted">Se permiten archivos PDF o imágenes.</small>
                                        </div>
                                    </div>

                                    <?php if (isset($tienda->Foto_Tienda)) : ?>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Archivo actual:</label><br>
                                                <a href="<?php echo $_ENV['HOST'] . '/src/tiendas/' . $tienda->Foto_Tienda; ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    Ver / Descargar archivo
                                                </a>
                                                <br><br>

                                                <?php if ($tienda->Foto_Tienda): ?>
                                                    <div id="archivo-actual">
                                                        <p>Archivo actual: <?php echo htmlspecialchars($tienda->Foto_Tienda); ?></p>
                                                        <a href="#"
                                                            id="btnEliminarArchivo"
                                                            data-id="<?php echo $tienda->id; ?>"
                                                            class="btn btn-danger btn-sm">
                                                            Eliminar archivo
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const btnEliminar = document.getElementById('btnEliminarArchivo'); // aquí el mismo ID del HTML

                                            if (btnEliminar) {
                                                btnEliminar.addEventListener('click', function(e) {
                                                    e.preventDefault();

                                                    Swal.fire({
                                                        title: '¿Estás seguro?',
                                                        text: 'No podrás recuperar este archivo después de eliminarlo.',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Sí, eliminar',
                                                        cancelButtonText: 'Cancelar'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            const idTurno = this.dataset.id;

                                                            fetch('/admin/diseno/eliminarPDFturno', {
                                                                    method: 'POST',
                                                                    headers: {
                                                                        'Content-Type': 'application/x-www-form-urlencoded'
                                                                    },
                                                                    body: 'id=' + encodeURIComponent(idTurno)
                                                                })
                                                                .then(res => res.json())
                                                                .then(data => {
                                                                    if (data.success) {
                                                                        Swal.fire({
                                                                            icon: 'success',
                                                                            title: '¡Eliminado!',
                                                                            text: 'El archivo se eliminó correctamente.'
                                                                        });

                                                                        // Ojo: tu HTML usa id="archivo-actual", no "pdf-actual"
                                                                        document.getElementById('archivo-actual').innerHTML = '<p>Archivo eliminado correctamente.</p>';
                                                                    } else {
                                                                        Swal.fire({
                                                                            icon: 'error',
                                                                            title: 'Error',
                                                                            text: data.error || 'Ocurrió un error al eliminar el archivo.'
                                                                        });
                                                                    }
                                                                })
                                                                .catch(err => {
                                                                    console.error('Error AJAX:', err);
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: 'Error',
                                                                        text: 'Error en la solicitud. Intenta de nuevo.'
                                                                    });
                                                                });
                                                        }
                                                    });
                                                });
                                            }
                                        });
                                    </script>





                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="btnRegistrar" class="btn btn-primary me-1 mb-1">Actualizar</button>
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
<!-- <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header> -->

<!-- <div class="page-heading"> -->


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


<section class="section">
    <div class="card">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="/admin/notaPedido/crearNota">Crear Nota de Pedido</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/admin/notaPedido/crearTienda?id=<?php echo $id_nota; ?>">Lista de Tiendas</a>
            </li>
        </ul>
    </div>
</section>




<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <!-- <div class="card"> -->
            <div class="card-content mt-0">
                <div class="card-body">
                    <div class="alert alert-info py-2">
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



<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <!-- <div class="card"> -->
            <div class="card-content mt-0">
                <div class="card-body">
                    <div class="alert alert-secondary py-2">
                        <div class="row align-items-center">

                            <div class="col-md-3 col-6">
                                <small class="text-muted"><b>Tienda</b></small><br>
                                <span class="fw-bold"><?php echo $tienda_nota->tienda ?? '-'; ?></span>
                            </div>

                            <div class="col-md-2 col-6">
                                <small class="text-muted"><b>Marca</b></small><br>
                                <span class="fw-bold"><?php echo $tienda_nota->marca ?? '-'; ?></span>
                            </div>

                            <div class="col-md-2 col-6">
                                <small class="text-muted"><b>Pais</b></small><br>
                                <span class="fw-bold"><?php echo $tienda_nota->pais ?? '-'; ?></span>
                            </div>

                            <div class="col-md-2 col-6">
                                <small class="text-muted"><b>Fecha</b></small><br>
                                <span class="fw-bold"><?php echo date("d/m/Y", strtotime($tienda_nota->fecha)) ?></span>
                            </div>

                            <div class="col-md-2 col-12">
                                <small class="text-muted"><b>Num_Factura</b></small><br>
                                <span class="fw-bold"><?php echo $tienda_nota->num_factura ?? '-'; ?></span>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
</section>









<?php
// Helper para “old values”
$old      = $old ?? [];
$oldVal   = function ($key, $default = '') use ($old) {
    return htmlspecialchars($old[$key] ?? $default);
};
$selIf    = function ($left, $right) {
    return ((string)$left === (string)$right) ? 'selected' : '';
};
?>






<!-- ====== Modal para agregar una nueva prenda (IDs únicos, mismos NAME) ====== -->
<div class="modal fade" id="modalNuevaPrenda" tabindex="-1" aria-labelledby="modalNuevaPrendaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalNuevaPrendaLabel">Agregar nueva prenda</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form id="formNuevaPrenda" method="POST" action="/admin/prenda/crearPrenda" onsubmit="return false">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Prenda_Partida" class="form-label">Nombre de la prenda</label>
                        <!-- NAME igual; ID distinto para no chocar -->
                        <input type="text" class="form-control" id="Prenda_Partida" name="Prenda_Partida" required>
                    </div>
                    <div class="mb-3">
                        <label for="Partida_Partida" class="form-label">Partida</label>
                        <input type="number" class="form-control" id="Partida_Partida" name="Partida_Partida" required>
                    </div>
                    <div class="mb-3">
                        <label for="Composicion_Partida" class="form-label">Composición</label>
                        <input type="text" class="form-control" id="Composicion_Partida" name="Composicion_Partida" required>
                    </div>

                    <div class="alert alert-danger d-none" id="np_errorBox"></div>
                    <div class="alert alert-success d-none" id="np_okBox">Prenda guardada.</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="np_btnGuardar">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="np_spinner" role="status" aria-hidden="true"></span>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        // ======= refs =======
        const form = document.getElementById('formNuevaPrenda');
        const btn = document.getElementById('np_btnGuardar');
        const spinner = document.getElementById('np_spinner');
        const errorBox = document.getElementById('np_errorBox');
        const okBox = document.getElementById('np_okBox');
        const modalEl = document.getElementById('modalNuevaPrenda');

        // Mantiene tus IDs, pero asegura que apunte al <select> fuera del modal
        const prendaSelect = (() => {
            const nodes = document.querySelectorAll('select[name="Prenda_Partida"], select#Prenda_Partida');
            return Array.from(nodes).find(el => !modalEl.contains(el)) || nodes[0] || null;
        })();

        // ======= helpers =======
        function showError(msg) {
            errorBox.textContent = msg || 'No se pudo guardar.';
            errorBox.classList.remove('d-none');
            okBox.classList.add('d-none');
        }

        function showOK(msg) {
            okBox.textContent = msg || '¡Guardada!';
            okBox.classList.remove('d-none');
            errorBox.classList.add('d-none');
        }

        function setLoading(v) {
            if (btn) btn.disabled = v;
            if (spinner) spinner.classList.toggle('d-none', !v);
        }

        function scrubBackdrops() {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        }

        function showSavedToast() {
            if (window.Swal && typeof Swal.fire === 'function') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Prenda guardada',
                    showConfirmButton: false,
                    timer: 1200,
                    timerProgressBar: true,
                    backdrop: false
                });
            } else {
                showOK('Prenda guardada');
                setTimeout(() => okBox.classList.add('d-none'), 1200);
            }
        }

        // ======= submit =======
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            setLoading(true);
            errorBox.classList.add('d-none');
            okBox.classList.add('d-none');

            try {
                const fd = new FormData(form);

                const res = await fetch('/admin/prenda/crearPrenda', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: fd
                });

                const raw = await res.text();
                let data = null;
                try {
                    data = JSON.parse(raw);
                } catch {}

                if (!res.ok || !data || data.ok !== true) {
                    const msg = (data && data.error) ? data.error : 'Error al guardar la prenda.';
                    showError(msg);
                    setLoading(false);
                    return;
                }

                const nombre = (data.prenda && data.prenda.Prenda_Partida) || fd.get('Prenda_Partida') || '';

                // Resetea formulario
                form.reset();

                const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                const isOpen = modalEl.classList.contains('show');

                if (isOpen) {
                    modalEl.addEventListener('hidden.bs.modal', () => {
                        scrubBackdrops();
                        showSavedToast();
                        // 🔄 Recargar página después del toast
                        setTimeout(() => location.reload(), 1300);
                    }, {
                        once: true
                    });

                    bsModal.hide();
                } else {
                    showSavedToast();
                    setTimeout(() => location.reload(), 1300);
                }
            } catch (err) {
                showError('Error de red o servidor.');
            } finally {
                setLoading(false);
            }
        });

        // ======= limpiar mensajes al abrir modal =======
        modalEl.addEventListener('show.bs.modal', () => {
            errorBox.classList.add('d-none');
            okBox.classList.add('d-none');
        });

        // ======= seguridad extra: limpiar backdrop =======
        modalEl.addEventListener('hidden.bs.modal', () => {
            scrubBackdrops();
        });
    })();
</script>

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">

                <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

                <div class="card-content">
                    <div class="card-body">
                        <form class="form"
                            method="POST"
                            action="/admin/pruebas/crearPruebas"
                            enctype="multipart/form-data"
                            onsubmit="return bloquearBoton(this)">

                            <input type="hidden" name="id_nota" value="<?= htmlspecialchars($id_nota ?? '') ?>">
                            <input type="hidden" name="id_tienda" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">

                            <div class="row">


                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <label for="cantidad">Cantidad</label>
                                        <input type="number"
                                            id="cantidad"
                                            class="form-control"
                                            name="cantidad"
                                            step="1"
                                            value="<?= $oldVal('cantidad', '0') ?>">
                                    </div>
                                </div>

                                <!-- # Factura -->
                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <label for="etiqueta"># Etiq</label>
                                        <input type="text"
                                            id="etiqueta"
                                            class="form-control"
                                            placeholder="# Etiq"
                                            name="etiqueta"
                                            value="<?= $oldVal('etiqueta') ?>">
                                    </div>
                                </div>


                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <label for="saldo">Saldo</label>
                                        <input type="number"
                                            id="saldo"
                                            class="form-control"
                                            name="saldo"
                                            step="1"
                                            value="<?= $oldVal('saldo', '0') ?>" readonly>
                                    </div>
                                </div>



                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="num_factura"># Factura</label>
                                        <input type="text"
                                            id="num_factura"
                                            class="form-control"
                                            placeholder="# Factura"
                                            name="num_factura"
                                            value="<?php echo $tienda_nota->num_factura ?>" readonly>
                                    </div>
                                </div>



                                <div class="col-md-3 col-12">
                                    <div class="form-group d-flex align-items-end">
                                        <div class="flex-grow-1">
                                            <label for="Prenda_Partida">Prenda</label>
                                            <select id="Prenda_Partida" class="choices form-control" name="Prenda_Partida">
                                                <option value="" disabled selected>Seleccione una prenda</option>
                                                <?php foreach ($prendas as $p) : ?>
                                                    <option value="<?= htmlspecialchars($p->Prenda_Partida) ?>">
                                                        <?= htmlspecialchars($p->Prenda_Partida) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Botón + para abrir el modal -->
                                        <button type="button" class="btn btn-outline-primary ms-2 mb-1"
                                            data-bs-toggle="modal" data-bs-target="#modalNuevaPrenda">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>









                                <!-- 

                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="partida">Partida</label>
                                        <input type="text"
                                            id="partida"
                                            class="form-control"
                                            placeholder="Partida"
                                            name="partida"
                                            value="<?= $oldVal('partida') ?>">
                                    </div>
                                </div> -->



                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="composicion">Composicion</label>
                                        <input type="text"
                                            id="composicion"
                                            class="form-control"
                                            placeholder="# Composicion"
                                            name="composicion"
                                            value="<?= $oldVal('composicion') ?>">
                                    </div>
                                </div>






                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <label for="precio_unitario">Precio/Un</label>
                                        <input type="number"
                                            id="precio_unitario"
                                            class="form-control"
                                            name="precio_unitario"
                                            step="0.01"
                                            value="<?= $oldVal('precio_unitario', '0.00') ?>">
                                    </div>
                                </div>

                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <label for="total">Total</label>
                                        <input type="number"
                                            id="total"
                                            class="form-control"
                                            name="total"
                                            step="0.01"
                                            value="<?= $oldVal('total', '0.00') ?>" readonly>
                                    </div>
                                </div>

                                <script>
                                    // cada vez que cambien cantidad o etiqueta
                                    const cantidad = document.getElementById('cantidad');
                                    const precio_unitario = document.getElementById('precio_unitario');
                                    const etiqueta = document.getElementById('etiqueta');
                                    const saldo = document.getElementById('saldo');
                                    const total = document.getElementById('total');

                                    function actualizarSaldo() {
                                        const cant = parseFloat(cantidad.value) || 0;
                                        const etiq = parseFloat(etiqueta.value) || 0;
                                        saldo.value = cant - etiq; // o usa la fórmula que necesites
                                    }

                                    function actualizarPrecioTotal() {
                                        const cant = parseFloat(cantidad.value) || 0;
                                        const precioUni = parseFloat(precio_unitario.value) || 0;
                                        total.value = (cant * precioUni).toFixed(2);
                                    }

                                    cantidad.addEventListener('input', function() {
                                        actualizarSaldo();
                                        actualizarPrecioTotal(); // Trigger total update when quantity changes
                                    });
                                    etiqueta.addEventListener('input', actualizarSaldo);
                                    precio_unitario.addEventListener('input', actualizarPrecioTotal);
                                </script>



                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="tienda">Tienda</label>
                                        <input type="text"
                                            id="tienda"
                                            class="form-control"
                                            placeholder="Tienda"
                                            name="tienda"
                                            value="<?php echo $tienda_nota->tienda ?>" readonly>
                                    </div>
                                </div>





                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="marca">Marca</label>
                                        <input type="text"
                                            id="marca"
                                            class="form-control"
                                            placeholder="Marca"
                                            name="marca"
                                            value="<?php echo $tienda_nota->marca ?>" readonly>
                                    </div>
                                </div>



                                <!-- pais -->

                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="pais">País</label>
                                        <select id="pais" class="choices form-control" name="pais">
                                            <option value="" disabled <?= empty($old['pais']) ? 'selected' : '' ?>>
                                                Seleccione
                                            </option>

                                            <?php foreach ($paises as $p): ?>
                                                <?php
                                                // Verificar que la propiedad exista y evitar null en htmlspecialchars
                                                $paisOrigen = isset($p->Pais_Origen) ? $p->Pais_Origen : '';
                                                ?>
                                                <option value="<?= htmlspecialchars((string)$paisOrigen, ENT_QUOTES, 'UTF-8') ?>"
                                                    <?= $selIf(($old['pais'] ?? ''), $paisOrigen) ?>>
                                                    <?= htmlspecialchars((string)$paisOrigen, ENT_QUOTES, 'UTF-8') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>






                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad</label>
                                        <input type="text"
                                            id="ciudad"
                                            class="form-control"
                                            placeholder="Ciudad"
                                            name="ciudad"
                                            value="<?php echo $tienda_nota->ciudad ?>" readonly>
                                    </div>
                                </div>




                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <label for="num_caja">#caja</label>
                                        <input type="number"
                                            id="num_caja"
                                            class="form-control"
                                            name="num_caja"
                                            step="1"
                                            value="<?= $oldVal('num_caja', '0') ?>">
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="bodega">Bodega</label>
                                        <select id="bodega" class="choices form-control" name="bodega">
                                            <option value="" disabled <?= empty($old['bodega']) ? 'selected' : '' ?>>
                                                Seleccione
                                            </option>
                                            <?php foreach ($bodega as $b) : ?>
                                                <option value="<?= htmlspecialchars($b->Sigla_Bodega) ?>"
                                                    <?= $selIf(($old['bodega'] ?? ''), $b->Sigla_Bodega) ?>>
                                                    <?= htmlspecialchars($b->Sigla_Bodega) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Bodega -->

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Agregar</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Limpiar</button>
                                    </div>

                                </div> <!-- /.row -->
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>










<!-- ====== Bootstrap 5 & Icons ====== -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ====== Handsontable ====== -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.css">
<script src="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.js"></script>

<style>
    .hot-card {
        border: 1px solid #e9ecef;
        box-shadow: 0 6px 24px rgba(33, 37, 41, .06);
        border-radius: 1rem;
        overflow: hidden
    }

    .hot-toolbar .btn {
        border-radius: .6rem
    }

    #hot-min {
        height: clamp(160px, 60vh, 99940px) !important;
    }

    .handsontable th,
    .handsontable td {
        font-size: .95rem;
        white-space: nowrap;
    }

    .handsontable .ht_clone_top th,
    .handsontable .ht_clone_top td {
        background-color: #f8f9fa
    }

    .hot-badge {
        font-size: .7rem;
        letter-spacing: .02em
    }

    .text-mono {
        font-variant-numeric: tabular-nums;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace
    }
</style>

<div class="container-xxl my-4">
    <div class="hot-card">
        <div class="p-3 p-md-4 border-bottom bg-white">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5 class="mb-1 d-flex align-items-center gap-2">
                        Administrar prendas para Nota de Pedido N° <?= htmlspecialchars($id_nota) ?>
                        <span class="badge text-bg-light hot-badge">Handsontable</span>
                    </h5>
                    <div class="text-secondary small">Pega desde Excel: selecciona A1 y usa <kbd>Ctrl/⌘ + V</kbd></div>
                </div>
                <div class="hot-toolbar d-flex align-items-center gap-2">
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input" type="checkbox" id="autosave" checked>
                        <label class="form-check-label small" for="autosave">Autosave al pegar/editar</label>
                    </div>
                    <button id="guardar-nuevas" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar <span class="d-none d-sm-inline">NUEVAS filas</span>
                    </button>
                    <button id="recargar" class="btn btn-outline-secondary"><i class="bi bi-arrow-repeat me-1"></i> Recargar</button>
                </div>
            </div>
        </div>

        <div class="p-2 p-md-3 bg-light-subtle">
            <div class="table-responsive">
                <div id="hot-min" class="bg-white rounded-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal eliminar -->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-2"></i> Confirmar eliminación</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body pt-0">¿Eliminar este registro definitivamente?</div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnConfirmDelete" class="btn btn-danger"><i class="bi bi-trash me-1"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Toasts -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
    <div id="toastOk" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"><i class="bi bi-check-circle me-2"></i> Operación realizada.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <div id="toastErr" class="toast align-items-center text-bg-danger border-0 mt-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"><i class="bi bi-x-circle me-2"></i> No se pudo procesar.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>




<script>
    // ---------- Puentes PHP ----------
    const ID_NOTA = <?= json_encode($id_nota ?? null) ?>;

    const tienda = <?= json_encode($tienda_nota->tienda ?? '') ?>;
    const marca = <?= json_encode($tienda_nota->marca ?? '') ?>;
    const pais = <?= json_encode($tienda_nota->pais ?? '') ?>;
    const ciudad = <?= json_encode($tienda_nota->ciudad ?? '') ?>;
    const num_factura = <?= json_encode($tienda_nota->num_factura ?? '') ?>;

    console.log(num_factura)

    const ID_TIENDA = <?= json_encode($_GET['id'] ?? '') ?>;

    const existentes = <?php
                        $idUrl = $id_nota ?? null;
                        $id_tienda = $_GET['id'] ?? null;

                        $out = [];
                        if (!empty($carritoTemporal2)) {
                            foreach ($carritoTemporal2 as $r) {
                                if ($idUrl != $r->Codigo_Nota_Pedido || $id_tienda != $r->id_tienda) continue;
                                $precio = isset($r->precio_unitario) ? (float)$r->precio_unitario : 0.0;
                                $cant   = isset($r->cantidad) ? (float)$r->cantidad : 0.0;
                                $out[]  = [
                                    'id'                 => (int)$r->id,
                                    'codigo_nota_pedido' => $r->Codigo_Nota_Pedido,
                                    'etiqueta'           => $r->etiqueta,
                                    'prenda'             => $r->prenda,
                                    'saldo'              => $r->saldo,
                                    'composicion'        => $r->composicion,
                                    'cantidad'           => $cant,
                                    'precio_unitario'    => $precio,
                                    'num_factura'        => $r->num_factura,
                                    'tienda'             => $r->tienda,
                                    'marca'              => $r->marca,
                                    'pais'               => $r->pais,
                                    'num_caja'           => $r->num_caja,
                                    'bodega'             => $r->bodega,
                                    'id_tienda'          => $r->id_tienda,
                                    'total'              => round($cant * $precio, 2),
                                ];
                            }
                        }
                        echo json_encode($out, JSON_UNESCAPED_UNICODE);
                        ?>;

    // ---------- Utils UI ----------
    const toastOk = new bootstrap.Toast(document.getElementById('toastOk'), {
        delay: 1800
    });
    const toastErr = new bootstrap.Toast(document.getElementById('toastErr'), {
        delay: 2600
    });
    const modalDelete = new bootstrap.Modal(document.getElementById('modalConfirmDelete'));
    let rowPendingDelete = null;

    function round(n) {
        return Math.round((n + Number.EPSILON) * 100) / 100;
    }

    // ---------- Handsontable ----------
    const container = document.getElementById('hot-min');

    const AUTOSAVE_PROPS = new Set([
        'cantidad', 'etiqueta', 'saldo', 'num_factura', 'prenda', 'composicion',
        'precio_unitario', 'tienda', 'marca', 'pais', 'num_caja', 'bodega',
    ]);

    function str(v) {
        return (v ?? '').toString().trim();
    }

    // ✅ Regla: para crear una fila nueva, debe tener “clave”
    function hasKeyData(r) {
        // Cambia esta regla si tu clave real es otra
        return str(r?.etiqueta) !== '' || str(r?.prenda) !== '';
    }

    function isEmptySpareRow(r) {
        if (!r) return true;
        return !r.id && !hasKeyData(r) && !(Number(r.cantidad) || 0) && !(Number(r.precio_unitario) || 0);
    }

    const hot = new Handsontable(container, {
        data: existentes.length ? existentes : [],
        colHeaders: [
            'id', 'cod', 'cantid', 'etq', 'saldo', 'num_fact', 'prenda', 'composicion',
            'precio_u', 'tienda', 'marca', 'pais', 'num_caja', 'bodega', 'total', 'Acciones'
        ],
        columns: [{
                data: 'id',
                readOnly: true
            },

            {
                data: 'codigo_nota_pedido',
                readOnly: true,
                renderer: (inst, td, row, col, prop, val) => {
                    td.textContent = val ?? (ID_NOTA ?? '');
                }
            },

            {
                data: 'cantidad',
                type: 'numeric',
                numericFormat: {
                    pattern: '0.[000]'
                }
            },

            {
                data: 'etiqueta'
            },

            {
                data: 'saldo',
                readOnly: true,
                renderer(inst, td, row) {
                    const r = inst.getSourceDataAtRow(row) || {};
                    const cant = Number(r.cantidad) || 0;
                    const etqN = Number(r.etiqueta) || 0; // si etiqueta es número
                    const tot = round(cant - etqN);
                    r.saldo = tot;
                    td.classList.add('text-end', 'text-mono');
                    td.textContent = tot.toFixed(2);
                }
            },

            {
                data: 'num_factura',
                renderer: (inst, td, row) => {
                    //   const r = inst.getSourceDataAtRow(row) || {};
                    //   td.textContent = r.num_factura || num_factura || '';
                    const r = inst.getSourceDataAtRow(row) || {};
                    td.textContent = r.num_factura || num_factura || '';
                }
            },

            {
                data: 'prenda'
            },
            {
                data: 'composicion'
            },

            {
                data: 'precio_unitario',
                type: 'numeric',
                numericFormat: {
                    pattern: '0.[00]'
                }
            },

            {
                data: 'tienda',
                renderer: (inst, td, row) => {
                    const r = inst.getSourceDataAtRow(row) || {};
                    td.textContent = r.tienda || tienda || '';
                }
            },

            {
                data: 'marca',
                renderer: (inst, td, row) => {
                    const r = inst.getSourceDataAtRow(row) || {};
                    td.textContent = r.marca || marca || '';
                }
            },

            {
                data: 'pais',
                renderer: (inst, td, row) => {
                    const r = inst.getSourceDataAtRow(row) || {};
                    td.textContent = r.pais || pais || '';
                }
            },

            {
                data: 'num_caja',
                renderer: (inst, td, row) => {
                    const r = inst.getSourceDataAtRow(row) || {};
                    td.textContent = r.num_caja || '';
                }
            },
            {
                data: 'bodega',
                renderer: (inst, td, row) => {
                    const r = inst.getSourceDataAtRow(row) || {};
                    td.textContent = r.bodega || '';
                }
            },

            {
                data: 'total',
                readOnly: true,
                renderer(inst, td, row) {
                    const r = inst.getSourceDataAtRow(row) || {};
                    const cant = Number(r.cantidad) || 0;
                    const pu = Number(r.precio_unitario) || 0;
                    const tot = round(cant * pu);
                    r.total = tot;
                    td.classList.add('text-end', 'text-mono');
                    td.textContent = tot.toFixed(2);
                }
            },

            {
                readOnly: true,
                renderer(inst, td, row) {
                    td.classList.add('text-center');
                    td.innerHTML = `
            <button class="btn btn-outline-danger btn-sm btn-del" data-row="${row}">
              <i class="bi bi-trash me-1"></i>Eliminar
            </button>`;
                }
            },
        ],

        rowHeaders: true,
        stretchH: 'all',
        height: container.clientHeight,
        licenseKey: 'non-commercial-and-evaluation',

        filters: true,
        dropdownMenu: true,
        columnSorting: true,
        manualColumnResize: true,
        manualRowResize: true,

        minSpareRows: 1,
        allowInsertColumn: false,
        allowRemoveColumn: false,

        afterChange(changes, source) {
            if (!changes || source === 'loadData') return;

            const rowsToUpdate = new Set();
            for (const [row, prop] of changes) {
                if (!AUTOSAVE_PROPS.has(prop)) continue;
                rowsToUpdate.add(row);
            }
            if (rowsToUpdate.size) {
                rowsToUpdate.forEach(r => recalcRow(r));
                maybeAutosave([...rowsToUpdate]);
            }
        },

        // afterPaste(){
        //   const len = hot.countRows();
        //   for (let i=0; i<len; i++) recalcRow(i);
        //   maybeAutosave([...Array(len).keys()]);
        // }

        afterPaste: async function() {
            const len = hot.countRows();
            for (let i = 0; i < len; i++) recalcRow(i);

            // si autosave está activado, guardo primero y luego recargo
            if (document.getElementById('autosave')?.checked) {
                await maybeAutosave([...Array(len).keys()]);
            }


            Swal.fire({
                title: 'Pega realizada',
                text: 'Los datos han sido pegados correctamente.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            setTimeout(() => location.reload(), 1000);
            // recarga total 1 segundo después (ajusta si quieres)
        }



    });

    window.addEventListener('resize', () => hot.updateSettings({
        height: container.clientHeight
    }));

    function recalcRow(rowIndex) {
        const r = hot.getSourceDataAtRow(rowIndex);
        if (!r) return;

        if (!r.codigo_nota_pedido && ID_NOTA) r.codigo_nota_pedido = ID_NOTA;

        r.cantidad = Number(r.cantidad) || 0;
        r.etiqueta = (typeof r.etiqueta === 'string') ? r.etiqueta.trim() : r.etiqueta;
        r.prenda = (typeof r.prenda === 'string') ? r.prenda.trim() : r.prenda;
        r.saldo = Number(r.saldo) || 0;
        r.composicion = (typeof r.composicion === 'string') ? r.composicion.trim() : r.composicion;

        // r.num_factura = Number(r.num_factura) || 0;
        r.num_factura = str(r.num_factura);

        r.precio_unitario = Number(r.precio_unitario) || 0;

        r.tienda = str(r.tienda) || tienda || '';
        r.marca = str(r.marca) || marca || '';
        r.pais = str(r.pais) || pais || '';

        r.num_caja = str(r.num_caja) || '';
        r.bodega = str(r.bodega) || '';
        r.id_tienda = ID_TIENDA;

        r.total = round(r.cantidad * r.precio_unitario);

        hot.render();
    }

    function filasNuevas() {
        // ✅ Solo filas sin id y con “clave” (no por solo cantidad)
        return hot.getSourceData().filter(r => r && !r.id && hasKeyData(r));
    }

    async function saveOrUpdateFila(row) {
        // ✅ Si no tiene id, NO crear si no hay clave
        if (!row.id && !hasKeyData(row)) return true;

        const fd = new FormData();
        fd.append('id_nota', ID_NOTA ?? row.codigo_nota_pedido ?? '');
        if (row.id) fd.append('id', row.id);

        fd.append('cantidad', row.cantidad ?? 0);
        fd.append('etiqueta', row.etiqueta ?? '');
        fd.append('saldo', row.saldo ?? 0);
        // fd.append('num_factura', num_factura ?? row.num_factura ?? 0);
        fd.append('num_factura', str(row.num_factura) || (num_factura ?? ''));

        fd.append('prenda', row.prenda ?? '');
        fd.append('composicion', row.composicion ?? '');
        fd.append('precio_unitario', row.precio_unitario ?? 0);
        fd.append('tienda', row.tienda ?? '');
        fd.append('marca', row.marca ?? '');
        fd.append('pais', row.pais ?? '');
        fd.append('num_caja', str(row.num_caja) || '');
        fd.append('bodega', row.bodega ?? '');
        fd.append('id_tienda', ID_TIENDA);
        fd.append('total', row.total ?? 0);

        const url = row.id ? '/admin/pruebas/actualizarPruebas' : '/admin/pruebas/crearPruebasAjax';

        const resp = await fetch(url, {
            method: 'POST',
            body: fd,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        let json = null;
        try {
            json = await resp.json();
        } catch {}

        if (json?.ok) {
            if (json.id) row.id = json.id; // si fue insert o upsert
            row.codigo_nota_pedido = ID_NOTA || row.codigo_nota_pedido;
            row.tienda = row.tienda || tienda;
            row.marca = row.marca || marca;
            row.pais = row.pais || pais;
            row.num_factura = row.num_factura || num_factura;
            return true;
        }

        console.warn('saveOrUpdateFila error:', json);
        return false;
    }

    async function refreshTabla() {
        const resp = await fetch(`/admin/pruebas/listarPruebasAjax?id_nota=${encodeURIComponent(ID_NOTA)}&id_tienda=${encodeURIComponent(ID_TIENDA)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        const json = await resp.json();
        if (json?.ok && Array.isArray(json.data)) {
            hot.loadData(json.data);
            hot.render();
        }
    }



    async function guardarNuevasFilas(btn) {
        btn?.setAttribute('disabled', 'disabled');
        btn?.insertAdjacentHTML('afterbegin',
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>'
        );

        const nuevas = filasNuevas();
        let ok = true;

        for (const r of nuevas) {
            recalcRow(hot.getSourceData().indexOf(r));
            const exito = await saveOrUpdateFila(r);
            //   if (!exito) ok = false;
            // refreshTabla();
            refreshTabla().then(() => {
                console.log("Tabla actualizada después de guardar una nueva fila.");
            });
        }

        btn?.removeAttribute('disabled');
        btn?.querySelector('.spinner-border')?.remove();
        ok ? toastOk.show() : toastErr.show();
    }

    async function maybeAutosave(rowIdxList) {
        if (!document.getElementById('autosave')?.checked) return;

        let ok = true;

        for (const idx of rowIdxList) {
            const r = hot.getSourceDataAtRow(idx);
            if (!r) continue;

            // ✅ No guardes la spare row ni filas sin “clave”
            if (!r.id && !hasKeyData(r)) continue;
            if (isEmptySpareRow(r)) continue;

            const exito = await saveOrUpdateFila(r);
            if (!exito) ok = false;
        }

        ok ? toastOk.show() : toastErr.show();
    }

    document.getElementById('guardar-nuevas')?.addEventListener('click', (e) => guardarNuevasFilas(e.currentTarget));
    document.getElementById('recargar')?.addEventListener('click', () => location.reload());

    container.addEventListener('click', (ev) => {
        const btn = ev.target.closest('.btn-del');
        if (!btn) return;

        const rowIndex = parseInt(btn.dataset.row, 10);
        const rowData = hot.getSourceDataAtRow(rowIndex);

        if (!rowData?.id) {
            hot.alter('remove_row', rowIndex, 1);
            return;
        }
        rowPendingDelete = {
            rowIndex,
            rowData
        };
        modalDelete.show();
    });

    document.getElementById('btnConfirmDelete')?.addEventListener('click', async () => {
        const info = rowPendingDelete;
        rowPendingDelete = null;
        if (!info) return;

        const {
            rowIndex,
            rowData
        } = info;

        const fd = new FormData();
        fd.append('id_nota', ID_NOTA ?? rowData.codigo_nota_pedido ?? '');
        fd.append('id', rowData.id);

        try {
            const resp = await fetch('/admin/eliminarCarrito', {
                method: 'POST',
                body: fd,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            let json = null;
            try {
                json = await resp.json();
            } catch {}

            if (json?.ok) {
                hot.alter('remove_row', rowIndex, 1);
                toastOk.show();
            } else {
                toastErr.show();
            }
        } catch {
            toastErr.show();
        } finally {
            modalDelete.hide();
        }
    });
</script>



<script>
    // Si usas un plugin como Choices, inicialízalo DESPUÉS de que el HTML ya venga
    // con los <option selected> correctos.
    function bloquearBoton(form) {
        const btn = form.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
        }
        return true;
    }

    // 
</script>





<section class="section">
    <div class="card">


        <div class="card-body">


            <form action="/admin/pruebas/registrarVenta" method="POST">
                <!-- Fila 1 -->

                <div class="row">
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-4 col-12">
                                <div class="card" style="background-color: #dacdcdff;">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="form form-vertical">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="via_transporte">via_transporte</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="via_transporte"
                                                                        id="via_transporte" name="via_transporte">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="puerto_embarque">puerto_embarque</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="puerto_embarque"
                                                                        id="puerto_embarque" name="puerto_embarque">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="puerto_destino">puerto_destino</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="puerto_destino"
                                                                        id="puerto_destino" name="puerto_destino">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">

                            </div>
                            <div class="col-md-4 col-12">
                                <div class="card" style="background-color: #dacdcdff;">

                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="form form-vertical">
                                                <div class="form-body">
                                                    <div class="row">


                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="Fob_Nota_Pedido">Fob</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Fob"
                                                                        id="Fob_Nota_Pedido" name="Fob_Nota_Pedido">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="Flete_Nota_Pedido">Flete</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Flete"
                                                                        id="Flete_Nota_Pedido" name="Flete_Nota_Pedido">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="Costo_Flete_Nota_Pedido">Costo Flete</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Costo Flete"
                                                                        id="Costo_Flete_Nota_Pedido" name="Costo_Flete_Nota_Pedido">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="Seguro_Nota_Pedido">Seguro</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Seguro"
                                                                        id="Seguro_Nota_Pedido" name="Seguro_Nota_Pedido">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="total_valor_cif">Total Valor CIF</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Total Valor CIF"
                                                                        id="total_valor_cif" name="total_valor_cif">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" id="btnRegistrar" class="btn btn-primary me-1 mb-1">Registrar</button>

                    </div>
                </div>

            </form>
        </div>

    </div>
</section>


<style>
    #table1 th,
    #table1 td {
        white-space: nowrap;
    }
</style>




<script>
    function bloquearBoton(form) {
        const btn = form.querySelector('#btnRegistrar');
        btn.disabled = true; // Deshabilita el botón
        btn.innerText = "Registrando..."; // Cambia el texto (opcional)
        return true; // Permite que el formulario se envíe
    }
</script>



<style>
    .container,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl,
    .container-xxl {
        max-width: 100% !important;
    }


    @media (min-width: 992px) {
        #sidebar {
            display: none !important;
        }
    }



    #main {
        margin-left: 0 !important;
        padding: 2rem;
    }
</style>

</div>
<!-- <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header> -->

<div class="page-heading">


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

<!-- ====== Tabulator ====== -->
<link rel="stylesheet" href="https://unpkg.com/tabulator-tables@6.3.0/dist/css/tabulator.min.css">
<script src="https://unpkg.com/tabulator-tables@6.3.0/dist/js/tabulator.min.js"></script>

<style>
    .hot-card {
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        border-radius: 1.25rem;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.9);
    }

    .hot-toolbar .btn {
        border-radius: .85rem;
    }

    #hot-min {
        height: clamp(240px, 58vh, 820px) !important;
    }

    #hot-min .tabulator {
        border: 0;
        background: #fff;
        font-size: .92rem;
    }

    #hot-min .tabulator-header {
        border-bottom: 1px solid rgba(148, 163, 184, 0.24);
        background: #f8fafc;
    }

    #hot-min .tabulator-col,
    #hot-min .tabulator-cell {
        white-space: nowrap;
    }

    #hot-min .tabulator-row .tabulator-cell {
        border-right-color: rgba(226, 232, 240, 0.9);
    }

    #hot-min .tabulator-footer {
        display: none;
    }

    #hot-min .tabulator-tableholder {
        min-height: 320px;
    }

    #hot-min .tabulator-cell.tabulator-editing {
        outline: 2px solid rgba(13, 110, 253, 0.18);
        outline-offset: -2px;
        border-radius: .4rem;
    }

    .hot-badge {
        font-size: .7rem;
        letter-spacing: .02em;
    }

    .text-mono {
        font-variant-numeric: tabular-nums;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }

    .hot-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hot-meta {
        display: flex;
        align-items: center;
        gap: .65rem;
        flex-wrap: wrap;
        margin-top: .7rem;
    }

    .hot-pill {
        display: inline-flex;
        align-items: center;
        min-height: 2rem;
        padding: 0 .8rem;
        border-radius: 999px;
        background: rgba(15, 118, 110, 0.08);
        color: #115e59;
        font-size: .82rem;
        font-weight: 700;
    }

    .hot-pill--soft {
        background: rgba(15, 23, 42, 0.05);
        color: #475569;
    }

    .hot-status {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-size: .88rem;
        color: #475569;
        font-weight: 600;
    }

    .hot-status::before {
        content: "";
        width: .65rem;
        height: .65rem;
        border-radius: 999px;
        background: #94a3b8;
        box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.18);
    }

    .hot-status[data-tone="saving"]::before {
        background: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.16);
    }

    .hot-status[data-tone="success"]::before {
        background: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.16);
    }

    .hot-status[data-tone="error"]::before {
        background: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.16);
    }

    .hot-toolbar {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .hot-grid-shell {
        padding: .85rem 1rem 1rem;
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.9), rgba(241, 245, 249, 0.95));
    }

    .hot-empty-note {
        margin-top: .75rem;
        color: #64748b;
        font-size: .87rem;
    }

    @media (max-width: 768px) {
        .hot-toolbar {
            justify-content: flex-start;
        }
    }
</style>

<div class="container-xxl my-4">
    <div class="hot-card">
        <div class="p-3 p-md-4 border-bottom bg-white">
            <div class="hot-header">
                <div>
                    <h5 class="mb-1 d-flex align-items-center gap-2">
                        Administrar prendas para Nota de Pedido N° <?= htmlspecialchars($id_nota) ?>
                        <span class="badge text-bg-light hot-badge">Editor tabular</span>
                    </h5>
                    <div class="text-secondary small">Pega desde Excel: haz clic en una celda y usa <kbd>Ctrl/⌘ + V</kbd></div>
                    <div class="hot-meta">
                        <span id="hotRowCount" class="hot-pill">0 registros</span>
                        <span class="hot-pill hot-pill--soft">Sin recarga completa</span>
                        <span id="hotSaveState" class="hot-status" data-tone="idle">Listo para editar</span>
                    </div>
                </div>
                <div class="hot-toolbar">
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input" type="checkbox" id="autosave" checked>
                        <label class="form-check-label small" for="autosave">Autosave al pegar y editar</label>
                    </div>
                    <button id="guardar-nuevas" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar filas nuevas
                    </button>
                    <button id="recargar" class="btn btn-outline-secondary"><i class="bi bi-arrow-repeat me-1"></i> Sincronizar</button>
                </div>
            </div>
        </div>

        <div class="hot-grid-shell">
            <div class="table-responsive">
                <div id="hot-min" class="bg-white rounded-3"></div>
            </div>
            <div class="hot-empty-note">Usa la ultima fila vacia para agregar nuevos registros. Tambien puedes pegar rangos desde Excel y se llenaran desde la celda activa.</div>
        </div>
    </div>
</div>

<!-- Toasts -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
    <div id="toastOk" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div id="toastOkBody" class="toast-body"><i class="bi bi-check-circle me-2"></i> Operación realizada.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <div id="toastErr" class="toast align-items-center text-bg-danger border-0 mt-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div id="toastErrBody" class="toast-body"><i class="bi bi-x-circle me-2"></i> No se pudo procesar.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>




<script>
    window.__USE_TABULATOR_GRID__ = true;
</script>

<script>
    window.addEventListener('DOMContentLoaded', () => {
    if (window.__USE_TABULATOR_GRID__) return;
    // ---------- Puentes PHP ----------
    const ID_NOTA = <?= json_encode($id_nota ?? null) ?>;

    const tienda = <?= json_encode($tienda_nota->tienda ?? '') ?>;
    const marca = <?= json_encode($tienda_nota->marca ?? '') ?>;
    const pais = <?= json_encode($tienda_nota->pais ?? '') ?>;
    const ciudad = <?= json_encode($tienda_nota->ciudad ?? '') ?>;
    const num_factura = <?= json_encode($tienda_nota->num_factura ?? '') ?>;

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
    const hotRowCount = document.getElementById('hotRowCount');
    const hotSaveState = document.getElementById('hotSaveState');
    const toastOkBody = document.getElementById('toastOkBody');
    const toastErrBody = document.getElementById('toastErrBody');
    const rowSaveQueueMap = new Map();
    let nextDraftId = existentes.reduce((max, row) => {
        const currentId = Number(row?.id) || 0;
        return currentId > max ? currentId : max;
    }, 0) + 1;

    function round(n) {
        return Math.round((n + Number.EPSILON) * 100) / 100;
    }

    function showToast(type, message) {
        if (type === 'success') {
            if (toastOkBody) toastOkBody.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
            toastOk.show();
            return;
        }

        if (toastErrBody) toastErrBody.innerHTML = `<i class="bi bi-x-circle me-2"></i>${message}`;
        toastErr.show();
    }

    function setSaveState(message, tone = 'idle') {
        if (!hotSaveState) return;
        hotSaveState.dataset.tone = tone;
        hotSaveState.textContent = message;
    }

    function updateGridMeta() {
        if (!hotRowCount) return;
        const rows = hot.getSourceData().filter(r => r && (r.id || hasDraftData(r))).length;
        hotRowCount.textContent = `${rows} registro${rows === 1 ? '' : 's'}`;
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

    function hasDraftData(r) {
        if (!r) return false;

        return hasKeyData(r)
            || str(r?.composicion) !== ''
            || str(r?.num_factura) !== ''
            || str(r?.num_caja) !== ''
            || str(r?.bodega) !== ''
            || (Number(r?.cantidad) || 0) > 0
            || (Number(r?.precio_unitario) || 0) > 0;
    }

    function ensureDraftId(row) {
        if (!row || row.id || !hasDraftData(row)) return;
        if (!row._draftId) {
            row._draftId = nextDraftId++;
        }
    }

    function findSourceRowIndex(targetRow) {
        const sourceData = hot.getSourceData();

        return sourceData.findIndex((row) => {
            if (!row) return false;
            if (row === targetRow) return true;

            if (targetRow?._draftId && row._draftId === targetRow._draftId) {
                return true;
            }

            if (targetRow?.id && row.id === targetRow.id) {
                return true;
            }

            return false;
        });
    }

    function getRowQueueKey(row, rowIndex = null) {
        if (!row) return null;
        if (row.id) return `row-id:${row.id}`;

        ensureDraftId(row);
        if (row._draftId) return `row-draft:${row._draftId}`;

        if (rowIndex !== null && rowIndex >= 0) return `row-index:${rowIndex}`;
        return null;
    }

    async function queueRowSave(row, rowIndex = null) {
        if (!row || isEmptySpareRow(row)) return true;

        const queueKey = getRowQueueKey(row, rowIndex);
        if (!queueKey) return true;

        const existingEntry = rowSaveQueueMap.get(queueKey);
        if (existingEntry) {
            existingEntry.pending = true;
            return existingEntry.promise;
        }

        const entry = {
            pending: true,
            promise: null
        };

        entry.promise = (async () => {
            let ok = true;

            while (entry.pending) {
                entry.pending = false;
                const saved = await saveOrUpdateFila(row);
                if (!saved) {
                    ok = false;
                    break;
                }
            }

            rowSaveQueueMap.delete(queueKey);
            return ok;
        })();

        rowSaveQueueMap.set(queueKey, entry);
        return entry.promise;
    }

    function isEmptySpareRow(r) {
        if (!r) return true;
        return !r.id && !hasDraftData(r);
    }

    const hot = new Handsontable(container, {
        data: existentes.length ? existentes : [],
        colHeaders: [
            'id', 'cod', 'cantid', 'etq', 'saldo', 'num_fact', 'prenda', 'composicion',
            'precio_u', 'tienda', 'marca', 'pais', 'num_caja', 'bodega', 'total', 'Acciones'
        ],
        columns: [{
                data: 'id',
                readOnly: true,
                renderer(inst, td, row) {
                    const currentRow = inst.getSourceDataAtRow(row) || {};
                    const displayId = currentRow.id || currentRow._draftId || '';
                    td.classList.add('text-mono');
                    td.textContent = displayId;
                }
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

        async afterChange(changes, source) {
            if (!changes || source === 'loadData' || source === 'server-sync') return;

            const rowsToUpdate = new Set();
            for (const [row, prop] of changes) {
                if (!AUTOSAVE_PROPS.has(prop)) continue;
                rowsToUpdate.add(row);
            }
            if (rowsToUpdate.size) {
                setSaveState('Guardando cambios...', 'saving');
                rowsToUpdate.forEach(r => recalcRow(r));
                await maybeAutosave([...rowsToUpdate]);
            }
            updateGridMeta();
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
                setSaveState('Guardando filas pegadas...', 'saving');
                await maybeAutosave([...Array(len).keys()]);
                await refreshTabla();
            }

            showToast('success', 'Pega realizada correctamente.');
            setSaveState('Cambios sincronizados', 'success');
            updateGridMeta();
        }



    });

    window.addEventListener('resize', () => hot.updateSettings({
        height: container.clientHeight
    }));

    updateGridMeta();

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
        ensureDraftId(r);

        hot.render();
    }

    function filasNuevas() {
        // ✅ Solo filas sin id y con “clave” (no por solo cantidad)
        return hot.getSourceData().filter(r => r && !r.id && hasDraftData(r));
    }

    async function saveOrUpdateFila(row) {
        // ✅ Si no tiene id, NO crear si no hay clave
        if (!row.id && !hasDraftData(row)) return true;

        ensureDraftId(row);

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
            if (json.id) {
                row.id = Number(json.id);

                const rowIndex = findSourceRowIndex(row);
                if (rowIndex >= 0) {
                    hot.setDataAtRowProp(rowIndex, 'id', row.id, 'server-sync');
                }
            } else if (!row.id) {
                setSaveState('Sincronizando id de la fila...', 'saving');
                await refreshTabla();
            }
            row.codigo_nota_pedido = ID_NOTA || row.codigo_nota_pedido;
            row.tienda = row.tienda || tienda;
            row.marca = row.marca || marca;
            row.pais = row.pais || pais;
            row.num_factura = row.num_factura || num_factura;
            hot.render();
            return true;
        }

        console.warn('saveOrUpdateFila error:', json);
        return false;
    }

    async function refreshTabla() {
        setSaveState('Sincronizando tabla...', 'saving');
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
            updateGridMeta();
            setSaveState('Tabla actualizada', 'success');
            return true;
        }

        setSaveState('No se pudo sincronizar', 'error');
        return false;
    }



    async function guardarNuevasFilas(btn) {
        btn?.setAttribute('disabled', 'disabled');
        btn?.insertAdjacentHTML('afterbegin',
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>'
        );
        setSaveState('Guardando filas nuevas...', 'saving');

        const nuevas = filasNuevas();
        let ok = true;

        for (const r of nuevas) {
            recalcRow(hot.getSourceData().indexOf(r));
            const exito = await queueRowSave(r, hot.getSourceData().indexOf(r));
            if (!exito) ok = false;
        }

        if (ok) {
            await refreshTabla();
        }

        btn?.removeAttribute('disabled');
        btn?.querySelector('.spinner-border')?.remove();
        ok ? showToast('success', 'Filas nuevas guardadas.') : showToast('error', 'No se pudieron guardar todas las filas.');
        setSaveState(ok ? 'Guardado completado' : 'Hay filas pendientes de revisar', ok ? 'success' : 'error');
    }

    async function maybeAutosave(rowIdxList) {
        if (!document.getElementById('autosave')?.checked) return;

        let ok = true;

        for (const idx of rowIdxList) {
            const r = hot.getSourceDataAtRow(idx);
            if (!r) continue;

            // ✅ No guardes la spare row ni filas sin “clave”
            if (!r.id && !hasDraftData(r)) continue;
            if (isEmptySpareRow(r)) continue;

            const exito = await queueRowSave(r, idx);
            if (!exito) ok = false;
        }

        setSaveState(ok ? 'Autosave al día' : 'Error al guardar cambios', ok ? 'success' : 'error');
        updateGridMeta();
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
            updateGridMeta();
            setSaveState('Fila temporal eliminada', 'success');
            return;
        }

        Swal.fire({
            title: 'Eliminar fila',
            text: 'Esta acción eliminará el registro de forma definitiva.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#b91c1c',
            backdrop: false
        }).then(async (result) => {
            if (!result.isConfirmed) return;

            const fd = new FormData();
            fd.append('id_nota', ID_NOTA ?? rowData.codigo_nota_pedido ?? '');
            fd.append('id', rowData.id);
            setSaveState('Eliminando fila...', 'saving');

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
                    updateGridMeta();
                    showToast('success', 'Registro eliminado.');
                    setSaveState('Fila eliminada', 'success');
                } else {
                    showToast('error', 'No se pudo eliminar el registro.');
                    setSaveState('Error al eliminar', 'error');
                }
            } catch {
                showToast('error', 'Error de red al eliminar.');
                setSaveState('Error al eliminar', 'error');
            }
        });
    });
    });
</script>



<script>
    // Si usas un plugin como Choices, inicialízalo DESPUÉS de que el HTML ya venga
    // con los <option selected> correctos.
    </script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        if (!window.__USE_TABULATOR_GRID__) return;

        const ID_NOTA = <?= json_encode($id_nota ?? null) ?>;
        const tienda = <?= json_encode($tienda_nota->tienda ?? '') ?>;
        const marca = <?= json_encode($tienda_nota->marca ?? '') ?>;
        const pais = <?= json_encode($tienda_nota->pais ?? '') ?>;
        const num_factura = <?= json_encode($tienda_nota->num_factura ?? '') ?>;
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

        const container = document.getElementById('hot-min');
        const autosaveInput = document.getElementById('autosave');
        const hotRowCount = document.getElementById('hotRowCount');
        const hotSaveState = document.getElementById('hotSaveState');
        const toastOkBody = document.getElementById('toastOkBody');
        const toastErrBody = document.getElementById('toastErrBody');
        const toastOk = new bootstrap.Toast(document.getElementById('toastOk'), { delay: 1800 });
        const toastErr = new bootstrap.Toast(document.getElementById('toastErr'), { delay: 2600 });

        const rowSaveQueueMap = new Map();
        const editableFields = ['cantidad', 'etiqueta', 'num_factura', 'prenda', 'composicion', 'precio_unitario', 'tienda', 'marca', 'pais', 'num_caja', 'bodega'];
        let nextDraftId = 1;
        let activeCell = null;
        let gridFocused = false;
        let table = null;

        function round(n) {
            return Math.round((n + Number.EPSILON) * 100) / 100;
        }

        function str(value) {
            return (value ?? '').toString().trim();
        }

        function numberValue(value) {
            const normalized = typeof value === 'string' ? value.replace(',', '.') : value;
            const parsed = Number(normalized);
            return Number.isFinite(parsed) ? parsed : 0;
        }

        function showToast(type, message) {
            if (type === 'success') {
                if (toastOkBody) toastOkBody.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
                toastOk.show();
                return;
            }

            if (toastErrBody) toastErrBody.innerHTML = `<i class="bi bi-x-circle me-2"></i>${message}`;
            toastErr.show();
        }

        async function fetchJson(url, options = {}) {
            const response = await fetch(url, options);
            const rawText = await response.text();

            let json = null;

            try {
                json = rawText ? JSON.parse(rawText) : null;
            } catch (error) {
                console.error('Respuesta no JSON desde', url, rawText.slice(0, 240));
                throw new Error(`invalid-json:${response.status}`);
            }

            if (!response.ok) {
                const error = new Error(`http-${response.status}`);
                error.payload = json;
                throw error;
            }

            return json;
        }

        function setSaveState(message, tone = 'idle') {
            if (!hotSaveState) return;
            hotSaveState.dataset.tone = tone;
            hotSaveState.textContent = message;
        }

        function hasKeyData(row) {
            return str(row?.etiqueta) !== '' || str(row?.prenda) !== '';
        }

        function hasDraftData(row) {
            if (!row) return false;

            return hasKeyData(row)
                || str(row?.composicion) !== ''
                || str(row?.num_caja) !== ''
                || str(row?.bodega) !== ''
                || numberValue(row?.cantidad) > 0
                || numberValue(row?.precio_unitario) > 0;
        }

        function isEmptySpareRow(row) {
            return !row?.id && !hasDraftData(row);
        }

        function recalcRowData(row) {
            row.codigo_nota_pedido = str(row.codigo_nota_pedido) || str(ID_NOTA);
            row.cantidad = numberValue(row.cantidad);
            row.etiqueta = str(row.etiqueta);
            row.prenda = str(row.prenda);
            row.composicion = str(row.composicion);
            row.num_factura = str(row.num_factura) || str(num_factura);
            row.precio_unitario = numberValue(row.precio_unitario);
            row.tienda = str(row.tienda) || str(tienda);
            row.marca = str(row.marca) || str(marca);
            row.pais = str(row.pais) || str(pais);
            row.num_caja = str(row.num_caja);
            row.bodega = str(row.bodega);
            row.id_tienda = ID_TIENDA;
            row.saldo = round(row.cantidad - numberValue(row.etiqueta));
            row.total = round(row.cantidad * row.precio_unitario);
            return row;
        }

        function createBlankRow() {
            const row = {
                id: '',
                codigo_nota_pedido: ID_NOTA ?? '',
                cantidad: 0,
                etiqueta: '',
                saldo: 0,
                num_factura: num_factura ?? '',
                prenda: '',
                composicion: '',
                precio_unitario: 0,
                tienda: tienda ?? '',
                marca: marca ?? '',
                pais: pais ?? '',
                num_caja: '',
                bodega: '',
                total: 0,
                id_tienda: ID_TIENDA,
                _rowKey: `draft:${nextDraftId++}`,
            };

            return recalcRowData(row);
        }

        function normalizeRow(raw = {}) {
            const row = {
                id: raw.id ? Number(raw.id) : '',
                codigo_nota_pedido: raw.codigo_nota_pedido ?? ID_NOTA ?? '',
                cantidad: raw.cantidad ?? 0,
                etiqueta: raw.etiqueta ?? '',
                saldo: raw.saldo ?? 0,
                num_factura: raw.num_factura ?? num_factura ?? '',
                prenda: raw.prenda ?? '',
                composicion: raw.composicion ?? '',
                precio_unitario: raw.precio_unitario ?? 0,
                tienda: raw.tienda ?? tienda ?? '',
                marca: raw.marca ?? marca ?? '',
                pais: raw.pais ?? pais ?? '',
                num_caja: raw.num_caja ?? '',
                bodega: raw.bodega ?? '',
                total: raw.total ?? 0,
                id_tienda: raw.id_tienda ?? ID_TIENDA,
                _rowKey: raw.id ? `persisted:${raw.id}` : `draft:${nextDraftId++}`,
            };

            if (row.id) {
                nextDraftId = Math.max(nextDraftId, row.id + 1);
            }

            return recalcRowData(row);
        }

        function updateGridMeta() {
            if (!table || !hotRowCount) return;
            const totalRows = table.getData().filter((row) => row && (row.id || hasDraftData(row))).length;
            hotRowCount.textContent = `${totalRows} registro${totalRows === 1 ? '' : 's'}`;
        }

        async function syncTrailingBlankRow() {
            if (!table) return;

            let rows = table.getRows();
            const blankRows = rows.filter((rowComponent) => isEmptySpareRow(rowComponent.getData()));

            for (let index = 0; index < blankRows.length - 1; index += 1) {
                await blankRows[index].delete();
            }

            rows = table.getRows();
            const lastRow = rows[rows.length - 1];

            if (!lastRow || !isEmptySpareRow(lastRow.getData())) {
                await table.addRow(createBlankRow(), false);
            }
        }

        function formatNumberCell(cell, decimals = 2) {
            return `<span class="text-mono">${numberValue(cell.getValue()).toFixed(decimals)}</span>`;
        }

        async function syncRowComponent(rowComponent) {
            if (!rowComponent) return;

            const rowData = rowComponent.getData();
            recalcRowData(rowData);
            await rowComponent.update({ ...rowData });

            if (typeof rowComponent.reformat === 'function') {
                rowComponent.reformat();
            }

            table?.redraw(true);
        }

        function buildPayload(row) {
            const fd = new FormData();
            fd.append('id_nota', ID_NOTA ?? row.codigo_nota_pedido ?? '');
            if (row.id) fd.append('id', row.id);
            fd.append('cantidad', row.cantidad ?? 0);
            fd.append('etiqueta', row.etiqueta ?? '');
            fd.append('saldo', row.saldo ?? 0);
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
            return fd;
        }

        async function saveOrUpdateFila(row) {
            if (!row || isEmptySpareRow(row) || !hasDraftData(row)) return true;

            recalcRowData(row);

            let json = null;

            try {
                json = await fetchJson(row.id ? '/admin/pruebas/actualizarPruebas' : '/admin/pruebas/crearPruebasAjax', {
                    method: 'POST',
                    body: buildPayload(row),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });
            } catch (error) {
                console.warn('saveOrUpdateFila network/json error:', error);
                return false;
            }

            if (!json?.ok) {
                console.warn('saveOrUpdateFila error:', json);
                return false;
            }

            if (json.id) {
                row.id = Number(json.id);
            } else if (!row.id) {
                setSaveState('Sincronizando id de la fila...', 'saving');
                await refreshTabla();
                return true;
            }

            const rowComponent = table.getRow(row._rowKey);
            if (rowComponent) {
                await syncRowComponent(rowComponent);
            }

            return true;
        }

        async function queueRowSave(row) {
            if (!row || isEmptySpareRow(row)) return true;

            const queueKey = row._rowKey;
            const existingEntry = rowSaveQueueMap.get(queueKey);

            if (existingEntry) {
                existingEntry.pending = true;
                return existingEntry.promise;
            }

            const entry = {
                pending: true,
                promise: null,
            };

            entry.promise = (async () => {
                let ok = true;

                while (entry.pending) {
                    entry.pending = false;
                    const saved = await saveOrUpdateFila(row);
                    if (!saved) {
                        ok = false;
                        break;
                    }
                }

                rowSaveQueueMap.delete(queueKey);
                return ok;
            })();

            rowSaveQueueMap.set(queueKey, entry);
            return entry.promise;
        }

        async function maybeAutosaveRows(rows) {
            if (!autosaveInput?.checked) return;

            let ok = true;

            for (const row of rows) {
                if (!row || isEmptySpareRow(row) || !hasDraftData(row)) continue;
                const saved = await queueRowSave(row);
                if (!saved) ok = false;
            }

            setSaveState(ok ? 'Autosave al dia' : 'Error al guardar cambios', ok ? 'success' : 'error');
            updateGridMeta();
            return ok;
        }

        async function refreshTabla() {
            setSaveState('Sincronizando tabla...', 'saving');
            let json = null;

            try {
                json = await fetchJson(`/admin/pruebas/listarPruebasAjax?id_nota=${encodeURIComponent(ID_NOTA)}&id_tienda=${encodeURIComponent(ID_TIENDA)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });
            } catch (error) {
                setSaveState('No se pudo sincronizar', 'error');
                console.warn('refreshTabla error:', error);
                return false;
            }

            if (!json?.ok || !Array.isArray(json.data)) {
                setSaveState('No se pudo sincronizar', 'error');
                return false;
            }

            nextDraftId = 1;
            const rows = json.data.map((row) => normalizeRow(row));
            rows.push(createBlankRow());
            await table.replaceData(rows);
            updateGridMeta();
            setSaveState('Tabla actualizada', 'success');
            return true;
        }

        async function guardarNuevasFilas(button) {
            button?.setAttribute('disabled', 'disabled');
            button?.insertAdjacentHTML('afterbegin', '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
            setSaveState('Guardando filas nuevas...', 'saving');

            let ok = true;
            const rows = table.getData().filter((row) => row && !row.id && hasDraftData(row));

            for (const row of rows) {
                const saved = await queueRowSave(row);
                if (!saved) ok = false;
            }

            if (ok) {
                await refreshTabla();
            }

            button?.removeAttribute('disabled');
            button?.querySelector('.spinner-border')?.remove();
            showToast(ok ? 'success' : 'error', ok ? 'Filas nuevas guardadas.' : 'No se pudieron guardar todas las filas.');
            setSaveState(ok ? 'Guardado completado' : 'Hay filas pendientes de revisar', ok ? 'success' : 'error');
        }

        async function ensureRowAtPosition(position) {
            let rows = table.getRows();

            while (rows.length <= position) {
                await table.addRow(createBlankRow(), false);
                rows = table.getRows();
            }

            return rows[position];
        }

        async function applyPastedMatrix(text) {
            if (!activeCell) return;

            const startField = activeCell.getField();
            const startColumnIndex = editableFields.indexOf(startField);
            if (startColumnIndex === -1) return;

            const rows = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n').split('\n');
            if (rows.length && rows[rows.length - 1] === '') rows.pop();
            if (!rows.length) return;

            const rowComponents = table.getRows();
            const startRowIndex = rowComponents.findIndex((rowComponent) => rowComponent.getIndex() === activeCell.getRow().getIndex());
            if (startRowIndex === -1) return;

            const touchedRows = [];

            for (let rowOffset = 0; rowOffset < rows.length; rowOffset += 1) {
                const values = rows[rowOffset].split('\t');
                const rowComponent = await ensureRowAtPosition(startRowIndex + rowOffset);
                const rowData = rowComponent.getData();

                for (let columnOffset = 0; columnOffset < values.length; columnOffset += 1) {
                    const field = editableFields[startColumnIndex + columnOffset];
                    if (!field) break;
                    rowData[field] = values[columnOffset];
                }

                await syncRowComponent(rowComponent);
                touchedRows.push(rowData);
            }

            await syncTrailingBlankRow();
            updateGridMeta();

            if (autosaveInput?.checked) {
                setSaveState('Guardando filas pegadas...', 'saving');
                await maybeAutosaveRows(touchedRows);
            }

            showToast('success', 'Pega realizada correctamente.');
        }

        async function handleCellEdited(cell) {
            activeCell = cell;
            gridFocused = true;

            const rowComponent = cell.getRow();
            const rowData = rowComponent.getData();
            await syncRowComponent(rowComponent);
            await syncTrailingBlankRow();
            updateGridMeta();

            if (editableFields.includes(cell.getField())) {
                setSaveState('Guardando cambios...', 'saving');
                const ok = await maybeAutosaveRows([rowData]);
                if (!ok) {
                    showToast('error', 'Autosave no pudo guardar la fila.');
                }
            }
        }

        function createAutoSaveEditor(parseValue) {
            return function autoSaveEditor(cell, onRendered, success, cancel) {
                const input = document.createElement('input');
                input.type = 'text';
                input.value = cell.getValue() ?? '';
                input.className = 'tabulator-edit-input';
                input.style.width = '100%';
                input.style.height = '100%';
                input.style.border = '0';
                input.style.padding = '0 0.35rem';
                input.style.background = 'transparent';
                input.style.outline = 'none';

                let finished = false;

                const commit = async () => {
                    if (finished) return;
                    finished = true;
                    success(parseValue(input.value));

                    await Promise.resolve();
                    try {
                        await handleCellEdited(cell);
                    } catch (error) {
                        console.warn('editor autosave error:', error);
                        setSaveState('Error al procesar la fila', 'error');
                        showToast('error', 'No se pudo procesar la edicion.');
                    }
                };

                const abort = () => {
                    if (finished) return;
                    finished = true;
                    cancel();
                };

                onRendered(() => {
                    input.focus();
                    input.select();
                });

                input.addEventListener('blur', () => {
                    commit();
                });

                input.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        commit();
                        return;
                    }

                    if (event.key === 'Tab') {
                        event.preventDefault();
                        const movePrev = event.shiftKey;
                        commit().then(() => {
                            window.setTimeout(() => {
                                if (movePrev) {
                                    table.navigatePrev();
                                    return;
                                }

                                table.navigateNext();
                            }, 0);
                        });
                        return;
                    }

                    if (event.key === 'Escape') {
                        event.preventDefault();
                        abort();
                    }
                });

                return input;
            };
        }

        const autoSaveTextEditor = createAutoSaveEditor((value) => value);
        const autoSaveNumberEditor = createAutoSaveEditor((value) => {
            const trimmed = str(value);
            return trimmed === '' ? 0 : numberValue(trimmed);
        });

        async function handleDeleteRow(rowComponent) {
            const rowData = rowComponent.getData();

            if (!rowData?.id) {
                await rowComponent.delete();
                await syncTrailingBlankRow();
                updateGridMeta();
                setSaveState('Fila temporal eliminada', 'success');
                return;
            }

            const result = await Swal.fire({
                title: 'Eliminar fila',
                text: 'Esta accion eliminara el registro de forma definitiva.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#b91c1c',
                backdrop: false
            });

            if (!result.isConfirmed) return;

            const fd = new FormData();
            fd.append('id_nota', ID_NOTA ?? rowData.codigo_nota_pedido ?? '');
            fd.append('id', rowData.id);
            setSaveState('Eliminando fila...', 'saving');

            try {
                const json = await fetchJson('/admin/eliminarCarrito', {
                    method: 'POST',
                    body: fd,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (!json?.ok) {
                    showToast('error', 'No se pudo eliminar el registro.');
                    setSaveState('Error al eliminar', 'error');
                    return;
                }

                await rowComponent.delete();
                await syncTrailingBlankRow();
                updateGridMeta();
                showToast('success', 'Registro eliminado.');
                setSaveState('Fila eliminada', 'success');
            } catch (error) {
                showToast('error', 'Error de red al eliminar.');
                setSaveState('Error al eliminar', 'error');
            }
        }

        const initialRows = existentes.map((row) => normalizeRow(row));
        initialRows.push(createBlankRow());

        table = new Tabulator(container, {
            data: initialRows,
            index: '_rowKey',
            layout: 'fitDataStretch',
            height: '100%',
            placeholder: 'Sin registros cargados',
            tabEndNewRow: () => createBlankRow(),
            columnDefaults: {
                minWidth: 96,
                resizable: true,
                vertAlign: 'middle',
            },
            columns: [
                { title: '#', formatter: 'rownum', width: 54, hozAlign: 'center', headerSort: false, editor: false, frozen: true },
                { title: 'id', field: 'id', width: 74, hozAlign: 'center', headerSort: false, formatter: (cell) => `<span class="text-mono">${cell.getValue() || ''}</span>` },
                { title: 'cod', field: 'codigo_nota_pedido', width: 92, headerSort: false },
                { title: 'cantid', field: 'cantidad', editor: autoSaveNumberEditor, hozAlign: 'right', headerSort: false, formatter: (cell) => formatNumberCell(cell, 0) },
                { title: 'etq', field: 'etiqueta', editor: autoSaveTextEditor, headerSort: false },
                { title: 'saldo', field: 'saldo', hozAlign: 'right', headerSort: false, formatter: (cell) => formatNumberCell(cell, 2) },
                { title: 'num_fact', field: 'num_factura', editor: autoSaveTextEditor, headerSort: false },
                { title: 'prenda', field: 'prenda', editor: autoSaveTextEditor, headerSort: false },
                { title: 'composicion', field: 'composicion', editor: autoSaveTextEditor, headerSort: false },
                { title: 'precio_u', field: 'precio_unitario', editor: autoSaveNumberEditor, hozAlign: 'right', headerSort: false, formatter: (cell) => formatNumberCell(cell, 2) },
                { title: 'tienda', field: 'tienda', editor: autoSaveTextEditor, headerSort: false },
                { title: 'marca', field: 'marca', editor: autoSaveTextEditor, headerSort: false },
                { title: 'pais', field: 'pais', editor: autoSaveTextEditor, headerSort: false },
                { title: 'num_caja', field: 'num_caja', editor: autoSaveTextEditor, headerSort: false },
                { title: 'bodega', field: 'bodega', editor: autoSaveTextEditor, headerSort: false },
                { title: 'total', field: 'total', hozAlign: 'right', headerSort: false, formatter: (cell) => formatNumberCell(cell, 2) },
                {
                    title: 'Acciones',
                    field: '_actions',
                    width: 136,
                    hozAlign: 'center',
                    headerSort: false,
                    formatter: () => '<button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Eliminar</button>',
                    cellClick: (_event, cell) => {
                        handleDeleteRow(cell.getRow());
                    }
                }
            ],
            cellClick: (_event, cell) => {
                activeCell = cell;
                gridFocused = true;
            },
            cellEditing: (cell) => {
                activeCell = cell;
                gridFocused = true;
            },
            cellEdited: () => {}
        });

        table.on('tableBuilt', async () => {
            await syncTrailingBlankRow();
            updateGridMeta();
        });

        document.addEventListener('click', (event) => {
            if (!container.contains(event.target)) {
                gridFocused = false;
            }
        });

        document.addEventListener('paste', (event) => {
            const text = event.clipboardData?.getData('text/plain') || '';
            const tagName = (event.target?.tagName || '').toLowerCase();
            const isEditorInput = tagName === 'input' || tagName === 'textarea' || event.target?.isContentEditable;

            if (!gridFocused || !activeCell || !text || isEditorInput || (!text.includes('\t') && !text.includes('\n'))) {
                return;
            }

            event.preventDefault();
            applyPastedMatrix(text);
        });

        document.getElementById('guardar-nuevas')?.addEventListener('click', (event) => {
            guardarNuevasFilas(event.currentTarget);
        });

        document.getElementById('recargar')?.addEventListener('click', () => {
            refreshTabla();
        });
    });
</script>
<script>
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
                        <div class="row match-height g-4">
                            <div class="col-lg-6 col-12">
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
                            <div class="col-lg-6 col-12">
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
</div>

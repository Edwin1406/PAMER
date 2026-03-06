<footer class="app-footer">
    <div>
        <span class="app-footer__eyebrow">PAMER</span>
        <strong>Centro operativo interno</strong>
    </div>
    <p>Interfaz renovada para seguimiento, registro y control diario.</p>
</footer>

<script src="/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
$currentPath = $_SERVER['REQUEST_URI'];
if (strpos($currentPath, '/admin/index') !== false || strpos($currentPath, '/admin/graficas/graficasConsumoGeneral') !== false || strpos($currentPath, '/admin/graficas/graficasDoblado') !== false) {
    echo '<script src="/assets/vendors/apexcharts/apexcharts.js"></script>';
    echo '<script src="/assets/js/pages/dashboard.js"></script>';
}
?>

<script src="/assets/js/main.js"></script>
<script src="/assets/vendors/choices.js/choices.min.js"></script>
</body>

</html>

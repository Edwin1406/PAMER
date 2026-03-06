<?php
$userName = $_SESSION['nombre'] ?? 'Usuario';
$userEmail = $_SESSION['email'] ?? '';
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
$sectionTitle = 'Panel operativo';

if (strpos($currentPath, '/admin/notaPedido') === 0) {
    $sectionTitle = 'Notas de pedido';
} elseif (strpos($currentPath, '/admin/diseno') === 0) {
    $sectionTitle = 'Gestion de diseno';
} elseif (strpos($currentPath, '/admin/consumo') === 0 || strpos($currentPath, '/admin/control') === 0) {
    $sectionTitle = 'Control y consumo';
} elseif (strpos($currentPath, '/admin/graficas') === 0) {
    $sectionTitle = 'Analitica operativa';
} elseif (strpos($currentPath, '/admin/index') === 0 || strpos($currentPath, '/admin/dashboard') === 0) {
    $sectionTitle = 'Dashboard';
}

$initial = strtoupper(function_exists('mb_substr') ? mb_substr($userName, 0, 1) : substr($userName, 0, 1));
?>
<?php include_once __DIR__ . '/templates/admin-header.php'; ?>
<div id="app" class="app-shell">
    <?php include_once __DIR__ . '/templates/sidebar-only.php'; ?>

    <div id="main" class="app-main">
        <header class="admin-topbar">
            <div class="admin-topbar__mobile">
                <a href="#" class="burger-btn" aria-label="Abrir menu lateral">
                    <i class="bi bi-list"></i>
                </a>
                <div class="admin-topbar__copy">
                    <span class="admin-topbar__eyebrow">PAMER</span>
                    <h1 class="admin-topbar__title"><?php echo htmlspecialchars($sectionTitle); ?></h1>
                </div>
            </div>

            <div class="admin-topbar__actions">
                <div class="admin-topbar__status">
                    <span class="status-dot"></span>
                    <span>Operacion activa</span>
                </div>

                <div class="admin-topbar__user">
                    <span class="admin-topbar__avatar"><?php echo htmlspecialchars($initial); ?></span>
                    <div>
                        <strong><?php echo htmlspecialchars($userName); ?></strong>
                        <small><?php echo htmlspecialchars($userEmail); ?></small>
                    </div>
                </div>

                <a href="/cerrarSesion" class="admin-topbar__logout">Cerrar sesion</a>
            </div>
        </header>

        <div class="app-page-content">
            <?php echo $contenido; ?>
        </div>

        <?php include_once __DIR__ . '/templates/admin-sidebar.php'; ?>
    </div>
</div>

<script>
    if (window.location.pathname === "/admin/dashboard") {
        var s = document.createElement('script');
        s.src = "/assets/js/pages/dashboard.js";
        document.body.appendChild(s);
    }
</script>

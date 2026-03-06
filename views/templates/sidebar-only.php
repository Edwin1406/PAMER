<?php
$userEmail = $_SESSION['email'] ?? 'No disponible';
$userName = $_SESSION['nombre'] ?? 'Usuario';
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';

$canSeeDashboard = in_array($userEmail, ['control@megaecuador.com', 'produccion@megaecuador.com', 'pruebas@megaecuador.com'], true);
$canSeeAdministration = in_array($userEmail, ['invitado@pruebas.com', 'pruebas@megaecuador.com'], true);

$isDashboard = $currentPath === '/admin/index' || $currentPath === '/admin/dashboard';
$isAdministration = strpos($currentPath, '/admin/bodega/') === 0
    || strpos($currentPath, '/admin/ciudad/') === 0
    || strpos($currentPath, '/admin/paises/') === 0
    || strpos($currentPath, '/admin/marca/') === 0
    || strpos($currentPath, '/admin/tienda/') === 0;
$isNotaPedido = strpos($currentPath, '/admin/notaPedido/') === 0;
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="brand-block">
                <a href="/admin/index" class="brand-link">
                    <span class="brand-mark">P</span>
                    <span class="brand-copy">
                        <strong>PAMER</strong>
                        <small>Plataforma operativa</small>
                    </span>
                </a>
                <a href="#" class="sidebar-hide d-xl-none d-block" aria-label="Cerrar menu lateral">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Navegacion</li>

                <?php if ($canSeeDashboard) { ?>
                    <li class="sidebar-item <?php echo $isDashboard ? 'active' : ''; ?>">
                        <a href="/admin/index" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($canSeeAdministration) { ?>
                    <li class="sidebar-item has-sub <?php echo $isAdministration ? 'active' : ''; ?>">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-stack"></i>
                            <span>Administracion</span>
                        </a>

                        <ul class="submenu <?php echo $isAdministration ? 'active' : ''; ?>" style="<?php echo $isAdministration ? 'display:block;' : 'display:none;'; ?>">
                            <li class="sidebar-title">Catalogos base</li>
                            <li class="submenu-item <?php echo strpos($currentPath, '/admin/bodega/') === 0 ? 'active' : ''; ?>">
                                <a href="/admin/bodega/crearBodega"><i class="bi bi-arrow-right"></i>Bodega</a>
                            </li>
                            <li class="submenu-item <?php echo strpos($currentPath, '/admin/ciudad/') === 0 ? 'active' : ''; ?>">
                                <a href="/admin/ciudad/crearCiudad"><i class="bi bi-arrow-right"></i>Ciudades</a>
                            </li>
                            <li class="submenu-item <?php echo strpos($currentPath, '/admin/paises/') === 0 ? 'active' : ''; ?>">
                                <a href="/admin/paises/crearPais"><i class="bi bi-arrow-right"></i>Paises</a>
                            </li>
                            <li class="submenu-item <?php echo strpos($currentPath, '/admin/marca/') === 0 ? 'active' : ''; ?>">
                                <a href="/admin/marca/crearMarca"><i class="bi bi-arrow-right"></i>Marcas</a>
                            </li>
                            <li class="submenu-item <?php echo strpos($currentPath, '/admin/tienda/') === 0 ? 'active' : ''; ?>">
                                <a href="/admin/tienda/crearTienda"><i class="bi bi-arrow-right"></i>Tiendas</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <li class="sidebar-item has-sub <?php echo $isNotaPedido ? 'active' : ''; ?>">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Nota pedido</span>
                    </a>
                    <ul class="submenu <?php echo $isNotaPedido ? 'active' : ''; ?>" style="<?php echo $isNotaPedido ? 'display:block;' : 'display:none;'; ?>">
                        <li class="sidebar-title">Gestion comercial</li>
                        <li class="submenu-item <?php echo strpos($currentPath, '/admin/notaPedido/crearNota') === 0 ? 'active' : ''; ?>">
                            <a href="/admin/notaPedido/crearNota"><i class="bi bi-arrow-right"></i>Crear pedido</a>
                        </li>
                        <li class="submenu-item <?php echo strpos($currentPath, '/admin/notaPedido/listaNotaPedido') === 0 ? 'active' : ''; ?>">
                            <a href="/admin/notaPedido/listaNotaPedido"><i class="bi bi-arrow-right"></i>Pedidos tienda</a>
                        </li>
                        <li class="submenu-item <?php echo strpos($currentPath, '/admin/notaPedido/CrearTienda') === 0 ? 'active' : ''; ?>">
                            <a href="/admin/notaPedido/CrearTienda"><i class="bi bi-arrow-right"></i>Tiendas</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-footer__card">
                <span class="sidebar-footer__label">Sesion activa</span>
                <strong><?php echo htmlspecialchars($userName); ?></strong>
                <small><?php echo htmlspecialchars($userEmail); ?></small>
                <a href="/cerrarSesion" class="sidebar-footer__link">Cerrar sesion</a>
            </div>
        </div>

        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>

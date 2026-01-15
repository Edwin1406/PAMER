 <?php

    $userEmail = $_SESSION['email'] ?? 'No disponible'; // Asignar
    ?>


 <header class="py-3">
     <a href="#" class="burger-btn d-block d-xl-none">
         <i class="bi bi-justify fs-3"></i>
     </a>
 </header>
 <div id="sidebar" class="active">
     <div class="sidebar-wrapper active">
         <div class="sidebar-header">
             <div class="d-flex justify-content-between">
                 <div class="logo">
                     <a href="/admin/index">DESARROLLO</a>
                 </div>
                 <div class="toggler">
                     <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                 </div>
             </div>
         </div>
         <!-- Sidebar Menu -->
         <div class="sidebar-menu">
             <ul class="menu">
                 <li class="sidebar-title">Menu</li>

                 <?php if ($userEmail === 'control@megaecuador.com' || $userEmail === 'produccion@megaecuador.com' || $userEmail === 'pruebas@megaecuador.com') { ?>
                     <li class="sidebar-item active ">
                         <a href="/admin/index" class='sidebar-link'>
                             <i class="bi bi-grid-fill"></i>
                             <span>Dashboard</span>
                         </a>
                     </li>
                 <?php } ?>

                 <li class="sidebar-item  has-sub">
                     <a href="#" class='sidebar-link'>
                         <i class="bi bi-stack"></i>
                         <span>Administracion</span>
                     </a>
                     <?php if ($userEmail === 'invitado@pruebas.com' || $userEmail === 'pruebas@megaecuador.com') { ?>
                         <ul class="submenu ">
                             <li class="sidebar-title"><b><i class="bi bi-archive"></i> Registros</b></li>


                             <li class="submenu-item">
                                 <a href="/admin/bodega/crearBodega"><i class="bi bi-arrow-right"> </i>Bodega</a>
                             </li>


                             <!-- icono de flecha -->
                             <li class="submenu-item ">
                                 <a href="/admin/ciudad/crearCiudad"><i class="bi bi-arrow-right"> </i>Ciudades</a>
                             </li>

                             <li class="submenu-item ">
                                 <a href="/admin/paises/crearPais"><i class="bi bi-arrow-right"> </i>Paises</a>
                             </li>

                             <li class="submenu-item ">
                                 <a href="/admin/marca/crearMarca"><i class="bi bi-arrow-right"> </i>Marcas</a>
                             </li>
                             <li class="submenu-item ">
                                 <a href="/admin/tienda/crearTienda"><i class="bi bi-arrow-right"> </i>Tienda</a>
                             </li>




                         </ul>





                     <?php }  ?>

                 </li>


                 <li class="sidebar-item  has-sub">
                     <a href="#" class='sidebar-link'>
                         <!-- <i class="bi bi-collection-fill"></i> -->
                         <i class="bi bi-file-earmark-text"></i>
                         <span>Nota Pedido</span>
                     </a>
                     <ul class="submenu ">

                         <li class="submenu-item ">
                             <a href="/admin/notaPedido/crearNota"><i class="bi bi-arrow-right"> </i>Crear Pedido</a>
                         </li>
                         <li class="submenu-item ">
                             <a href="/admin/notaPedido/listaNotaPedido"><i class="bi bi-arrow-right"> </i>Pedidos-Tienda</a>
                         </li>
                         <li class="submenu-item ">
                             <a href="/admin/notaPedido/CrearTienda"><i class="bi bi-arrow-right"> </i>Tiendas</a>
                         </li>

                     </ul>
                 </li>
         </div>
         <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
     </div>
 </div>
<?php if ($email === 'control@megaecuador.com' || $email === 'produccion@megaecuador.com' || $email === 'pruebas@megaecuador.com') { ?>
    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Bienvenido al Sistema</h3>
                    <p class="text-subtitle text-muted">Te comentamos que estamos en desarrollo  </p>
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







    </div>



<?php } else { ?>
    <div class="page-heading">
        <h3>Bienvenido <?php echo $nombre; ?></h3>
        <p class="text-subtitle text-muted"><?php echo $email; ?></p>
    </div>

<?php } ?>
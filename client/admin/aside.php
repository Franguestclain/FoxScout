<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile d-flex no-block dropdown m-t-20">
                        <div class="user-pic"><img src="assets/images/users/1.jpg" alt="users" class="rounded-circle" width="40" /></div>
                        <div class="user-content hide-menu m-l-10 ml-2">
                            <a href="javascript:void(0)"  id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="m-b-0 user-name font-medium"><?php echo $_SESSION['nombre']; ?> <i class="fa fa-angle-down"></i></h5>
                                <span class="op-5 user-email"><?php echo $_SESSION['correo']; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> Mi perfil</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-wallet m-r-5 m-l-5"></i> My Balance</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> Mensajes</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php"><i class="fa fa-power-off m-r-5 m-l-5"></i> Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
                <!-- User Profile-->
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Usuarios</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="pages-profile.php" aria-expanded="false"><i class="mdi mdi-shopping"></i><span class="hide-menu">Perfil</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="productos.php" aria-expanded="false"><i class="mdi mdi-shopping"></i><span class="hide-menu">Productos</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="pages-profile.php" aria-expanded="false"><i class="mdi mdi-account-network"></i><span class="hide-menu">Perfil Page</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="tiendas.php" aria-expanded="false"><i class="mdi mdi-store"></i><span class="hide-menu">Tiendas</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="sucursales.php" aria-expanded="false"><i class="mdi mdi-google-maps"></i><span class="hide-menu">Sucursales</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="localidades.php" aria-expanded="false"><i class="mdi mdi-map-marker-multiple"></i><span class="hide-menu">Localidades</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="categoria.php" aria-expanded="false"><i class="mdi mdi-tag-multiple"></i><span class="hide-menu">Categorías</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="error-404.php" aria-expanded="false"><i class="mdi mdi-map-marker-multiple"></i><span class="hide-menu">Error 404</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="table-basic.php" aria-expanded="false"><i class="mdi mdi-border-all"></i><span class="hide-menu">Tablas</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="icon-material.php" aria-expanded="false"><i class="mdi mdi-tag-multiple"></i><span class="hide-menu">Iconos</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="icon-material.php" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu">Iconos</span></a></li>
            </ul>
            
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
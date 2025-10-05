    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="stylesheet" href="../css/animate.min.css">
    <!-- CSS para uso de libreria DataTables -->
    <link rel="stylesheet" href="../css/datatables.css">
    <!-- CSS de la vista Administrar Compra -->
    <link rel="stylesheet" href="../css/compra.css">
    <!-- CSS para corregir el diseño del carrito para dispositivos móviles -->
    <link rel="stylesheet" href="../css/main.css">
    <!-- Select2 - CSS - Versión 4.1.0 -->
    <link rel="stylesheet" href="../css/select2.css">
    <!-- SweetAlert2 - CSS -->
    <link rel="stylesheet" href="../css/sweetalert2.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">

    <!-- Site wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left navbar links -->
            <ul class="navbar-nav">

                <!-- Icono Hamburguesa -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

                <!-- Inicio -->
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="adm_catalogo.php" class="nav-link">Inicio</a>
                </li>

                <!-- Contactos -->
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contactos</a>
                </li>

                <!-- Start - Componente Dropdown para el Carrito de Compras -->
                <li id="cat-carrito" class="nav-item dropdown" style="display: none;">
                    <img class="imagen-carrito nav-link dropdown-toggle" style="cursor: pointer;" src="../img/carrito.png" role="button" data-toggle="dropdown" aria-expanded="false">

                    <span id="contador" class="contador badge badge-danger"></span>
                    
                    <!-- Tabla del Carrito -->
                    <div class="dropdown-menu p-1">
                        <table class="carro table table-hover text-nowrap p-0">
                            <thead style="background-color: #71b4c3;">
                                <tr>
                                    <th>Cod</th>
                                    <th>Nombre</th>
                                    <th>Concentración</th>
                                    <th>Adicional</th>
                                    <th>Precio</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="lista">

                            </tbody>
                        </table>
                        <a id="procesar-pedido" href="#" class="btn btn-block text-white" style="background: #960944;">Procesar Compra</a>
                        <a id="vaciar-carrito" href="#" class="btn btn-info btn-block">Vaciar Carrito</a>
                    </div>
                </li>
                <!-- End - Componente Dropdown para el Carrito de Compras -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <a href="../controlador/Logout.php">Cerrar Sesión</a>
            </ul>
        </nav><!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../vista/adm_catalogo.php" class="brand-link">
                <img src="../img/logo.png"
                    alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Farmacia</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img id="avatar4" src="../img/avatar.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <?php echo $_SESSION["nombre_us"]; ?>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                        <li class="nav-header">Usuario</li>

                        <!-- Datos personales -->
                        <li class="nav-item">
                            <a href="editar_datos_personales.php" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    Datos personales
                                </p>
                            </a>
                        </li>

                        <!-- Gestión Usuario -->
                        <li id="gestion_usuario" class="nav-item">
                            <a href="adm_usuario.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Gestión Usuario
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">Ventas</li>
                        
                        <!-- Listar Ventas -->
                        <li class="nav-item">
                            <a href="adm_venta.php" class="nav-link">
                                <i class="nav-icon fas fa-notes-medical"></i>
                                <p>
                                    Listar Ventas
                                </p>
                            </a>
                        </li>

                        <li id="almacen" class="nav-header">Almacén</li>
                        
                        <!-- Gestión Producto -->
                        <li id="gestion_producto" class="nav-item">
                            <a href="adm_producto.php" class="nav-link">
                                <i class="nav-icon fas fa-pills"></i>
                                <p>
                                    Gestión Producto
                                </p>
                            </a>
                        </li>

                        <!-- Gestión Atributo -->
                        <li id="gestion_atributo" class="nav-item">
                            <a href="adm_atributo.php" class="nav-link">
                                <i class="nav-icon fas fa-vials"></i>
                                <p>
                                    Gestión Atributo
                                </p>
                            </a>
                        </li>

                        <!-- Gestión Lote -->
                        <li id="gestion_lote" class="nav-item">
                            <a href="adm_lote.php" class="nav-link">
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>
                                    Gestión Lote
                                </p>
                            </a>
                        </li>

                        <li id="compras" class="nav-header">Compras</li>

                        <!-- Gestión Proveedor -->
                        <li id="gestion_proveedor" class="nav-item">
                            <a href="adm_proveedor.php" class="nav-link">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    Gestión Proveedor
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div><!-- /.sidebar -->
        </aside>
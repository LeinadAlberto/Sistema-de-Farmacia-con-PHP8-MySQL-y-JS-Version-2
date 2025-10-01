<?php 

    session_start();
    
    if ($_SESSION["us_tipo"] == 3 || $_SESSION["us_tipo"] == 1 || $_SESSION["us_tipo"] == 2) {

        include_once "layouts/header.php";
?>

    <title>Gestión Ventas</title>
        
<?php include_once "layouts/nav.php"; ?>

<!-- Modal para Vista Venta -->
<div class="modal fade" id="vista_venta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Registros de Ventas</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- /.card-header -->
                
                
                <div class="card-body">
                    <!-- Código Venta -->
                    <div class="form-group">
                        <label for="codigo_venta">Código Venta: </label>
                        <span id="codigo_venta"></span>
                    </div>

                    <!-- Fecha -->
                    <div class="form-group">
                        <label for="fecha">Fecha: </label>
                        <span id="fecha"></span>
                    </div>

                    <!-- Cliente -->
                    <div class="form-group">
                        <label for="cliente">Cliente: </label>
                        <span id="cliente"></span>
                    </div>

                    <!-- DNI -->
                    <div class="form-group">
                        <label for="dni">DNI: </label>
                        <span id="dni"></span>
                    </div>

                    <!-- Vendedor -->
                    <div class="form-group">
                        <label for="vendedor">Vendedor: </label>
                        <span id="vendedor"></span>
                    </div>

                    <table class="table table-hover">

                        <thead class="table-success">
                            <tr>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Producto</th>
                                <th>Concentración</th>
                                <th>Adicional</th>
                                <th>Laboratorio</th>
                                <th>Presentación</th>
                                <th>Tipo</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody class="table-info" id="registros">

                        </tbody>

                    </table>

                    <div class="float-right input-group-append">
                        <h3 class="m-3">Total: </h3>
                        <h3 class="m-3" id="total"></h3>
                    </div>

                </div><!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                </div><!-- /.card-footer -->
                
            </div><!-- /.card -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión Ventas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adm_catalogo.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión Ventas</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section><!-- /.content-header -->

    <section>
        <div class="container-fluid">
            <card class="card card-info">
                <div class="card-header">
                    <h3 class="card-title mb-2">Consultas</h3>
                    
                </div><!-- /.card-header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="venta_dia_vendedor">0</h3>

                                    <p>Venta del día por Vendedor</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="venta_diaria">0</h3>

                                    <p>Venta Diaria</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 id="venta_mensual">0</h3>

                                    <p>Venta Mensual</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 id="venta_anual">0</h3>

                                    <p>Venta Anual</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-signal"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->
                </div><!-- /.card-body -->

                <div class="card-footer">

                </div><!-- /.card-footer -->
            </card>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <card class="card card-info">
                <div class="card-header">
                    <h3 class="card-title mb-2">Buscar Ventas</h3>
                    
                </div><!-- /.card-header -->

                <div class="card-body">
                    <table id="tabla_venta" class="display table table-hover text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>DNI</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div><!-- /.card-body -->

                <div class="card-footer">

                </div><!-- /.card-footer -->
            </card>
        </div>
    </section>
    
</div><!-- /.content-wrapper -->


<?php 
        include_once "layouts/footer.php";

    } else { // Closed if
        header("Location: ../index.php");
    }  
?>

<!-- JS para uso de libreria DataTables -->
<script src="../js/datatables.js"></script>

<script src="../js/Venta.js"></script>
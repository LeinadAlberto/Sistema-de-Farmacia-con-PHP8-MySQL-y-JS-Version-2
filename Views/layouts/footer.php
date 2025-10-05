            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
                </div>
                <strong>Derechos de autor &copy; 2024 <a href="#">DanielWebDeveloper</a>.</strong> Todos los derechos reservados.
            </footer>

            <!-- Control Sidebar -->
            
            <!-- /.control-sidebar -->

        </div><!-- ./wrapper -->

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../js/demo.js"></script>
        <!-- SweetAlert2 - JS -->
        <script src="../js/sweetalert2.js"></script>
        <!-- Select2 - JS - Versión 4.1.0 -->
        <script src="../js/select2.js"></script>

    </body>

    <script>

        let funcion = 'devolver_avatar';

        $.post('../controlador/UsuarioController.php', { funcion }, (response) => {

            const avatar = JSON.parse(response);

            $('#avatar4').attr('src', '../img/' + avatar.avatar);

        });

        funcion = 'tipo_usuario';

        $.post('../controlador/UsuarioController.php', { funcion }, (response) => {

            if (response == 1) {

                $('#gestion_lote').hide();

            } else if (response == 2) {

                $('#gestion_lote').hide();

                $('#gestion_usuario').hide();

                $('#gestion_producto').hide();

                $('#gestion_atributo').hide();

                $('#gestion_proveedor').hide();

                $('#almacen').hide();

                $('#compras').hide();

            }

        });

    </script>
    
</html>
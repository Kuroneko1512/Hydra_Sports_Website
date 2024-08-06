<!-- footer -->
                <!-- ============================================================== -->
                <footer class="footer text-center">
                    All Rights Reserved by Hydra Sports. Designed and Developed by <a href=""></a>Hydra Sports.
                </footer>
                <!-- ============================================================== -->
                <!-- End footer -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
</div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
            <script src="lib/admin/assets/libs/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
            <script src="lib/admin/assets/libs/popper.js/dist/umd/popper.min.js"></script>
            <script src="lib/admin/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="lib/admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
        <script src="lib/admin/assets/extra-libs/sparkline/sparkline.js"></script>
        <!--Wave Effects -->
            <script src="lib/admin/dist/js/waves.js"></script>
        <!--Menu sidebar -->
            <script src="lib/admin/dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
            <script src="lib/admin/dist/js/custom.min.js"></script>
        <!--This page JavaScript -->
        <!-- <script src="lib/admin/dist/js/pages/dashboards/dashboard1.js"></script> -->
        <!-- Charts js Files -->
            <script src="lib/admin/assets/libs/flot/excanvas.js"></script>
            <script src="lib/admin/assets/libs/flot/jquery.flot.js"></script>
            <script src="lib/admin/assets/libs/flot/jquery.flot.pie.js"></script>
            <script src="lib/admin/assets/libs/flot/jquery.flot.time.js"></script>
            <script src="lib/admin/assets/libs/flot/jquery.flot.stack.js"></script>
            <script src="lib/admin/assets/libs/flot/jquery.flot.crosshair.js"></script>
            <script src="lib/admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
            <script src="lib/admin/dist/js/pages/chart/chart-page-init.js"></script>
        <!-- Table js -->
        <script src="lib/admin/assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
        <script src="lib/admin/assets/extra-libs/multicheck/jquery.multicheck.js"></script>
        <script src="lib/admin/assets/extra-libs/DataTables/datatables.min.js"></script>
        
        <script>
            /****************************************
             *       Basic Table                   *
             ****************************************/
            $('#zero_config').DataTable();
            $('#zero_config1').DataTable();
            $('#zero_config2').DataTable();
            $('#zero_config3').DataTable();            
            
            var validateUserDataUrl = '<?= $route->getLocateAdmin("validate-user-data") ?>';
            var validateEditUserDataUrl = '<?= $route->getLocateAdmin("validate-edit-user-data") ?>';
            var validateCategoryUrl = '<?= $route->getLocateAdmin("validate-category-data") ?>';
            var validateEditCategoryUrl = '<?= $route->getLocateAdmin("validate-edit-category-data") ?>';
            var getProductVariantUrlBase = '<?= $route->getLocateAdmin("get-product-variant") ?>';
            var validateColorUrl = '<?= $route->getLocateAdmin("validate-color-data") ?>';
            var validateEditColorUrl = '<?= $route->getLocateAdmin("validate-edit-color-data") ?>';
            var validateSizeUrl = '<?= $route->getLocateAdmin("validate-size-data") ?>';
            var validateEditSizeUrl = '<?= $route->getLocateAdmin("validate-edit-size-data") ?>';
            
        </script>
        <script src="lib/admin/dist/js/debounce-validate-form.js"></script>
        <script src="lib/admin/dist/js/product-show-variant.js"></script>
        <!-- <script src="lib/admin/dist/js/validate-form-user.js"></script> -->
        <script src="lib/admin/dist/js/multi-choice-box.js"></script>
    </body>

</html>
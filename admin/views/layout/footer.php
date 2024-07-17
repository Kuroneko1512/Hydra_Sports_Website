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
            <script src="lib/admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
            <script src="lib/admin/assets/extra-libs/sparkline/sparkline.js"></script>
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

            // Lấy tất cả các checkbox trong bảng
            var checkboxes = document.querySelectorAll('.listCheckbox');

            // Tạo một hàm để hiển thị dữ liệu của các dòng có checkbox được chọn
            function displaySelectedRows() {
            // Lặp qua tất cả các checkbox
            checkboxes.forEach(function(checkbox) {
                // Kiểm tra nếu checkbox đã được chọn
                if (checkbox.checked) {
                // Tìm dòng tương ứng với checkbox được chọn
                var row = checkbox.closest('tr');

                // Lấy dữ liệu của dòng
                var renderingEngine = row.cells[1].textContent;
                var browser = row.cells[2].textContent;
                var platform = row.cells[3].textContent;
                var engineVersion = row.cells[4].textContent;

                // Hiển thị dữ liệu trong console
                console.log('Rendering engine: ' + renderingEngine);
                console.log('Browser: ' + browser);
                console.log('Platform: ' + platform);
                console.log('Engine version: ' + engineVersion);
                console.log('---');            
                }
            });
            }

            // Gán sự kiện click cho checkbox chọn tất cả
            var mainCheckbox = document.getElementById('mainCheckbox');
            mainCheckbox.addEventListener('change', function() {
            // Lặp qua tất cả các checkbox và đặt trạng thái tương ứng với checkbox chọn tất cả
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = mainCheckbox.checked;
            });
            // Hiển thị dữ liệu của các dòng được chọn
            displaySelectedRows();
            console.log('done all');
            });

            // Gán sự kiện click cho các checkbox riêng lẻ
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    // Hiển thị dữ liệu của các dòng được chọn
                    displaySelectedRows();
                    console.log('done 1');
                });
            });

            // Hàm để tạo bảng phụ
                function createSubTable(variantData) {
                    const subTableHtml = `
                    <tr class="sub-table">
                        <td colspan="13">
                            <table class="table table-striped table-bordered  table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th>
                                            <label class="customcheckbox m-b-20">
                                                <input type="checkbox" class="mainCheckbox1" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </th>
                                        <th>Màu</th>
                                        <th>Size</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>SKU</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${variantData.map(variant => `
                                        <tr>
                                            <td></td>
                                            <td>
                                                <label class="customcheckbox">
                                                    <input type="checkbox" class="listCheckbox1" />
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>${variant.color}</td>
                                            <td>${variant.size}</td>
                                            <td>${variant.quantity}</td>
                                            <td>${variant.price}</td>
                                            <td>${variant.sku}</td>
                                            <td>
                                                <a href="">
                                                    <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                                </a>
                                                <a href="">
                                                    <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                                </a>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    `;
                    return subTableHtml;
                }
                
                // Hàm xử lý sự kiện click cho tên sản phẩm
                function handleProductNameClick(event) {
                    event.preventDefault();
                    const productId = this.dataset.productId;
                    const productRow = this.closest('tr');
                    const subTableRow = productRow.nextElementSibling;

                    if (subTableRow && subTableRow.classList.contains('sub-table')) {
                    // Nếu bảng phụ đã tồn tại, ẩn hoặc hiển thị nó
                    subTableRow.style.display = subTableRow.style.display === 'none' ? 'table-row' : 'none';
                    } else {
                    // Nếu bảng phụ chưa tồn tại, lấy dữ liệu từ máy chủ và tạo bảng phụ
                    //   fetch(`get_product_variants.php?product_id=${productId}`)
                    //     .then(response => response.json())
                    //     .then(variantData => {
                    //       const subTableHtml = createSubTable(variantData);
                    //       productRow.insertAdjacentHTML('afterend', subTableHtml);
                    //     });
                    const variantData = [
                        { color: 'Đỏ', size: 'XL', quantity: 100, price: '$50', sku: 'AT001-RED-XL' },
                        { color: 'Xanh', size: 'L', quantity: 75, price: '$45', sku: 'AT001-BLUE-L' }
                    ];
                    const subTableHtml = createSubTable(variantData);
                    productRow.insertAdjacentHTML('afterend', subTableHtml);
                    console.log(subTableHtml);
                    }
                }

                // Gắn sự kiện click cho các tên sản phẩm
                document.querySelectorAll('#TableProduct .product-name').forEach(productName => {
                    productName.addEventListener('click', handleProductNameClick);
                    console.log('done 2');
                });
                const a = document.querySelectorAll('#TableProduct .product-name');
                console.log(handleProductNameClick);
        </script>
    </body>

</html>
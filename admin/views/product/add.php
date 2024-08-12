<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h3 class="page-title">Products</h3>
            <div class="ml-2 mt-2 p-1 text-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $route->getLocateAdmin() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Product</li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="ml-auto text-right">
                <a href="<?= $route->getLocateAdmin('list-product') ?>" class="btn btn-success">
                    <!-- <i class="bi bi-arrow-90deg-left"></i> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12 border border-info rounded shadow-lg p-3 mb-5 bg-white ">
            <form class="form-horizontal" id="createProductForm" method="post" action="<?= $route->getLocateAdmin('post-create-product') ?>" enctype="multipart/form-data">

                <h4 class="card-title">Product Add</h4>

                <div class="mb-3">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?= isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '' ?>">
                    
                    <span id="product_name-error" class="error-message text-danger">
                        <?php if (isset($errors['product_name'])) : ?>
                            <?= $errors['product_name'] ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="mb-3">
                    <label for="category_id">Category</label>
                    <select class="select2 form-control" style="width: 100%; height:36px;" name="category_id">
                        <option value="">--Select--</option>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?= $cat['id'] ?>" <?= isset($_POST['category_id']) && $_POST['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['category_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <span id="category_id-error" class="error-message text-danger">
                        <?php if (isset($errors['category_id'])) : ?>
                            <?= $errors['category_id'] ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" class="form-control" value="<?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?>">
                    
                    <span id="description-error" class="error-message text-danger">
                        <?php if (isset($errors['description'])) : ?>
                            <?= $errors['description'] ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="mb-3">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">

                    <span id="image-error" class="error-message text-danger">
                        <?php if (isset($errors['image'])) : ?>
                            <?= $errors['image'] ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="mb-3">
                    <label for="is_simple">Is Simple Product</label>
                    <input type="checkbox" id="is_simple" name="is_simple" <?= isset($_POST['is_simple']) && $_POST['is_simple'] ? 'checked' : '' ?>>

                    <span id="is_simple-error" class="error-message text-danger">
                        <?php if (isset($errors['is_simple'])) : ?>
                            <?= $errors['is_simple'] ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="mb-3" id="variants-section" style="<?= isset($_POST['is_simple']) && $_POST['is_simple'] ? 'display:block;' : '' ?>">
                    <h5>Variants</h5>
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Images</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="variants-body">
                        <?php
                        $is_simple = isset($_POST['is_simple']) ? (bool)$_POST['is_simple'] : false;
                        $variantCount = $is_simple ? 1 : (isset($_POST['variant']) ? count($_POST['variant']) : 1);
                        for ($i = 0; $i < $variantCount; $i++) :
                        ?>
                            <tr>
                                <td>
                                    <select name="variant[<?= $i ?>][color]" class="form-control">
                                        <option value="">--Select--</option>
                                        <?php foreach ($colors as $color) : ?>
                                            <option value="<?= $color['id'] ?>" <?= isset($_POST['variant'][$i]['color']) && $_POST['variant'][$i]['color'] == $color['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($color['color_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="variant-<?= $i ?>-color-error" class="error-message text-danger">
                                        <?php if (isset($errors["variant.{$i}.color"])) : ?>
                                            <?= $errors["variant.{$i}.color"] ?>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <select name="variant[<?= $i ?>][size]" class="form-control">
                                        <option value="">--Select--</option>
                                        <?php foreach ($sizes as $size) : ?>
                                            <option value="<?= $size['id'] ?>" <?= isset($_POST['variant'][$i]['size']) && $_POST['variant'][$i]['size'] == $size['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($size['size_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="variant-<?= $i ?>-size-error" class="error-message text-danger">
                                        <?php if (isset($errors["variant.{$i}.size"])) : ?>
                                            <?= $errors["variant.{$i}.size"] ?>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <input type="text" name="variant[<?= $i ?>][stock]" class="form-control" value="<?= isset($_POST['variant'][$i]['stock']) ? htmlspecialchars($_POST['variant'][$i]['stock']) : '' ?>">
                                    <span id="variant-<?= $i ?>-stock-error" class="error-message text-danger">
                                        <?php if (isset($errors["variant.{$i}.stock"])) : ?>
                                            <?= $errors["variant.{$i}.stock"] ?>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <input type="text" name="variant[<?= $i ?>][price]" class="form-control" value="<?= isset($_POST['variant'][$i]['price']) ? htmlspecialchars($_POST['variant'][$i]['price']) : '' ?>">
                                    <span id="variant-<?= $i ?>-price-error" class="error-message text-danger">
                                        <?php if (isset($errors["variant.{$i}.price"])) : ?>
                                            <?= $errors["variant.{$i}.price"] ?>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <input type="file" name="variant[<?= $i ?>][images][]" class="form-control" multiple accept="image/*">
                                    <span id="variant-<?= $i ?>-images-error" class="error-message text-danger">
                                        <?php if (isset($errors["variant.{$i}.images"])) : ?>
                                            <?= $errors["variant.{$i}.images"] ?>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!$is_simple || $i > 0) : ?>
                                        <button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button>
                                    <?php endif; ?>
                                </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                    <button type="button" id="add-variant" class="btn btn-primary" <?= $is_simple ? 'disabled' : '' ?>>Add Variant</button>
                </div>

                <button type="submit" class="btn btn-success" name="btn_add" value="add">Save</button>

            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var isSimpleCheckbox = document.getElementById('is_simple');
                    var variantsSection = document.getElementById('variants-section');
                    var addVariantButton = document.getElementById('add-variant');
                    var variantsBody = document.getElementById('variants-body');
                
                    
                });
                // Hàm cập nhật các tùy chọn variant
                function updateVariantOptions() {
                    const rows = document.querySelectorAll('#variants-body tr');
                    const usedCombinations = new Set();

                    rows.forEach(row => {
                        const color = row.querySelector('select[name$="[color]"]').value;
                        const size = row.querySelector('select[name$="[size]"]').value;
                        if (color && size) {
                            usedCombinations.add(`${color}-${size}`);
                        }
                    });

                    rows.forEach(row => {
                        const colorSelect = row.querySelector('select[name$="[color]"]');
                        const sizeSelect = row.querySelector('select[name$="[size]"]');

                        colorSelect.querySelectorAll('option').forEach(option => {
                            option.disabled = false;
                            option.classList.remove('text-muted', 'font-weight-bold', 'bg-light');
                        });
                        sizeSelect.querySelectorAll('option').forEach(option => {
                            option.disabled = false;
                            option.classList.remove('text-muted', 'font-weight-bold', 'bg-light');
                        });

                        if (colorSelect.value) {
                            colorSelect.querySelector(`option[value="${colorSelect.value}"]`).classList.add('font-weight-bold', 'bg-light');
                            sizeSelect.querySelectorAll('option').forEach(option => {
                                if (option.value && usedCombinations.has(`${colorSelect.value}-${option.value}`)) {
                                    option.disabled = true;
                                    option.classList.add('text-muted');
                                }
                            });
                        }

                        if (sizeSelect.value) {
                            sizeSelect.querySelector(`option[value="${sizeSelect.value}"]`).classList.add('font-weight-bold', 'bg-light');
                            colorSelect.querySelectorAll('option').forEach(option => {
                                if (option.value && usedCombinations.has(`${option.value}-${sizeSelect.value}`)) {
                                    option.disabled = true;
                                    option.classList.add('text-muted');
                                }
                            });
                        }
                    });
                }


                // Hàm thêm sự kiện lắng nghe cho các select màu và kích thước
                function addVariantListeners(row) {
                    const colorSelect = row.querySelector('select[name$="[color]"]');
                    const sizeSelect = row.querySelector('select[name$="[size]"]');

                    [colorSelect, sizeSelect].forEach(select => {
                        select.addEventListener('change', updateVariantOptions);
                    });
                }

                // Sự kiện khi thay đổi checkbox "Is Simple Product"
                document.getElementById('is_simple').addEventListener('change', function() {
                    const isSimple = this.checked;
                    const variantsSection = document.getElementById('variants-section');
                    const addVariantButton = document.getElementById('add-variant');
                    const variantsBody = document.getElementById('variants-body');

                    // Hiển thị/ẩn phần variants và nút add-variant
                    variantsSection.style.display = isSimple ? 'block' : 'block';
                    addVariantButton.disabled = isSimple;

                    // Xử lý khi sản phẩm là đơn giản
                    if (isSimple) {
                        while (variantsBody.rows.length > 1) {
                            variantsBody.deleteRow(-1);
                        }
                        document.querySelectorAll('#variants-body .remove-variant').forEach(button => button.style.display = 'none');
                    } else {
                        document.querySelectorAll('#variants-body .remove-variant').forEach(button => button.style.display = 'inline-block');
                    }
                    
                    updateVariantOptions();
                });

                const colors = <?php echo json_encode($colors); ?>;
                const sizes = <?php echo json_encode($sizes); ?>;

                function escapeHtml(unsafe) {
                    return unsafe
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                }

                document.getElementById('add-variant').addEventListener('click', function() {
                    let variantCount = document.querySelectorAll('#variants-body tr').length;
                    
                    let newRow = `
                        <tr>
                            <td>
                                <select name="variant[${variantCount}][color]" class="form-control">
                                    <option value="">--Select--</option>
                                    ${colors.map(color => `<option value="${color.id}">${escapeHtml(color.color_name)}</option>`).join('')}
                                </select>
                                <span id="variant-${variantCount}-color-error" class="error-message text-danger"></span>
                            </td>
                            <td>
                                <select name="variant[${variantCount}][size]" class="form-control">
                                    <option value="">--Select--</option>
                                    ${sizes.map(size => `<option value="${size.id}">${escapeHtml(size.size_name)}</option>`).join('')}
                                </select>
                                <span id="variant-${variantCount}-size-error" class="error-message text-danger"></span>
                            </td>
                            <td>
                                <input type="text" name="variant[${variantCount}][stock]" class="form-control">
                                <span id="variant-${variantCount}-stock-error" class="error-message text-danger"></span>
                            </td>
                            <td>
                                <input type="text" name="variant[${variantCount}][price]" class="form-control">
                                <span id="variant-${variantCount}-price-error" class="error-message text-danger"></span>
                            </td>
                            <td>
                                <input type="file" name="variant[${variantCount}][images][]" class="form-control" multiple accept="image/*">
                                <span id="variant-${variantCount}-images-error" class="error-message text-danger"></span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button>
                            </td>
                        </tr>`;
                    document.getElementById('variants-body').insertAdjacentHTML('beforeend', newRow);
                    
                    let lastRow = document.getElementById('variants-body').lastElementChild;
                    addVariantListeners(lastRow);
                    if (typeof window.attachEventListeners === 'function') {
                    window.attachEventListeners(lastRow);
}
                    updateVariantOptions();
                });

                
                // Sự kiện khi nhấn nút "Remove" variant
                document.getElementById('variants-body').addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-variant')) {
                        e.target.closest('tr').remove();
                        updateVariantOptions();
                    }
                });

                // Thêm sự kiện lắng nghe cho các hàng variant hiện có
                document.querySelectorAll('#variants-body tr').forEach(row => {
                    addVariantListeners(row);
                });

                // Cập nhật các tùy chọn ban đầu
                updateVariantOptions();

            </script>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->

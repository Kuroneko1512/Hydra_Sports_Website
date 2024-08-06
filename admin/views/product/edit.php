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
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="ml-auto text-right">
                <a href="<?= $route->getLocateAdmin('list-product') ?>" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z"/>
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
            <form class="form-horizontal" method="post" action="<?= $route->getLocateAdmin('post-edit-product') ?>" enctype="multipart/form-data">
                
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                
                <h4 class="card-title">Edit Product</h4>

                <div class="mb-3">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>">
                    <p class="error"><?php if (isset($errors['product_name'])) echo $errors['product_name']; ?></p>
                </div>

                <div class="mb-3">
                    <label for="category_id">Category</label>
                    <select class="select2 form-control" style="width: 100%; height:36px;" name="category_id">
                        <option value="">--Select--</option>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['category_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="error"><?php if (isset($errors['category_id'])) echo $errors['category_id']; ?></p>
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" class="form-control" value="<?= htmlspecialchars($product['description']) ?>">
                    <p class="error"><?php if (isset($errors['description'])) echo $errors['description']; ?></p>
                </div>

                <div class="mb-3">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= $product['image'] ?>" alt="Product Image" width="100">
                    <?php endif; ?>
                    <p class="error"><?php if (isset($errors['image'])) echo $errors['image']; ?></p>
                </div>

                <div class="mb-3">
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
                            <?php if (isset($variants) && is_array($variants)): ?>
                                <?php foreach ($variants as $index => $variant): ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="variant[<?= $index ?>][id]" value="<?= $variant['id'] ?>">
                                            <select name="variant[<?= $index ?>][color]" class="form-control">
                                                <option value="">--Select--</option>
                                                <?php foreach ($colors as $color) : ?>
                                                    <option value="<?= $color['id'] ?>" <?= $variant['color_id'] == $color['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($color['color_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="variant[<?= $index ?>][size]" class="form-control">
                                                <option value="">--Select--</option>
                                                <?php foreach ($sizes as $size) : ?>
                                                    <option value="<?= $size['id'] ?>" <?= $variant['size_id'] == $size['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($size['size_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="variant[<?= $index ?>][stock]" class="form-control" value="<?= htmlspecialchars($variant['stock']) ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="variant[<?= $index ?>][price]" class="form-control" value="<?= htmlspecialchars($variant['price']) ?>">
                                        </td>
                                        <td>
                                            <input type="file" name="variant[<?= $index ?>][images][]" class="form-control" multiple accept="image/*">
                                            <?php if (isset($variant['images']) && is_array($variant['images'])): ?>
                                                <?php foreach ($variant['images'] as $image): ?>
                                                    <img src="<?= $image['image_url'] ?>" alt="Variant Image" width="50">
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <button type="button" id="add-variant" class="btn btn-primary btn-sm">Add Variant</button>
                </div>

                <button type="submit" class="btn btn-success">Update Product</button>
            </form>

            <script>
                document.getElementById('add-variant').addEventListener('click', function() {
                    let variantCount = document.querySelectorAll('#variants-body tr').length;
                    let newRow = `<tr>
                                    <td>
                                        <input type="hidden" name="variant[${variantCount}][id]" value="">
                                        <select name="variant[${variantCount}][color]" class="form-control">
                                            <option value="">--Select--</option>
                                            <?php foreach ($colors as $color) : ?>
                                                <option value="<?= $color['id'] ?>"><?= htmlspecialchars($color['color_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="variant[${variantCount}][size]" class="form-control">
                                            <option value="">--Select--</option>
                                            <?php foreach ($sizes as $size) : ?>
                                                <option value="<?= $size['id'] ?>"><?= htmlspecialchars($size['size_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="variant[${variantCount}][stock]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="variant[${variantCount}][price]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" name="variant[${variantCount}][images][]" class="form-control" multiple accept="image/*">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button>
                                    </td>
                                  </tr>`;
                    document.getElementById('variants-body').insertAdjacentHTML('beforeend', newRow);
                });

                document.getElementById('variants-body').addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-variant')) {
                        event.target.closest('tr').remove();
                    }
                });

                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('#variants-body tr').forEach(function(row, index) {
                        let variantId = row.querySelector('input[name^="variant"]').value;

                        let hasOrderDetail = orderDetails.some(detail => detail.product_variant_id == variantId);

                        if (hasOrderDetail) {
                            row.querySelector('.remove-variant').style.display = 'none';
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

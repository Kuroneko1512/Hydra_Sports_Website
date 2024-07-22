   <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Products</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Library</li>
                        </ol>
                    </nav>
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
        <div class="card" id="TableProduct">
                            <div class="card-body">
                                <h5 class="card-title m-b-0">Products</h5>
                            </div>
                                <div class="table-responsive ">
                                    <table id="zero_config3" class="table table-striped table-bordered  table-hover table-sm">
                                        <thead class="">
                                            <tr>
                                                <th>
                                                    <label class="customcheckbox m-b-20">
                                                        <input type="checkbox" id="mainCheckbox" />
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </th>
                                                <th scope="col">ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Created</th>
                                                <th scope="col">Updated</th>
                                                <th scope="col">Views</th>
                                                <th scope="col">Sales</th>
                                                <th scope="col">Reviews</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="customtable">
                                            <?php foreach ($products as $product){ ?>
                                                <tr>
                                                <td>
                                                    <label class="customcheckbox">
                                                        <input type="checkbox" class="listCheckbox" />
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td><?= $product['id'] ?></td>
                                                <td>
                                                    <a href="#" class="product-name" data-product-id="1"><?= $product['product_name']  ?></a>
                                                </td>
                                                <td><?php 
                                                foreach ($categories as $cat)
                                                 if ($cat['id'] == $product['category_id']) echo $cat['category_name'];
                                                
                                                ?></td>
                                                <td><?= $product['description'] ?></td>
                                                <td><?= $product['created_date'] ?></td>
                                                <td><?= $product['updated_date'] ?></td>
                                                <td><?= $product['view_count'] ?></td>
                                                <td><?= $product['purchase_count'] ?></td>
                                                <td><?= $product['comment_count'] ?></td>
                                                <td>Active</td>
                                                <td>
                                                    <a href="<?= $route->getLocateAdmin('product_edit') ?>&id=<?= $product['id'] ?>">
                                                        <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                                    </a>
                                                    <a href="<?= $route->getLocateAdmin('') ?>&id=<?= $product['id'] ?>" onclick="return confirm ('Bạn có muốn xóa không')" >
                                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                                    </a>
                                                </td>
                                            </tr>

                                           <?php  } ?>
                                           
                                        </tbody>
                                    </table>
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
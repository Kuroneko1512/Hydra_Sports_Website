    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Dashboard</h4>
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
        <div class="row">
            <div class="col-12">
                <div class="card" id="TableCategory">
                    <div class="card-body">
                        <h5 class="card-title m-b-0">Products</h5>
                    </div>
                    <div class="table-responsive table-hover">
                        <table id="zero_config2" class="table table-striped table-bordered">
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
                                    <th scope="col">Create Date</th>
                                    <th scope="col">Update Date</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Purchase</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="customtable">
                                <?php foreach ($products as $product) {
                                ?>
                                    <tr>
                                        <td>
                                            <label class="customcheckbox">
                                                <input type="checkbox" class="listCheckbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td><?= $product['id'] ?></td>
                                        <td><?= $product['product_name'] ?></td>
                                        <td><?= $product['category_id  '] ?></td>
                                        <td><?= $product['created_date']  ?></td>
                                        <td><?= $product['updated_date'] ?></td>
                                        <td><?= $product['view_count'] ?></td>
                                        <td><?= $product['purchase_count'] ?></td>
                                        <td><?= $product['comment_count'] ?></td>
                                        <td><?= ($product['status'] == 1) ? "Active" : "Inactive" ?></td>
                                        <td>
                                            <a href="">
                                                <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                            </a>
                                            <a href="">
                                                <button type="button" class="btn btn-warning btn-sm">Delete</button>
                                            </a>
                                        </td>
                                    </tr>

                                <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
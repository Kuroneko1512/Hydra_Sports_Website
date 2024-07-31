    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Review</h3>
                <div class="ml-2 mt-2 p-1 text-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<? $route->getLocateAdmin() ?>">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Review</li>
                            <li class="breadcrumb-item active" aria-current="page">List</li>
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
                <div class="card" id="TableReview">
                    <div class="card-body">
                        <h5 class="card-title m-b-0">Review</h5>
                    </div>
                    <div class="table-responsive table-hover table-sm">
                        <table id="zero_config1" class="table table-striped table-bordered">
                            <thead class="">
                                <tr>
                                    <th>
                                        <label class="customcheckbox m-b-20">
                                            <input type="checkbox" id="mainCheckbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">ID</th>
                                    <th scope="col">User_ID</th>
                                    <th scope="col">Product_ID</th>
                                    <th scope="col">Order_ID</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Created_Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="customtable">
                                <?php foreach ($reviews as $review) {?>
                                <tr>
                                    <td>
                                        <label class="customcheckbox">
                                            <input type="checkbox" class="listCheckbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td><?= $review['id'] ?></td>
                                    <td>
                                        <?php foreach ($users as $user)
                                            if ($user['id'] == $review['user_id']) echo $user['username'];
                                        ?>
                                    </td>
                                    <td><?php
                                        foreach ($products as $product) 
                                            if ($product['id'] == $review['product_id']) echo $product['product_name'];
                                        ?></td>
                                    <td><?= $review['order_id'] ?></td>
                                    <td><?= $review['rating'] ?></td>
                                    <td><?= $review['content'] ?></td>
                                    <td><?= $review['created_date'] ?></td>
                                    <td>
                                        <a href="<?= $route->getLocateAdmin('review_edit') ?>&id=<?= $review['id'] ?>  ">
                                            <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                        </a>
                                        <a href="<?= $route->getLocateAdmin('') ?>&id=<?= $review['id'] ?>" onclick="return confirm ('Bạn có muốn xóa không?')" ></a>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            <?php }   ?>

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
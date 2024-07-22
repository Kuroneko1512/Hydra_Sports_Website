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
                        <h5 class="card-title m-b-0">Category</h5>
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
                                    <th scope="col">Category Name</th>
                                    <!-- <th scope="col">UserName</th>
                                    <th scope="col">PassWord</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Role</th> -->
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="customtable">
                                <?php foreach ($categories as $category) { ?>
                                <tr>
                                    <td>
                                        <label class="customcheckbox">
                                            <input type="checkbox" class="listCheckbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $category['id'];?></td>
                                    <td><?php echo $category['category_name'];?></td>
                                    <!-- <td>hunttph47401</td>
                                    <td>hungtran</td>
                                    <td>hungttph47401@fpt.edu.com</td>
                                    <td>Hà Nội</td>
                                    <td>+84 123 456 789</td>
                                    <td>admin</td> -->
                                    <td><?= ($category['status'] == 1 ) ? "Active" : "Inactive" ?></td>
                                    <td>
                                        <a href="<?= $route->getLocateAdmin('category_edit') ?>&id=<?= $category['id'] ?>">
                                            <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                        </a>
                                        <a href="<?= $route->getLocateAdmin('ban-category', ['id' => $category['id']]) ?>"  onclick="return confirm ('Bạn có muốn xóa không')">
                                            <button type="button" class="btn btn-warning btn-sm">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
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
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
                                    <th scope="col">FullName</th>
                                    <th scope="col">UserName</th>
                                    <th scope="col">PassWord</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="customtable">
                                
                                <?php if ($reviews): ?>
                                    <?php foreach($reviews as $reviews): ?>

                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- <tr><td colspan="11">No data</td></tr> -->
                                <?php endif; ?>
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
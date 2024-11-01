    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Users</h3>
                <div class="ml-2 mt-2 p-1 text-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<? $route->getLocateAdmin() ?>">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Users</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div class="ml-auto text-right">
                    <a href="<?= $route->getLocateAdmin('list-user') ?>" class="btn btn-success" >
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

                <!-- <form action="" method="Post"> -->
                <form action="<?= $route->getLocateAdmin('post-edit-user', ['id' => $user['id']]) ?>" method="Post">
                    <div class="mb-3">
                        <label for="" class="form-label">Full name</label>
                        <input type="text" class="form-control" id="" name="full_name" placeholder="Full name" value="<?= $user['full_name'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Username</label>
                        <input type="text" class="form-control" id="" name="username" placeholder="Username"  value="<?= $user['username'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">PassWord</label>
                        <input type="password" class="form-control" id="" name="password" placeholder="Password" value="<?= $user['password'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" id="" name="email" placeholder="Email" value="<?= $user['email'] ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Address</label>
                        <input type="text" class="form-control" id="" name="address" placeholder="Address" value="<?= $user['address'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="" name="phone" placeholder="Phone" value="<?= $user['phone'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">role</label>
                        <select name="role" id="">
                            <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>

                    <!-- <button type="submit" class="btn btn-primary" name="btn-edit-user">Submit</button> -->
                    <button type="submit" class="btn btn-primary" >Submit</button>
                </form>

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
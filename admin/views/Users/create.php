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
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
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

                
                <!-- <form action="" method="POST" id="createUserForm"> -->
                <form action="<?= $route->getLocateAdmin('post-create-user') ?>" method="POST" id="createUserForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="" class="form-label">Avatar</label>
                        <input type="file" class="form-control" name="avatar" accept="image/*">
                        <span id="avatar-error" class="error-message text-danger">
                            <?php if (isset($errors['avatar'])) : ?>
                                <?= $errors['avatar'] ?>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Full name</label>
                        <input  type="text" class="form-control"  name="full_name" placeholder="Full name">
                        <span id="full_name-error" class="error-message text-danger">
                            <?php if (isset($errors['full_name'])) :?>
                                <?= $errors['full_name'] ?>
                            <?php endif; ?>
                        </span>                        
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Username</label>
                        <input  type="text" class="form-control"  name="username" placeholder="Username">
                        <span id="username-error" class="error-message text-danger">
                            <?php if (isset($errors['username'])) : ?>    
                                <?= $errors['username'] ?>
                            <?php endif; ?>
                        </span>                       
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">PassWord</label>
                        <input  type="password" class="form-control"  name="password" placeholder="Password">                        
                        <span id="password-error" class="error-message text-danger">
                            <?php if (isset($errors['password'])) : ?>
                                <?= $errors['password'] ?>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input  type="email" class="form-control"  name="email" placeholder="Email">
                        <span id="email-error" class="error-message text-danger">
                            <?php if (isset($errors['email'])) : ?>
                                <?= $errors['email'] ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Address</label>
                        <input  type="text" class="form-control"  name="address" placeholder="Address">
                        <span id="address-error" class="error-message text-danger">
                            <?php if (isset($errors['address'])) :?>
                                <?= $errors['address'] ?>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Phone</label>
                        <input  type="text" class="form-control"  name="phone" placeholder="Phone">
                        <span id="phone-error" class="error-message text-danger">
                            <?php if (isset($errors['phone'])) : ?>
                                <?= $errors['phone'] ?>
                            <?php endif; ?>
                        </span>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="" class="form-label">role</label>
                        <select name="role" id="">
                            <option value="0">User</option>
                        </select>
                    </div> -->

                    <!-- <button type="submit" class="btn btn-primary" name="btn-add-user">Submit</button> -->
                    <button type="submit" class="btn btn-primary" >Create</button>
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
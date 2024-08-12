   <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Category</h3>
                <div class="ml-2 mt-2 p-1 text-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<? $route->getLocateAdmin() ?>">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Category</li>
                            <li class="breadcrumb-item active" aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ml-auto text-right">
                    <a href="<?= $route->getLocateAdmin('create-category') ?>" class="btn btn-success" >
                        <!-- <i class="bi bi-person-add"></i> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                            <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
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
                                    <th scope="col">Image</th>
                                    <th scope="col">Category Name</th>   
                                    <th scope="col">Description</th>           
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="customtable">
                                <?php if ($categories): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td>
                                                <label class="customcheckbox">
                                                    <input type="checkbox" class="listCheckbox" />
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td><?= $category['id'] ?></td>
                                            <td>
                                                <img src="uploads/category/<?= $category['image'] ?>" alt="" width="50px" >
                                            </td>
                                            <td><?= $category['category_name'] ?></td>
                                            <td><?= $category['description'] ?></td>

                                            <td><?= ($category['status'] == 1) ? 'Active' : 'Inactive' ?></td>
                                            <td>
                                                <a href="<?= $route->getLocateAdmin('edit-category', ['id' => $category['id']]) ?>">
                                                    <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                                </a>
                                                <?php if ($category['status'] != 0): ?>
                                                    <a href="<?= $route->getLocateAdmin('inactive-category', ['id' => $category['id']]) ?>">
                                                        <button type="button" class="btn btn-warning btn-sm">Inactive</button>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= $route->getLocateAdmin('active-category', ['id' => $category['id']]) ?>">
                                                        <button type="button" class="btn btn-success btn-sm">Active</button>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <tr><td colspan="5"><p class="text-center">No data</p></td></tr>
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
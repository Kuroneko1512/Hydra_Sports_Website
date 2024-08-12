<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h3 class="page-title">Orders</h3>
            <div class="ml-2 mt-2 p-1 text-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $route->getLocateAdmin() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Order</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="ml-auto text-right">
                <a href="<?= $route->getLocateAdmin('list-order') ?>" class="btn btn-success">
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
            <form class="form-horizontal" method="post" action="">
                
                <h4 class="card-title">Edit Order</h4>

                <div class="mb-3">
                    <label for="product_name">ID</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?= $order['id'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="category_id">Status</label>
                    <select class="select2 form-control" style="width: 100%; height:36px;" name="order_status_id">
                        <option value="">--Select--</option>
                        <?php foreach ($orderStatus as $st) : ?>
                            <option value="<?= $st['id'] ?>" <?= $order['order_status_id'] == $st['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($st['status_name']) ?> <!-- ký tự đặc biệt trong trạng thái -> thực thể html tương ứng -->
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                        <!-- Giao diện Order Detail-->
                <div class="mb-3">
                    <h5>Item</h5>
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                           
                        </thead>
                        <tbody id="variants-body">
                            <?php if (isset($orderDetails) && is_array($orderDetails)): ?>
                                <?php foreach ($orderDetails as $index => $item): ?>
                                    <tr>
                                        <td>
                                            <?= $item['product_name'];?>
                                        </td>
                                        <td>
                                            <?= $item['quantity'];?>
                                        </td>
                                        <td>
                                            <?= $item['price'];?>
                                        </td>
                                        <td>
                                            <?= $item['price'] * $item['quantity'];?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>Total Price</td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $totalPrice ?></td>
                                </tr>
                              
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-success" value="1" name="btn_edit">Update Order</button>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

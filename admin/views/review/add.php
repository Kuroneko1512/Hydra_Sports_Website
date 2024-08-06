<form class="form-horizontal" method="post">
    
    <div class="card">
        <div class="card-body">
        <h3 class="page-title">Reviews</h3>
                <div class="ml-2 mt-2 p-1 text-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<? $route->getLocateAdmin() ?>">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Reviews</li>
                            <li class="breadcrumb-item active" aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
                <div class="form-group">
                        <label for="position-bottom-left">User </label>
                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="user_id">
                                    <option value="">--Chọn--</option>
                                    <?php 
                                        foreach($users as $user){ ?>
                                            <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                                        <?php }
                                    ?>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="position-bottom-left">Product </label>
                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="product_id">
                                    <option value="">--Chọn--</option>
                                    <?php 
                                        foreach($products as $product){ ?>
                                            <option value="<?= $product['id'] ?>"><?= $product['product_name'] ?></option>
                                        <?php }
                                    ?>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="position-top-right">Mã đơn hàng</label>
                        <input type="text" name="order_id" id="position-top-right" class="form-control demo" data-position="top right" value="<?php echo isset($_POST['order_id']) ? $_POST['order_id'] : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="position-top-right">Đánh giá</label>
                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="rating">
                                <option value="">--Chọn--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position-top-right">Nội dung</label>
                        <input type="text" name="content" id="position-top-right" class="form-control demo" data-position="top right" value="<?php echo isset($_POST['content']) ? $_POST['content'] : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="position-top-right">Ngày thực hiện</label>
                        <input type="date" name="created_date" id="position-top-right" class="form-control demo" data-position="top right" value="<?php echo isset($_POST['created_date']) ? $_POST['created_date'] : "" ?>">
                    </div>
        </div>
        <div class="border-top">
            <div class="card-body">
                <button type="submit" class="btn btn-success" name="btn_add" value="add" >Save</button>
            </div>
        </div>
    </div>
</form>
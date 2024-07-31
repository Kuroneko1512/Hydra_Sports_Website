<form class="form-horizontal" method="post" enctype="multipart/form-data"  >
<div class="card">
    <div class="card-body">
                <h4 class="card-title">Product Add</h4>
                <div class="form-group">
                    <label for="hue-demo">Product Name</label>
                    <input type="text" name="product_name" id="hue-demo" class="form-control demo" data-control="hue" value="<?php echo isset($_POST['product_name']) ? $_POST['product_name'] : "" ?>">
                    <p class="error"> <?php if(isset($error['product_name'])) echo $error['product_name'] ?></p>

                </div>
                <div class="form-group">
                    <label for="position-bottom-left">Category Name</label>
                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="category_id">
                                <option value="">--Chọn--</option>
                                <?php 
                                    foreach($categories as $cat){ ?>
                                        <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                                    <?php }
                                ?>
                        </select>
                </div>
                <div class="form-group">
                    <label for="position-top-right">Description</label>
                    <input type="text" name="description" id="position-top-right" class="form-control demo" data-position="top right" value="<?php echo isset($_POST['description']) ? $_POST['description'] : "" ?>">
                    <p class="error"> <?php if(isset($error['description'])) echo $error['description'] ?></p>

                </div>
        <tr class="sub-table">
        <td colspan="13">
            <table class="table table-striped table-bordered  table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <label for="">Variant</label>
                        <tr>
                            <td></td>
                            <td>
                                <select name="variant[0][color]" id="">
                                    <option value="">--Chọn--</option>
                                    <?php 
                                    foreach($colors as $color){ ?>
                                        <option value="<?= $color['id'] ?>"><?= $color['color_name'] ?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <td>
                                <select name="variant[0][size]" id="">
                                <option value="">--Chọn--</option>
                                    <?php 
                                    foreach($sizes as $size){ ?>
                                        <option value="<?= $size['id'] ?>"><?= $size['size_name'] ?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="variant[0][stock]" value="">
                            </td>
                            <td>
                                <input type="text" name="variant[0][price]" value="">
                            </td>
                            <td>
                                <input type="file" name="image0">
                            </td>
                            <td>
                                <a href="">
                                    <button type="button" class="btn btn-cyan btn-sm">Add</button>
                                </a>
                                <a href="">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <select name="variant[1][color]" id="">
                                    <option value="">--Chọn--</option>
                                    <?php 
                                    foreach($colors as $color){ ?>
                                        <option value="<?= $color['id'] ?>"><?= $color['color_name'] ?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <td>
                                <select name="variant[1][size]" id="">
                                <option value="">--Chọn--</option>
                                    <?php 
                                    foreach($sizes as $size){ ?>
                                        <option value="<?= $size['id'] ?>"><?= $size['size_name'] ?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="variant[1][stock]" value="">
                            </td>
                            <td>
                                <input type="text" name="variant[1][price]" value="">
                            </td>
                            <td>
                                <input type="file" name="image1">
                            </td>
                            <td>
                                <a href="">
                                    <button type="button" class="btn btn-cyan btn-sm">Add</button>
                                </a>
                                <a href="">
                                </a>
                            </td>
                        </tr>
                
                </tbody>
            </table>
        </td>
    </tr>           
    </div>
    <div class="border-top">
        <div class="card-body">
            <button type="submit" class="btn btn-success" name="btn_add" value="add" >Save</button>
        </div>
    </div>
</div>
</form>
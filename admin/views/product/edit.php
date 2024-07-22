<?php
// var_dump($data['productVariantById']);

?>
<form class="form-horizontal" method="post">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Product Edit</h4>
            <div class="form-group">
                <label for="hue-demo">Product Name</label>
                <input type="text" name="product_name" id="hue-demo" class="form-control demo" data-control="hue" value="<?= $productById['product_name'] ?>">
                <p class="error"> <?php if (isset($error['product_name'])) echo $error['product_name'] ?></p>

            </div>
            <div class="form-group">
                <label for="position-bottom-left">Category Name</label>
                <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="category_id">
                    <option value="">--Chọn--</option>
                    <?php
                    foreach ($data['categories'] as $cat) { ?>
                        <option value="<?= $cat['id'] ?>" <?php if ($productById['category_id'] = $cat['id']) echo "selected" ?>> <?= $cat['category_name'] ?></option>
                    <?php }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="position-top-right">Description</label>
                <input type="text" name="description" id="position-top-right" class="form-control demo" data-position="top right" value="<?= $productById['description'] ?>">
                <p class="error"> <?php if (isset($error['description'])) echo $error['description'] ?></p>

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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <label for="">Variant</label>
                            <?php
                            $i = 0;
                            foreach ($data['productVariantById'] as $key => $productVariant) { ?>
                                <tr>

                                    <td></td>
                                    <td>
                                        <select name="variant[<?=$key?>][color]" id="">
                                            <option value="">--Chọn--</option>
                                            <?php
                                            foreach ($data['colors'] as $color) { ?>
                                                <option value="<?= $color['id']?>" <?= $productVariant['color_id'] == $color['id'] ? "selected" : "" ?>><?= $color['color_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="number" hidden name="variant[<?=$key ?>][id]" value="<?= $productVariant['id'] ?>">
                                    </td>
                                    <td>
                                        <select name="variant[<?=$key ?>][size]" id="">
                                            <option value="">--Chọn--</option>
                                            <?php
                                            foreach ($data['sizes'] as $size) { ?>
                                                <option value="<?= $size['id'] ?>" <?= $productVariant['size_id'] == $size['id'] ? "selected" : "" ?>><?= $size['size_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="variant[<?=$key ?>][stock]" value="<?= $productVariant['stock'] ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="variant[<?=$key ?>][price]" value="<?= $productVariant['price'] ?>">
                                    </td>
                                    <td>
                                        <a href="">
                                            <button type="button" class="btn btn-cyan btn-sm">Add</button>
                                        </a>
                                        <a href="">
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                            ?>


                            <!-- <tr>
                            <td></td>
                            <td>
                                <select name="variant[0][color]" id="">
                                    <option value="">--Chọn--</option>
                                    <?php
                                    foreach ($data['colors'] as $color) { ?>
                                        <option  value="" <?= $data['productVariantById'][0]['color_id'] == $color['id'] ? "" : "selected" ?>><?= $color['color_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <select name="variant[0][size]" id="">
                                <option value="">--Chọn--</option>
                                    <?php
                                    foreach ($data['sizes'] as $size) { ?>
                                        <option  value="" <?= $data['productVariantById'][0]['size_id'] == $size['id'] ? "" : "selected" ?>><?= $size['size_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="variant[0][stock]" value="<?= $data['productVariantById'][0]['stock'] ?>">
                            </td>
                            <td>
                                <input type="text" name="variant[0][price]" value="<?= $data['productVariantById'][0]['price'] ?>">
                            </td>
                            <td>
                                <a href="">
                                    <button type="button" class="btn btn-cyan btn-sm">Add</button>
                                </a>
                                <a href="">
                                </a>
                            </td>
                        </tr> -->

                        </tbody>
                    </table>
                </td>
            </tr>
        </div>
        <div class="border-top">
            <div class="card-body">
                <button type="submit" class="btn btn-success" name="btn_edit" value="edit">Save</button>
            </div>
        </div>
    </div>
</form>
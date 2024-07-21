<form class="form-horizontal" method="post">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Category</h4>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Category Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="fname" placeholder="First Name Here" name="category_name" value="<?php echo $categoryById['category_name'] ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 text-right control-label col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="status">
                                    <option value="1" <?php echo $categoryById['status'] == 1 ? "selected" : "" ?>>Active  </option>
                                    <option value="0" <?php echo $categoryById['status'] == 0 ? "selected" : "" ?> >Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                    
                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary" name="btn-edit" value="edit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
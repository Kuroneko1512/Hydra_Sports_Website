<!-- Code hiện tại của bạn với một số bổ sung nhỏ -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h3 class="page-title">Color</h3>
            <div class="ml-2 mt-2 p-1 text-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<? $route->getLocateAdmin() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Color</li>
                        <li class="breadcrumb-item active" aria-current="page">Manage</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-4 border border-info rounded shadow-lg p-3 mb-5 bg-white" id="left-form">
            <h2 id="form-title">Add Color</h2>
            <form id="createColorForm" action="<?= $route->getLocateAdmin('add-color') ?>" method="POST">

                <div class="form-group">
                    <label for="colorName" class="form-label">Color Name</label>
                    <input type="text" class="form-control" id="colorName" name="color_name" required>
                    <span id="color_name-error" class="error-message text-danger"></span>
                </div>
                <button type="submit" id="formButton" class="btn btn-primary">Add</button>
            </form>
        </div>
        <div class="col-8">
            <div class="card" id="TableColor">
                <div class="card-body">
                    <h5 class="card-title m-b-0">Color</h5>
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
                                <th scope="col">Color Name</th>                        
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="customtable">
                            <?php if ($colors): ?>
                                <?php foreach ($colors as $color): ?>
                                    <tr>
                                        <td>
                                            <label class="customcheckbox">
                                                <input type="checkbox" class="listCheckbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td><?= $color['id'] ?></td>
                                        <td><?= $color['color_name'] ?></td>                                        
                                        <td>
                                            <button type="button" class="btn btn-cyan btn-sm editButton" data-id="<?= $color['id'] ?>" data-name="<?= $color['color_name'] ?>">Edit</button>
                                            <a href="<?= $route->getLocateAdmin('ban-user', ['id' => $color['id']]) ?>">
                                                <button type="button" class="btn btn-warning btn-sm">Ban</button>
                                            </a>
                                            <a href="<?= $route->getLocateAdmin('unban-user', ['id' => $color['id']]) ?>">
                                                <button type="button" class="btn btn-success btn-sm">UnBan</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="11">No data</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript để xử lý sự kiện nhấp vào nút Edit -->
<script>
document.querySelectorAll('.editButton').forEach(button => {
    button.addEventListener('click', function() {
        const colorId = this.dataset.id;
        const colorName = this.dataset.name;

        document.getElementById('form-title').textContent = 'Edit Color';
        document.getElementById('formButton').textContent = 'Update';
        document.getElementById('colorName').value = colorName;
        document.getElementById('createColorForm').action = '<?= $route->getLocateAdmin('edit-color') ?>';

        // Tạo input hidden và truyền giá trị id vào cho nó
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = colorId;
        document.getElementById('createColorForm').appendChild(idInput);
    });
});
</script>

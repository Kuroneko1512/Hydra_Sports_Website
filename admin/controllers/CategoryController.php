<?php 

class CategoryController extends BaseController
{
    public  $categoryModel;
    public function loadModels() {
        $this->categoryModel = new Category();
    }
    public function list() {
        $categories = $this->categoryModel->allTable();
        $this->viewApp->requestView('category.list', ['categories' => $categories]);
    }
    // Xác thực dữ liệu cho form tạo mới category
    public function validateCategoryData() {
        $this->handleValidation(false);
    }

    // Xác thực dữ liệu cho form chỉnh sửa category
    public function validateEditCategoryData() {
        $this->handleValidation(true);
    }

    // Xử lý chung cho việc xác thực dữ liệu
    private function handleValidation($isEdit) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'));
            $errors = $this->validateCategoryDataInternal($data, $isEdit);
            header('Content-Type: application/json');
            echo json_encode($errors);
            exit;
        }
    }

    // Logic xác thực chi tiết
    private function validateCategoryDataInternal($data, $isEdit = false) {
        $errors = [];
        $requiredFields = ['category_name','description'];

        // Kiểm tra các trường bắt buộc
        foreach ($requiredFields as $field) {
            if (empty($data->$field)) {
                $errors[$field] = ucfirst($field) . " không được để trống!!";
            }
        }

        // Lấy dữ liệu hiện có từ database
        $categoryTable = $this->categoryModel->getCategoryName();

        // Kiểm tra tính duy nhất của category_name
        if (!$isEdit) {
            $this->checkUniqueness($data, $errors, $categoryTable);
        } else {
            $this->checkUniquenessForEdit($data, $errors, $categoryTable);
        }

        return $errors;
    }

    // Kiểm tra tính duy nhất cho form tạo mới
    private function checkUniqueness($data, &$errors, $categoryTable) {
        if (in_array($data->category_name, $categoryTable)) {
            $errors['category_name'] = "Tên danh mục đã được sử dụng";
        }
    }

    // Kiểm tra tính duy nhất cho form chỉnh sửa
    private function checkUniquenessForEdit($data, &$errors, $categoryTable) {
        $currentCategoryName = $this->categoryModel->getCategoryNameById($data->id);
        if ($data->category_name !== $currentCategoryName && in_array($data->category_name, $categoryTable)) {
            $errors['category_name'] = "Tên danh mục đã được sử dụng";
        }
    }
    public function create(){
        $this->viewApp->requestView('category.create');
    }
    public function postCreate(){
        $categoryCreateForm = $this->route->form;
        $errors = $this->validateCategoryDataInternal((object)$categoryCreateForm, false);
        if (!empty($errors)) {
            $this->viewApp->requestView('category.create', ['errors' => $errors, 'category' => $categoryCreateForm]);
            return;
        } 
        $this->categoryModel->insertTable($categoryCreateForm);
        $this->route->redirectAdmin('list-category');
    }
    public function edit(){
        $id = $this->route->getId();
        $categoryUpdate = $this->categoryModel->findIdTable($id);
        $this->viewApp->requestView('category.edit',['category' => $categoryUpdate]);
    }
    public function postEdit(){
        $id = $this->route->getId();
        $categoryEditForm = $this->route->form;   
        $errors = $this->validateCategoryDataInternal((object)$categoryEditForm, true);
        if (!empty($errors)) {
            $this->viewApp->requestView('category.edit', ['errors' => $errors, 'category' => $categoryEditForm]);
            return;
        } 
        $this->categoryModel->updateIdTable($categoryEditForm,$id);
        $this->route->redirectAdmin('list-category');
    }  
    public function inactive(){
        $id = $this->route->getId();
        $relateTables = 
        [
            ['table' => 'product', 'key' => 'category_id']
        ];
        // [
        //     ['table' => 'product', 'key' => 'category_id'],
        //     ['table' => 'subcategory', 'key' => 'parent_category_id'],
        //     ['table' => 'category_attribute', 'key' => 'category_id']
        // ]
        
        $this->categoryModel->updateStatusIdTableAndRelated($id,'category',$relateTables,0);
        $this->route->redirectAdmin('list-category');
    }
    public function active(){
        $id = $this->route->getId();
        $relateTables = 
        [
            ['table' => 'product', 'key' => 'category_id']
        ];
        $this->categoryModel->updateStatusIdTableAndRelated($id,'category',$relateTables,1);
        $this->route->redirectAdmin('list-category');
    }
}
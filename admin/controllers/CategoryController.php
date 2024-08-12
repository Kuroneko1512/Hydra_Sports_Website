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
        if ((!$isEdit && empty($data->image)) || ($isEdit && !isset($data->image))) {
            $errors['image'] = "Ảnh danh mục là bắt buộc";
        }

        // Lấy dữ liệu hiện có từ database
        // $categoryTable = $this->categoryModel->getCategoryName();
        $categoryTable = array_map('strtolower', $this->categoryModel->getCategoryName());

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
        // if (in_array($data->category_name, $categoryTable)) {
        if (in_array(strtolower($data->category_name), $categoryTable)) {
            $errors['category_name'] = "Tên danh mục đã được sử dụng";
        }
    }

    // Kiểm tra tính duy nhất cho form chỉnh sửa
    private function checkUniquenessForEdit($data, &$errors, $categoryTable) {
        // $currentCategoryName = $this->categoryModel->getCategoryNameById($data->id);
        // if ($data->category_name !== $currentCategoryName && in_array($data->category_name, $categoryTable)) {
        $currentCategoryName = strtolower($this->categoryModel->getCategoryNameById($data->id));
        if (strtolower($data->category_name) !== $currentCategoryName && in_array(strtolower($data->category_name), $categoryTable)) {
            $errors['category_name'] = "Tên danh mục đã được sử dụng";
        }
    }
    public function create(){
        $this->viewApp->requestView('category.create');
    }
    public function postCreate(){
        $categoryCreateForm = (object) $this->route->form;
        $errors = $this->validateCategoryDataInternal((object)$categoryCreateForm, false);
        // Xử lý ảnh tải lên
        $file = isset($_FILES['image']) ? $_FILES['image'] : null;
        $result = $this->handleImageUpload($file);

        if (isset($result['errors'])) {
            $errors = array_merge($errors, $result['errors']);
        } else {
            $categoryCreateForm->image = $result; // Cập nhật ảnh mới
        }
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
        $categoryEditForm = (object) $this->route->form;
        $errors = $this->validateCategoryDataInternal((object)$categoryEditForm, true);
        // Lấy thông tin danh mục hiện tại
        $currentCategory = (object)$this->categoryModel->findIdTable($id);

        // Xử lý ảnh tải lên
        $file = isset($_FILES['image']) ? $_FILES['image'] : null;
        if ($file && $file['error'] === UPLOAD_ERR_OK && !empty($file['name'])) {
            // Có ảnh mới tải lên
            $result = $this->handleImageUpload($file, $currentCategory->image);

            if (isset($result['errors'])) {
                $errors = array_merge($errors, $result['errors']);
            } else {
                $categoryEditForm->image = $result; // Cập nhật ảnh mới
            }
        } else {
            // Không có ảnh mới, giữ ảnh cũ
            $categoryEditForm->image = $currentCategory->image;
        }

        if (!empty($errors)) {
            $this->viewApp->requestView('category.edit', ['errors' => $errors, 'category' => $categoryEditForm]);
            return;
        } 
        $this->categoryModel->updateIdTable($categoryEditForm,$id);
        $this->route->redirectAdmin('list-category');
    }  
    private function handleImageUpload($file, $currentImage = null) {
        $errors = [];
    
        // Kiểm tra tệp tải lên
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            // Lấy thông tin tệp
            $fileName = basename($file['name']);
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            // Tạo tên file đặc biệt
            $uniqueFileName = uniqid('img_', true) . '.' . $fileType;
            $targetDir = "uploads/category/" . $uniqueFileName;
    
            // Xóa ảnh cũ nếu có
            if ($currentImage && file_exists("uploads/category/" . $currentImage)) {
                unlink("uploads/category/" . $currentImage);
            }
    
            // Di chuyển tệp tải lên tới thư mục đích
            if (move_uploaded_file($file['tmp_name'], $targetDir)) {
                return $uniqueFileName; // Trả về tên ảnh mới
            } else {
                $errors[] = "Không thể upload ảnh. Vui lòng thử lại.";
            }
        } else {
            $errors[] = "Không có ảnh tải lên hoặc có lỗi khi tải lên.";
        }
    
        // Trả về mảng lỗi nếu có
        return ['errors' => $errors];
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
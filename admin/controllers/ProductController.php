<?php 

class ProductController extends BaseController {
    public $productModel;
    public  $categoryModel;
    public $productVariantModel;
    public $color;
    public $size;
    public $productVariantImageModel;
    public $orderModel;

    public function loadModels() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->productVariantModel = new ProductVariant();
        $this->color = new Color();
        $this->size = new Size();
        $this->productVariantImageModel = new ProductVariantImage();
        $this->orderModel = new Order();
    }
    public function list(){
        $products = $this->productModel->allTable();
   
        foreach ($products as $key => $value) {
            $productImages = $this->productVariantImageModel->all_Image_Table($value['id']);
            // pp($productImages);
            $products[$key]['image'] = isset($productImages[0]['image_url']) ? $productImages[0]['image_url'] : '';
        }
        $categories = $this->categoryModel->allTable();
        $data = ['products' => $products, 'categories' => $categories];
        // pp($products);
        
        $this->viewApp->requestView('product.list', $data);
    }
    public function getProductVariant() {
        $productId = $_GET['product_id'];
        $variants = $this->productVariantModel->getDataProductVariantByProductId($productId);
        foreach ($variants as &$variant) {
            $variant['images'] = $this->productVariantImageModel->getImageByProductVariantId($variant['id']);
        }
        echo json_encode($variants);
    }
    public function color(){
        $colors = $this->color->allTable();
        $this->viewApp->requestView('color.manage',['colors' => $colors]);
    }
    public function size(){
        $sizes = $this->size->allTable();
        $this->viewApp->requestView('size.manage',['sizes' => $sizes]);
    }
    public function addColor() {
        $addColorForm = $this->route->form;
        $errors = $this->validateColorDataInternal($addColorForm, false);
        if (!empty($errors)) {
            $this->viewApp->requestView('color.manage', ['errors' => $errors, 'addColor' => $addColorForm]);
            return;
        }
        $this->color->insertTable($addColorForm);
        $this->route->redirectAdmin('color');
    }
    public function editColor() {
        $editColorForm = (object)$this->route->form;
        $errors = $this->validateColorDataInternal($editColorForm, true);
        if (!empty($errors)) {
            $this->viewApp->requestView('color.manage', ['errors' => $errors, 'editColor' => $editColorForm]);
            return;
        }
        $this->color->updateIDTable((array)$editColorForm, $editColorForm->id);
        $this->route->redirectAdmin('color');
    }
    public function addSize() {
        $addSizeForm = (object)$this->route->form;
        $errors = $this->validateSizeDataInternal($addSizeForm, false);
        if (!empty($errors)) {
            $this->viewApp->requestView('size.manage', ['errors' => $errors, 'addSize' => $addSizeForm]);
            return;
        }
        $this->size->insertTable((array)$addSizeForm);
        $this->route->redirectAdmin('size');
    }
    public function editSize() {
        $editSizeForm = (object)$this->route->form;
        $errors = $this->validateSizeDataInternal($editSizeForm, true);
        if (!empty($errors)) {
            $this->viewApp->requestView('size.manage', ['errors' => $errors, 'editSize' => $editSizeForm]);
            return;
        }
        $this->size->updateIDTable((array)$editSizeForm, $editSizeForm->id);
        $this->route->redirectAdmin('size');
    }

    // Validate color and size
    public function validateColorData() {
        $this->handleValidation(false, 'color');
    }

    public function validateSizeData() {
        $this->handleValidation(false, 'size');
    }

    private function handleValidation($isEdit, $type) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'));
            $errors = ($type === 'color') ? $this->validateColorDataInternal($data, $isEdit) : $this->validateSizeDataInternal($data, $isEdit);
            header('Content-Type: application/json');
            echo json_encode($errors);
            exit;
        }
    }

    private function validateColorDataInternal($data, $isEdit = false) {
        $errors = [];
        $requiredFields = ['color_name'];

        // Kiểm tra các trường bắt buộc
        foreach ($requiredFields as $field) {
            if (empty($data->$field)) {
                $errors[$field] = ucfirst($field) . " không được để trống!!";
            }
        }

        // Lấy dữ liệu hiện có từ database
        $colorTable = array_map('strtolower', $this->color->getColorName());

        // Kiểm tra tính duy nhất của color_name
        if (!$isEdit) {
            $this->checkUniqueness($data, $errors, $colorTable);
        } else {
            $this->checkUniquenessForEdit($data, $errors, $colorTable);
        }

        return $errors;
    }

    private function validateSizeDataInternal($data, $isEdit = false) {
        $errors = [];
        $requiredFields = ['size_name'];

        foreach ($requiredFields as $field) {
            if (empty($data->$field)) {
                $errors[$field] = ucfirst($field) . " không được để trống!!";
            }
        }

        $sizeTable = array_map('strtolower', $this->size->getSizeName());

        if (!$isEdit) {
            $this->checkUniqueness($data, $errors, $sizeTable);
        } else {
            $this->checkUniquenessForEdit($data, $errors, $sizeTable);
        }

        return $errors;
    }

    // Kiểm tra tính duy nhất cho form tạo mới
    private function checkUniqueness($data, &$errors, $table) {
        $nameField = isset($data->color_name) ? 'color_name' : 'size_name';
        $nameValue = strtolower($data->$nameField);
    
        if (in_array($nameValue, $table)) {
            $errors[$nameField] = "Tên đã được sử dụng";
        }
    }
    
    private function checkUniquenessForEdit($data, &$errors, $table) {
        $nameField = isset($data->color_name) ? 'color_name' : 'size_name';
        $currentName = strtolower(
            isset($data->color_name)
                ? $this->color->getColorNameById($data->id)
                : $this->size->getSizeNameById($data->id)
        );
        $nameValue = strtolower($data->$nameField);
    
        if ($nameValue !== $currentName && in_array($nameValue, $table)) {
            $errors[$nameField] = "Tên đã được sử dụng";
        }
    }
    
    // Phần Sản phẩm
    public function create() {
        // Lấy danh sách các danh mục, màu sắc và kích thước để hiển thị trong view
        $categories = $this->categoryModel->allTable();
        $colors = $this->color->allTable();
        $sizes = $this->size->allTable();
        $errors = [];
        $data = [
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'errors' => $errors,
        ];
        
        // Hiển thị view để tạo sản phẩm mới
        $this->viewApp->requestView('product.add', $data);
    }
    public function store() {
        $data = $_POST;
        $files = $_FILES;
    
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        echo "<pre>";
        print_r($files);
        echo "</pre>";
        $targetDir = "uploads/products/";
    
        // Lưu ảnh chính của sản phẩm
        if (isset($files['image']['tmp_name']) && $files['image']['error'] === UPLOAD_ERR_OK) {
            $productImage = time() . "_" . basename($files['image']['name']);
            $targetProductImage = $targetDir . $productImage;
            // $productImage = $targetDir . basename($files['image']['name']);
            if (move_uploaded_file($files['image']['tmp_name'], $targetProductImage)) {
                // Bắt đầu giao dịch
                $this->productModel->conn->beginTransaction();
    
                try {
                    // Thêm sản phẩm
                    $productData = [
                        'product_name' => $data['product_name'],
                        'category_id' => $data['category_id'],
                        'description' => $data['description'],
                        'image' => $productImage
                    ];
                    $productId = $this->productModel->insertTable($productData);
    
                    // Thêm các biến thể sản phẩm
                    foreach ($data['variant'] as $index => $variant) {
                        $colorId = $variant['color'];
                        $sizeId = $variant['size'];
                        $stock = $variant['stock'];
                        $price = $variant['price'];

                        // Tạo biến thể sản phẩm
                        $variantData = [
                            'product_id' => $productId,
                            'color_id' => $colorId,
                            'size_id' => $sizeId,
                            'stock' => $stock,
                            'price' => $price
                        ];
                        $productVariantId = $this->productVariantModel->insertTable($variantData);

                        // Xử lý ảnh cho biến thể sản phẩm
                        if (isset($files['variant']['tmp_name'][$index]['images'])) {
                            echo "<pre>";
                            print_r($files['variant']['tmp_name'][$index]['images']);
                            echo "</pre>";
                            foreach ($files['variant']['tmp_name'][$index]['images'] as $key => $tmpName) {
                                if ($files['variant']['error'][$index]['images'][$key] === UPLOAD_ERR_OK) {
                                    $imageName = $files['variant']['name'][$index]['images'][$key];
                                    // $targetFile = $targetDir . basename($imageName);            
                                    $uploadImage = time() . "_" . basename($imageName);
                                    $targetFile = $targetDir . $uploadImage;

                                    // Di chuyển ảnh từ thư mục tạm đến thư mục đích
                                    if (move_uploaded_file($tmpName, $targetFile)) {
                                        $isPrimary = ($key === 0) ? 1 : 0;
                                        $imageData = [
                                            'product_variant_id' => $productVariantId,
                                            'image_url' => $uploadImage,
                                            'is_primary' => $isPrimary
                                        ];
                                        $imageId = $this->productVariantImageModel->insertTable($imageData);
                                        
                                        if (!$imageId) {
                                            throw new Exception("Failed to insert product variant image into database.");
                                        }
                                    } else {
                                        throw new Exception("Failed to move uploaded file: " . $imageName);
                                    }
                                } else {
                                    throw new Exception("File upload error: " . $files['variant']['error'][$index]['images'][$key]);
                                }
                            }
                        }
                    }
    
                    $this->productModel->conn->commit();
                    $this->route->redirectAdmin('list-product');
                    echo "Product added successfully!";
                } catch (Exception $e) {
                    $this->productModel->conn->rollBack();
                    echo "Failed to add product: " . $e->getMessage();
                }
            } else {
                echo "Failed to upload product image.";
            }
        } else {
            echo "File upload error: " . $files['image']['error'];
        }
    }
    public function softDelete(){
        $id = $id = $this->route->getId();
        $this->productModel->updateStatusIdTableAndRelated($id, 'product', [], 0);
        $this->route->redirectAdmin('list-product');
    }
    public function restore() {
        $id = $id = $this->route->getId();
        $this->productModel->updateStatusIdTableAndRelated($id, 'product', [], 1);
        $this->route->redirectAdmin('list-product');
    }
    public function edit() {
        $id = $id = $this->route->getId();
        // Lấy thông tin sản phẩm theo id
        $product = $this->productModel->findIdTable($id);
        
        // Lấy danh sách các danh mục, màu sắc và kích thước để hiển thị trong view
        $categories = $this->categoryModel->allTable();
        $colors = $this->color->allTable();
        $sizes = $this->size->allTable();
        
        // Lấy danh sách các biến thể của sản phẩm
        $variants = $this->productVariantModel->getDataProductVariantByProductId($id);
        foreach ($variants as &$variant) {
            $variant['images'] = $this->productVariantImageModel->getImageByProductVariantId($variant['id']);
        }
        $errors = [];
        $data = [
            'product' => $product,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'variants' => $variants,
            'errors' => $errors
        ];
        
        // Hiển thị view để chỉnh sửa sản phẩm
        $this->viewApp->requestView('product.edit', $data);
    }

    public function update() {
        try {
            $data = $_POST;
            $files = $_FILES;
            $productId = $data['product_id'];
            
            $this->productModel->conn->beginTransaction();
    
            // Xử lý cập nhật thông tin sản phẩm
            $productData = $this->handleProductUpdate($data, $files, $productId);
            $this->productModel->updateIdTable($productData, $productId);
    
            // Xử lý cập nhật các biến thể
            $this->handleVariantsUpdate($data, $files, $productId);
    
            $this->productModel->conn->commit();
            $this->route->redirectAdmin('list-product');
            echo "Product updated successfully!";
        } catch (Exception $e) {
            $this->productModel->conn->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
    
    private function handleProductUpdate($data, $files, $productId) {
        $currentProduct = $this->productModel->findIdTable($productId);
        $targetDir = "uploads/products/";
        $productData = [
            'product_name' => $data['product_name'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'image' => $currentProduct['image']
        ];
    
        if (isset($files['image']['tmp_name']) && $files['image']['error'] === UPLOAD_ERR_OK) {
            $productImage = time() . "_" . basename($files['image']['name']);
            $targetProductImage = $targetDir . $productImage;
            if (move_uploaded_file($files['image']['tmp_name'], $targetProductImage)) {
                if (file_exists($targetDir . $currentProduct['image'])) {
                    unlink($targetDir . $currentProduct['image']);
                }
                $productData['image'] = $productImage;
            } else {
                throw new Exception("Failed to upload product image.");
            }
        }
    
        return $productData;
    }
    
    private function handleVariantsUpdate($data, $files, $productId) {
        $existingVariants = $this->productVariantModel->getDataProductVariantByProductId($productId);
        $targetDir = "uploads/products/";
    
        foreach ($data['variant'] as $index => $variant) {
            $variantData = [
                'product_id' => $productId,
                'color_id' => $variant['color'],
                'size_id' => $variant['size'],
                'stock' => $variant['stock'],
                'price' => $variant['price']
            ];
    
            // Kiểm tra xem biến thể đã tồn tại chưa
            $existingVariant = $this->findExistingVariant($existingVariants, $variantData);
    
            if ($existingVariant) {
                $this->updateExistingVariant($existingVariant['id'], $variantData, $files, $index, $targetDir);
            } else {
                $this->addNewVariant($variantData, $files, $index, $targetDir);
            }
        }
    }
    private function findExistingVariant($existingVariants, $variantData) {
        foreach ($existingVariants as $variant) {
            if ($variant['product_id'] == $variantData['product_id'] &&
                $variant['color_id'] == $variantData['color_id'] &&
                $variant['size_id'] == $variantData['size_id']) {
                return $variant;
            }
        }
        return null;
    }
    private function updateExistingVariant($variantId, $variantData, $files, $index, $targetDir) {
        $this->productVariantModel->updateIdTable($variantData, $variantId);
        $currentVariantImages = $this->productVariantImageModel->getImageByProductVariantId($variantId);
    
        if (isset($files['variant']['tmp_name'][$index]['images'])) {
            $this->handleVariantImages($variantId, $files['variant'], $index, $targetDir, $currentVariantImages);
        }
    }      
    private function addNewVariant($variantData, $files, $index, $targetDir) {
        $variantId = $this->productVariantModel->insertTable($variantData);
    
        if (isset($files['variant']['tmp_name'][$index]['images'])) {
            $this->handleVariantImages($variantId, $files['variant'], $index, $targetDir);
        }
    }
    
    private function handleVariantImages($variantId, $files, $index, $targetDir, $currentImages = []) {
        // Kiểm tra xem có ảnh mới được tải lên không
        if (!isset($files['tmp_name'][$index]['images']) || empty($files['tmp_name'][$index]['images'][0])) {
            return; // Không có ảnh mới, giữ nguyên ảnh cũ
        }
    
        // Xóa tất cả ảnh hiện tại của biến thể này
        foreach ($currentImages as $currentImage) {
            $this->deleteVariantImage($currentImage['id'], $currentImage['image_url'], $targetDir);
        }
    
        // Tải lên và lưu các ảnh mới
        foreach ($files['tmp_name'][$index]['images'] as $key => $tmpName) {
            if (empty($tmpName)) continue;
    
            if ($files['error'][$index]['images'][$key] === UPLOAD_ERR_OK) {
                $imageName = $files['name'][$index]['images'][$key];                
                $uploadImage = time() . "_" . basename($imageName);
                $targetFile = $targetDir . $uploadImage;
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $isPrimary = ($key === 0) ? 1 : 0;
                    $imageData = [
                        'product_variant_id' => $variantId,
                        'image_url' => $uploadImage,
                        // 'image_url' => $targetFile,
                        'is_primary' => $isPrimary
                    ];
    
                    $this->productVariantImageModel->insertTable($imageData);
                } else {
                    throw new Exception("Không thể di chuyển file đã tải lên: " . $imageName);
                }
            } else if ($files['error'][$index]['images'][$key] !== UPLOAD_ERR_NO_FILE) {
                throw new Exception("Lỗi tải file: " . $files['error'][$index]['images'][$key]);
            }
        }
    }
        
    private function deleteVariantImage($imageId, $imageUrl, $targetDir ) {

        if (file_exists($targetDir . $imageUrl)) {
            unlink($targetDir . $imageUrl);
        }
        $this->productVariantImageModel->removeIdTable($imageId);
    }
    private function validateProductDataInternal($data, $isEdit = false) {
        $errors = [];
        
        // Chuyển đổi $data thành array nếu nó là object
        // $data = (array)$data;

        // Kiểm tra tên sản phẩm
        if (empty($data['product_name'])) {
            $errors['product_name'] = "Tên sản phẩm không được để trống";
        }

        // Kiểm tra danh mục
        if (empty($data['category_id'])) {
            $errors['category_id'] = "Danh mục không được để trống";
        }

        // Kiểm tra mô tả
        if (empty($data['description'])) {
            $errors['description'] = "Mô tả không được để trống";
        }

        // Kiểm tra ảnh sản phẩm
        if ((!$isEdit && empty($data['image'])) || ($isEdit && !isset($data['image']) && empty($data['image']))) {
            $errors['image'] = "Ảnh sản phẩm là bắt buộc";
        }

        // Lấy dữ liệu hiện có từ db
        $productTable = $this->productModel->getProductNameAndCategoryId();
        
        // Kiểm tra tính duy nhất của product_name và category_id
        if (!$isEdit) {
            $this->checkUniquenessProduct($data, $errors, $productTable);
        } 
        else {
            $this->checkUniquenessForEditProduct($data, $errors, $productTable);
        }


        // Kiểm tra biến thể
        if (!isset($data['is_simple']) || !$data['is_simple']) {
            if (!isset($data['variant']) || !is_array($data['variant']) || count($data['variant']) == 0) {
                $errors['variant'] = "Cần ít nhất một biến thể cho sản phẩm không đơn giản";
            } else {
                foreach ($data['variant'] as $index => $variant) {
                    // $variant = (array)$variant; // Chuyển đổi thành array nếu là object
                    if (!is_array($variant)) {
                        $variant = (array)$variant;
                    }

                    if (empty($variant['color'])) {
                        $errors["variant.{$index}.color"] = "Màu sắc không được để trống";
                    }
                    if (empty($variant['size'])) {
                        $errors["variant.{$index}.size"] = "Kích thước không được để trống";
                    }
                    if (!isset($variant['stock']) || $variant['stock'] === '') {
                        $errors["variant.{$index}.stock"] = "Số lượng tồn kho không được để trống";
                    } elseif (!is_numeric($variant['stock']) || $variant['stock'] < 0) {
                        $errors["variant.{$index}.stock"] = "Số lượng tồn kho phải là số không âm";
                    }
                    if (!isset($variant['price']) || $variant['price'] === '') {
                        $errors["variant.{$index}.price"] = "Giá không được để trống";
                    } elseif (!is_numeric($variant['price']) || $variant['price'] < 0) {
                        $errors["variant.{$index}.price"] = "Giá phải là số không âm";
                    }
                    // if (!$isEdit && empty($variant['images'])) {
                    //     $errors["variant.{$index}.images"] = "Ảnh biến thể là bắt buộc";
                    // }
                    if (!$isEdit && (empty($variant['images']) || !is_array($variant['images']) || count($variant['images']) === 0)) {
                        $errors["variant.{$index}.images"] = "Ảnh biến thể là bắt buộc";
                    }
                    
                }
            }
        }
        error_log("Validating product data: " . json_encode($data));
        if (isset($data['variant'])) {
            foreach ($data['variant'] as $index => $variant) {
                error_log("Validating variant $index: " . json_encode($variant));
                if (!isset($variant['images']) || empty($variant['images'])) {
                    error_log("Missing images for variant $index");
                }
            }
        }

        return $errors;
    }

    private function checkUniquenessProduct($data, &$errors, $productTable) {
        $nameValue = strtolower($data['product_name']);
        $categoryId = $data['category_id'];
        foreach ($productTable as $product) {
            if (strtolower($product['product_name']) === $nameValue && $product['category_id'] == $categoryId) {
                $errors['product_name'] = "Tên sản phẩm đã được sử dụng trong danh mục này";
                break;
            }
        }
    }

    private function checkUniquenessForEditProduct($data, &$errors, $productTable) {
        $nameValue = strtolower($data['product_name']);
        $categoryId = $data['category_id'];
        // $currentProduct = $this->productModel->getProductNameAndCategoryIdById($data['id']);
        
        foreach ($productTable as $product) {
            if (strtolower($product['product_name']) === $nameValue && $product['category_id'] == $categoryId && $product['id'] != $data['product_id']) {
                $errors['product_name'] = "Tên sản phẩm đã được sử dụng trong danh mục này";
                break;
            }
        }
    }
    private function handleValidationProductAndVariant($isEdit) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        error_log("Raw POST data: " . file_get_contents('php://input'));
        error_log("Parsed POST data: " . json_encode($_POST));
        error_log("Files data: " . json_encode($_FILES));
        
            // $data = json_decode(file_get_contents('php://input'));
            $data = json_decode(file_get_contents('php://input'), true);
            $errors = $this->validateProductDataInternal($data, $isEdit);
            header('Content-Type: application/json');
            echo json_encode($errors);
            exit;
        }
    }
    public function validateProductData() {
        $this->handleValidationProductAndVariant(false);
    }

    public function validateEditProductData() {
        $this->handleValidationProductAndVariant(true);
    }



    // Debug dữ liệu POST và FILES
                // echo "<pre>";
                // print_r($data);
                // print_r($files);
                // echo "<pre>";
                // die();  
                // Dừng thực thi để kiểm tra dữ liệu
    
}
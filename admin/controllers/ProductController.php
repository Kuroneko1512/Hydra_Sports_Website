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
        
        $data = [
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes
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
            $productImage = $targetDir . basename($files['image']['name']);
            if (move_uploaded_file($files['image']['tmp_name'], $productImage)) {
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
                                    $targetFile = $targetDir . basename($imageName);

                                    // Di chuyển ảnh từ thư mục tạm đến thư mục đích
                                    if (move_uploaded_file($tmpName, $targetFile)) {
                                        $isPrimary = ($key === 0) ? 1 : 0;
                                        $imageData = [
                                            'product_variant_id' => $productVariantId,
                                            'image_url' => $targetFile,
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
        
        $data = [
            'product' => $product,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'variants' => $variants
        ];
        
        // Hiển thị view để chỉnh sửa sản phẩm
        $this->viewApp->requestView('product.edit', $data);
    }
    public function update() {
        $data = $_POST;
        $files = $_FILES;
        $productId = $data['product_id'];
        $targetDir = "uploads/products/";
    
        // Lấy thông tin sản phẩm hiện tại
        $currentProduct = $this->productModel->findIdTable($productId);
    
        // Kiểm tra xem có ảnh mới không
        if (isset($files['image']['tmp_name']) && $files['image']['error'] === UPLOAD_ERR_OK) {
            $productImage = $targetDir . basename($files['image']['name']);
            if (move_uploaded_file($files['image']['tmp_name'], $productImage)) {
                $productData = [
                    'product_name' => $data['product_name'],
                    'category_id' => $data['category_id'],
                    'description' => $data['description'],
                    'image' => $productImage
                ];
            } else {
                echo "Failed to upload product image.";
                return;
            }
        } else {
            // Nếu không có ảnh mới, giữ nguyên ảnh cũ
            $productData = [
                'product_name' => $data['product_name'],
                'category_id' => $data['category_id'],
                'description' => $data['description'],
                'image' => $currentProduct['image']
            ];
        }
    
        // Cập nhật thông tin sản phẩm
        $this->productModel->updateIdTable($productData, $productId);
    
        // Lấy danh sách các biến thể hiện tại
        $existingVariants = $this->productVariantModel->getDataProductVariantByProductId($productId);
    
        // Xoá các biến thể không còn tồn tại nữa
        $existingVariantIds = array_column($existingVariants, 'id');
        $currentVariantIds = array_column($data['variant'], 'variant_id');
    
        foreach ($existingVariants as $existingVariant) {
            if (!in_array($existingVariant['id'], $currentVariantIds) && !$this->orderModel->hasVariant($existingVariant['id'])) {
                // Xóa ảnh liên quan đến biến thể
                $this->productVariantImageModel->removeIdTable($existingVariant['id']);
                // Xóa biến thể
                $this->productVariantModel->removeIdTable($existingVariant['id']);
            }
        }
    
        // Cập nhật và thêm mới biến thể sản phẩm
        foreach ($data['variant'] as $index => $variant) {
            $variantId = $variant['variant_id'] ?? null;
            $variantData = [
                'color_id' => $variant['color'],
                'size_id' => $variant['size'],
                'stock' => $variant['stock'],
                'price' => $variant['price']
            ];
    
            if ($variantId) {
                // Cập nhật biến thể hiện tại
                $this->productVariantModel->updateIdTable($variantData, $variantId);
            } else {
                // Thêm mới biến thể
                $variantData['product_id'] = $productId;
                $variantId = $this->productVariantModel->insertTable($variantData);
            }
    
            // Xử lý ảnh cho biến thể
            if (isset($files['variant']['tmp_name'][$index]['images'])) {
                foreach ($files['variant']['tmp_name'][$index]['images'] as $key => $tmpName) {
                    if ($files['variant']['error'][$index]['images'][$key] === UPLOAD_ERR_OK) {
                        $imageName = $files['variant']['name'][$index]['images'][$key];
                        $targetFile = $targetDir . basename($imageName);
    
                        if (move_uploaded_file($tmpName, $targetFile)) {
                            $isPrimary = ($key === 0) ? 1 : 0;
                            $imageData = [
                                'product_variant_id' => $variantId,
                                'image_url' => $targetFile,
                                'is_primary' => $isPrimary
                            ];
                            $this->productVariantImageModel->insertTable($imageData);
                        } else {
                            echo "Failed to move uploaded file: " . $imageName;
                            return;
                        }
                    } else {
                        echo "File upload error: " . $files['variant']['error'][$index]['images'][$key];
                        return;
                    }
                }
            }
        }
    
        // Redirect sau khi cập nhật thành công
        $this->route->redirectAdmin('list-product');
        echo "Product updated successfully!";
    }
    
    // public function update() {
    //     $data = $_POST;
    //     $files = $_FILES;
    //     $productId = $data['product_id'];
    //     $targetDir = "uploads/products/";
    
    //     // Lấy thông tin sản phẩm hiện tại
    //     $currentProduct = $this->productModel->findIdTable($productId);
    
    //     // Kiểm tra xem có ảnh mới không
    //     if (isset($files['image']['tmp_name']) && $files['image']['error'] === UPLOAD_ERR_OK) {
    //         $productImage = $targetDir . basename($files['image']['name']);
    //         if (move_uploaded_file($files['image']['tmp_name'], $productImage)) {
    //             $productData = [
    //                 'product_name' => $data['product_name'],
    //                 'category_id' => $data['category_id'],
    //                 'description' => $data['description'],
    //                 'image' => $productImage
    //             ];
    //         } else {
    //             echo "Failed to upload product image.";
    //             return;
    //         }
    //     } else {
    //         // Nếu không có ảnh mới, giữ nguyên ảnh cũ
    //         $productData = [
    //             'product_name' => $data['product_name'],
    //             'category_id' => $data['category_id'],
    //             'description' => $data['description'],
    //             'image' => $currentProduct['image']
    //         ];
    //     }
    
    //     // Cập nhật thông tin sản phẩm
    //     $this->productModel->updateIdTable($productData, $productId);
    
    //     // Lấy danh sách các biến thể hiện tại
    //     $existingVariants = $this->productVariantModel->getDataProductVariantByProductId($productId);
    
    //     // Xoá các biến thể không còn tồn tại nữa
    //     $existingVariantIds = array_column($existingVariants, 'id');
    //     $currentVariantIds = array_column($data['variant'], 'variant_id');
    
    //     foreach ($existingVariants as $existingVariant) {
    //         if (!in_array($existingVariant['id'], $currentVariantIds) && !$this->orderModel->hasVariant($existingVariant['id'])) {
    //             $this->productVariantModel->removeIdTable($existingVariant['id']);
    //             $this->productVariantImageModel->removeIdTable($existingVariant['id']);
    //         }
    //     }
    
    //     // Cập nhật và thêm mới biến thể sản phẩm
    //     foreach ($data['variant'] as $index => $variant) {
    //         $variantId = $variant['variant_id'] ?? null;
    //         $variantData = [
    //             'color_id' => $variant['color'],
    //             'size_id' => $variant['size'],
    //             'stock' => $variant['stock'],
    //             'price' => $variant['price']
    //         ];
    
    //         if ($variantId) {
    //             // Cập nhật biến thể hiện tại
    //             $this->productVariantModel->updateIdTable($variantData, $variantId);
    //         } else {
    //             // Thêm mới biến thể
    //             $variantData['product_id'] = $productId;
    //             $variantId = $this->productVariantModel->insertTable($variantData);
    //         }
    
    //         // Xử lý ảnh cho biến thể
    //         if (isset($files['variant']['tmp_name'][$index]['images'])) {
    //             foreach ($files['variant']['tmp_name'][$index]['images'] as $key => $tmpName) {
    //                 if ($files['variant']['error'][$index]['images'][$key] === UPLOAD_ERR_OK) {
    //                     $imageName = $files['variant']['name'][$index]['images'][$key];
    //                     $targetFile = $targetDir . basename($imageName);
    
    //                     if (move_uploaded_file($tmpName, $targetFile)) {
    //                         $isPrimary = ($key === 0) ? 1 : 0;
    //                         $imageData = [
    //                             'product_variant_id' => $variantId,
    //                             'image_url' => $targetFile,
    //                             'is_primary' => $isPrimary
    //                         ];
    //                         $this->productVariantImageModel->insertTable($imageData);
    //                     } else {
    //                         echo "Failed to move uploaded file: " . $imageName;
    //                         return;
    //                     }
    //                 } else {
    //                     echo "File upload error: " . $files['variant']['error'][$index]['images'][$key];
    //                     return;
    //                 }
    //             }
    //         }
    //     }
    
    //     // Redirect sau khi cập nhật thành công
    //     $this->route->redirectAdmin('list-product');
    //     echo "Product updated successfully!";
    // }
    
    // public function update() {
    //     $data = $_POST;
    //     $files = $_FILES;
    //     $productId = $data['product_id'];
    //     $targetDir = "uploads/products/";
    
    //     // Lấy thông tin sản phẩm hiện tại
    //     $currentProduct = $this->productModel->findIdTable($productId);
    
    //     // Kiểm tra xem có ảnh mới không
    //     if (isset($files['image']['tmp_name']) && $files['image']['error'] === UPLOAD_ERR_OK) {
    //         $productImage = $targetDir . basename($files['image']['name']);
    //         if (move_uploaded_file($files['image']['tmp_name'], $productImage)) {
    //             $productData = [
    //                 'product_name' => $data['product_name'],
    //                 'category_id' => $data['category_id'],
    //                 'description' => $data['description'],
    //                 'image' => $productImage
    //             ];
    //         } else {
    //             echo "Failed to upload product image.";
    //             return;
    //         }
    //     } else {
    //         // Nếu không có ảnh mới, giữ nguyên ảnh cũ
    //         $productData = [
    //             'product_name' => $data['product_name'],
    //             'category_id' => $data['category_id'],
    //             'description' => $data['description'],
    //             'image' => $currentProduct['image']
    //         ];
    //     }
    
    //     // Cập nhật thông tin sản phẩm
    //     $this->productModel->updateIdTable($productData, $productId);
    
    //     // Xử lý các biến thể
    //     $existingVariants = $this->productVariantModel->getDataProductVariantByProductId($productId);
    
    //     // Xoá các biến thể không còn tồn tại nữa
    //     // $currentVariantIds = array_column($data['variant'], 'variant_id');
    //     // foreach ($existingVariants as $existingVariant) {
    //     //     if (!in_array($existingVariant['id'], $currentVariantIds) && !$this->orderDetailModel->hasVariant($existingVariant['id'])) {
    //     //         $this->productVariantModel->deleteById($existingVariant['id']);
    //     //         $this->productVariantImageModel->deleteByVariantId($existingVariant['id']);
    //     //     }
    //     // }
    
    //     // Cập nhật và thêm mới biến thể sản phẩm
    //     foreach ($data['variant'] as $variant) {
    //         $variantId = $variant['variant_id'] ?? null;
    //         $variantData = [
    //             'color_id' => $variant['color'],
    //             'size_id' => $variant['size'],
    //             'stock' => $variant['stock'],
    //             'price' => $variant['price']
    //         ];
    
    //         if ($variantId) {
    //             // Cập nhật biến thể hiện tại
    //             $this->productVariantModel->updateIdTable($variantData, $variantId);
    //         } else {
    //             // Thêm mới biến thể
    //             $variantData['product_id'] = $productId;
    //             $variantId = $this->productVariantModel->insertTable($variantData);
    //         }
    
    //         // Xử lý ảnh cho biến thể
    //         if (isset($files['variant']['tmp_name'][$variantId]['images'])) {
    //             foreach ($files['variant']['tmp_name'][$variantId]['images'] as $key => $tmpName) {
    //                 if ($files['variant']['error'][$variantId]['images'][$key] === UPLOAD_ERR_OK) {
    //                     $imageName = $files['variant']['name'][$variantId]['images'][$key];
    //                     $targetFile = $targetDir . basename($imageName);
    
    //                     if (move_uploaded_file($tmpName, $targetFile)) {
    //                         $isPrimary = ($key === 0) ? 1 : 0;
    //                         $imageData = [
    //                             'product_variant_id' => $variantId,
    //                             'image_url' => $targetFile,
    //                             'is_primary' => $isPrimary
    //                         ];
    //                         $this->productVariantImageModel->insertTable($imageData);
    //                     } else {
    //                         echo "Failed to move uploaded file: " . $imageName;
    //                         return;
    //                     }
    //                 } else {
    //                     echo "File upload error: " . $files['variant']['error'][$variantId]['images'][$key];
    //                     return;
    //                 }
    //             }
    //         }
    //     }
    
    //     // Redirect sau khi cập nhật thành công
    //     $this->route->redirectAdmin('list-product');
    //     echo "Product updated successfully!";
    // }
    
    // Debug dữ liệu POST và FILES
                // echo "<pre>";
                // print_r($data);
                // print_r($files);
                // echo "<pre>";
                // die();  
                // Dừng thực thi để kiểm tra dữ liệu
    
}
<?php
    class UserController extends BaseController{
        public $userModel;
        public function loadModels(){
            $this->userModel = new User();
        }
        public function list(){
            $users = $this->userModel->allTable();
            $this->viewApp->requestView('Users.list', ['users' => $users]);
        }

        public function ban(){
            $id = $this->route->getId();
            $this->userModel->updateStatusIdTableAndRelated($id, 'users', [], 0);
            $this->route->redirectAdmin('list-user');
        }
        public function unban(){
            $id = $this->route->getId();
            $this->userModel->updateStatusIdTableAndRelated($id, 'users', [], 1);
            $this->route->redirectAdmin('list-user');
        }
        public function create(){
            $this->viewApp->requestView('Users.create');
        }
        public function postCreate(){
            $userCreateForm = (object) $this->route->form;
            $errors = $this->validateUserDataInternal((object)$userCreateForm, false);
            
            // Xử lý ảnh tải lên
            $file = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;
            $result = $this->handleImageUpload($file);

            if (isset($result['errors'])) {
                $errors = array_merge($errors, $result['errors']);
            } else {
                $userCreateForm->avatar = $result; // Cập nhật ảnh mới
            }
            
            if (!empty($errors)) {
                $this->viewApp->requestView('Users.create', ['errors' => $errors, 'user' => $userCreateForm]);
                return;
            }  

            $this->userModel->insertTable($userCreateForm);
            $this->route->redirectAdmin('list-user');            
        }
        public function edit(){            
            $id = $this->route->getId();
            $userUpdate = $this->userModel->findIdTable($id);
            $this->viewApp->requestView('Users.edit',['user' => $userUpdate]);
        }
        
        public function postEdit(){
            $id = $this->route->getId();
            $userEditForm = (object)$this->route->form;
            $errors = $this->validateUserDataInternal((object)$userEditForm, true);

            // Lấy thông tin người dùng hiện tại
            $currentUser = (object)$this->userModel->findIdTable($id);
                
             // Xử lý ảnh tải lên
            $file = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;
            if ($file && $file['error'] === UPLOAD_ERR_OK && !empty($file['name'])) {
                // Có ảnh mới tải lên
                $result = $this->handleImageUpload($file, $currentUser->avatar);

                if (isset($result['errors'])) {
                    $errors = array_merge($errors, $result['errors']);
                } else {
                    $userEditForm->avatar = $result; // Cập nhật ảnh mới
                }
            } else {
                // Không có ảnh mới, giữ ảnh cũ
                $userEditForm->avatar = $currentUser->avatar;
            }

            if (!empty($errors)) {
                $this->viewApp->requestView('Users.edit', ['errors' => $errors, 'user' => $userEditForm]);
                return;
            }     

            $this->userModel->updateIdTable($userEditForm,$id);
            
            $this->route->redirectAdmin('list-user');
        }

        // Xử lý ảnh
        private function handleImageUpload($file, $currentAvatar = null) {
            $errors = [];
        
            // Kiểm tra tệp tải lên
            if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
                // Lấy thông tin tệp
                $fileName = basename($file['name']);
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // Tạo tên file đặc biệt
                $uniqueFileName = uniqid('img_', true) . '.' . $fileType;
                $targetDir = "uploads/user/" . $uniqueFileName;
        
                // Xóa ảnh cũ nếu có
                if ($currentAvatar && file_exists("uploads/user/" . $currentAvatar)) {
                    unlink("uploads/user/" . $currentAvatar);
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
        
        
        public function checkPostGet(){
            // var_dump($this->route->form);
            // var_dump($this->route->method);
            // die();
            echo "<pre>";
            print_r($_POST);
            print_r($this->route->method);
            // print_r($_SERVER);
            echo "</pre>";
            die();
        } 
        // Xác thực dữ liệu cho form tạo mới user
        public function validateUserData() {
            $this->handleValidation(false);
        }

        // Xác thực dữ liệu cho form chỉnh sửa user
        public function validateEditUserData() {
            $this->handleValidation(true);
        }

        // Xử lý chung cho việc xác thực dữ liệu
        private function handleValidation($isEdit) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'));
                $errors = $this->validateUserDataInternal($data, $isEdit);
                header('Content-Type: application/json');
                echo json_encode($errors);
                exit;
            }
        }

        // Logic xác thực chi tiết
        private function validateUserDataInternal($data, $isEdit = false) {
            $errors = [];
            $requiredFields = ['full_name', 'username', 'email', 'address', 'phone'];
            if (!$isEdit) {
                $requiredFields[] = 'password';
            }

            // Kiểm tra các trường bắt buộc
            foreach ($requiredFields as $field) {
                if (empty($data->$field)) {
                    $errors[$field] = ucfirst($field) . " không được để trống!!";
                }
            }

            // Lấy dữ liệu hiện có từ database
            $usernameTable = $this->userModel->getUserName();
            $emailTable = $this->userModel->getEmails();
            $phoneTable = $this->userModel->getPhones();

            // Định nghĩa regex cho mật khẩu, số điện thoại và email
            $regexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
            $regexPhone = "/^\+\d{1,3}\d{6,14}$/";
            $regexEmail = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

            // Kiểm tra tính duy nhất của username, email, phone
            if (!$isEdit) {
                $this->checkUniqueness($data, $errors, $usernameTable, $emailTable, $phoneTable);
            } else {
                $this->checkUniquenessForEdit($data, $errors, $usernameTable, $emailTable, $phoneTable);
            }

            // Kiểm tra định dạng mật khẩu
            if ((!$isEdit || !empty($data->password)) && !preg_match($regexPassword, $data->password)) {
                $errors['password'] = "Mật khẩu phải có tối thiểu 8 ký tự, 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt";
            }

            // Kiểm tra định dạng số điện thoại
            if (!empty($data->phone) && !preg_match($regexPhone, $data->phone)) {
                $errors['phone'] = "Số điện thoại phải có dạng +xxxxxxxxxxxx";
            }

            // Kiểm tra định dạng email
            if (!empty($data->email) && !preg_match($regexEmail, $data->email)) {
                $errors['email'] = "Email không hợp lệ";
            }

            // Kiểm tra độ dài tối thiểu của username
            if (strlen($data->username) < 4) {
                $errors['username'] = "Username phải có ít nhất 4 ký tự";
            }

            return $errors;
        }

        // Kiểm tra tính duy nhất cho form tạo mới
        private function checkUniqueness($data, &$errors, $usernameTable, $emailTable, $phoneTable) {
            if (in_array($data->username, $usernameTable)) {
                $errors['username'] = "Tên đã được sử dụng";
            }
            if (in_array($data->email, $emailTable)) {
                $errors['email'] = "Email đã được sử dụng";
            }
            if (in_array($data->phone, $phoneTable)) {
                $errors['phone'] = "Số điện thoại đã được sử dụng";
            }
        }

        // Kiểm tra tính duy nhất cho form chỉnh sửa
        private function checkUniquenessForEdit($data, &$errors, $usernameTable, $emailTable, $phoneTable) {
            $currentUsername = $this->userModel->getUsernameById($data->id);
            $currentEmail = $this->userModel->getEmailById($data->id);
            $currentPhone = $this->userModel->getPhoneById($data->id);

            if ($data->username !== $currentUsername && in_array($data->username, $usernameTable)) {
                $errors['username'] = "Tên đã được sử dụng";
            }
            if ($data->email !== $currentEmail && in_array($data->email, $emailTable)) {
                $errors['email'] = "Email đã được sử dụng";
            }
            if ($data->phone !== $currentPhone && in_array($data->phone, $phoneTable)) {
                $errors['phone'] = "Số điện thoại đã được sử dụng";
            }
        }

        
    }
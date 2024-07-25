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
            $userCreateForm = $this->route->form;            
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
            $userEditForm = $this->route->form;                      
            $this->userModel->updateIdTable($userEditForm,$id);
            $this->route->redirectAdmin('list-user');
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
        public function validateUserData(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'));
                $errors = $this->validateUserDataInternal($data,false);
                echo json_encode($errors);
                exit;
            }
        }
        public function validateEditUserData(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'));
                $errors = $this->validateUserDataInternal($data,true);
                echo json_encode($errors);
                exit;
            }
        }
        private function validateUserDataInternal($data, $isEdit = false){
            $errors = [];
            $requiredFields = ['full_name', 'username', 'email', 'address', 'phone'];
            if (!$isEdit) {
                $requiredFields[] = 'password';
            }

            foreach ($requiredFields as $field) {
                if (empty($data->$field)) {
                    $errors[$field] = ucfirst($field)." không được để trống!!";
                }
            }

            $usernameTable = $this->userModel->getUserName();
            $emailTable = $this->userModel->getEmails();
            $phoneTable = $this->userModel->getPhones();
            $regexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
            $regexPhone = "/^\+\d{1,3}\d{6,14}$/";

            if (!$isEdit) {
                if (in_array($data->username, $usernameTable)) {
                    $errors['username'] = "Tên đã được sử dụng";
                }
                if (in_array($data->email, $emailTable)) {
                    $errors['email'] = "Email đã được sử dụng";
                }
                if (in_array($data->phone, $phoneTable)) {
                    $errors['phone'] = "Số điện thoại đã được sử dụng";
                }
            } else {
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

            if ((!$isEdit || !empty($data->password)) && !preg_match($regexPassword, $data->password)){
                $errors['password'] = "Mật khẩu phải có tối thiểu 8 ký tự, 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt";
            }

            if (!empty($data->phone) && !preg_match($regexPhone, $data->phone)){
                $errors['phone'] = "Số điện thoại phải có dạng +xxxxxxxxxxxx";
            }

            return $errors;
        }

    }
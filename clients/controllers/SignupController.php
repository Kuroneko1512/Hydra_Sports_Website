<?php 

class SignupController extends BaseController
{
    public function loadModels() {}

    public function signup() {
        $data = [];
        if(isset($_POST['btn_sign_up'])) {
            $userModel = new User();

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
        
            //Validate from đăng ký user
            $errors=[];
            if(empty($_POST['username'])){
                $errors['username'] = "Username required";
            } else {
                $user = $userModel->getUserByUsername($_POST['username']);
                if ($user) {
                    $errors['username'] = "Username existed";
                }
            }

            if(empty($_POST['email'])){
                $errors['email'] = "Email required";
            } else {
                $user = $userModel->getUserByEmail($_POST['email']);
                if ($user) {
                    $errors['email'] = "Email existed";
                }
            }

            if($_POST['password'] != $_POST['confirm_password']){
                $errors['confirm_password'] = "Password does not match";
            }

            // pp($data);
            if(empty($errors)){
                $data = [];
                $data['username'] = $username;
                $data['full_name'] = $username;
                $data['email'] = $email ;
                $data['password'] = md5($password);
                $userModel->insertTable($data);
                $this->route->redirectClient('login');
            }

            $data['errors'] = $errors;
        }

        $this->viewApp->requestGuestView('session.signup', $data);
    }
   
}       
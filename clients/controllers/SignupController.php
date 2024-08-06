<?php 

class SignupController extends BaseController
{
    public function loadModels() {}

    public function signup() {

        if(isset($_POST['btn_sign_up'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
        
            $error=[];
            if(empty($_POST['username'])){
                $error['username'] = "Bạn cần nhập username";
                $data['error'] = $error;
            }
            // pp($data);
            if(empty($error)){
                $userModel = new User();
                $data = [];
                $data['username'] = $username;
                $data['full_name'] = $username;
                $data['email'] = $email ;
                $data['password'] = md5($password);
                $userModel->insertTable($data);
                $this->route->redirectClient('login');
            }
        }

        $this->viewApp->requestGuestView('session.signup');
    }
   
}       
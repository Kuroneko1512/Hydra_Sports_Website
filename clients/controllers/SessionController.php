<?php 

class SessionController extends BaseController
{
    public function loadModels() {}

    public function login() {

        if(isset($_POST['btn_login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            $error=[];
            if(empty($_POST['username'])){
                $error['username'] = "Bạn cần nhập username";
                $data['error'] = $error;
            }
            // pp($data);
            if(empty($error)){
                $userModel = new User();

                $user = $userModel->getUserByUsername($username);
                // pp($user);
                if ($user['password'] == md5($password)) {
                    $_SESSION['user'] = $user;
                    $this->route->redirectClient();
                }
            }
        }

        $this->viewApp->requestGuestView('session.login');
    }

    public function logout() {

        session_destroy();
        $this->viewApp->requestGuestView('session.login');
        
    }
}       
<?php 

class SessionController extends BaseController
{
    public function loadModels() {}

    public function login() {

        if (isset($_POST['btn_login'])) {
            
        }

        $this->viewApp->requestView('session.login');
    }

    public function logout() {

        // clear session
        // redirect to login page
        
    }
}       
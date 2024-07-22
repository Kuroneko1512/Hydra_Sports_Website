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
        public function edit(){            
            $id = $this->route->getId();
            $userUpdate = $this->userModel->findIdTable($id);

            // if(isset($_POST['btn-edit-user'])) {
            //     $userEditForm = $this->route->form;
            //     if (is_object($userEditForm)) {
            //         $userEditForm = (array) $userEditForm;
            //     }
            //     unset($userEditForm['btn-edit-user']);
            //     $this->userModel->updateIdTable($userEditForm,$id);
            //     $this->route->redirectAdmin('list-user');
            // }
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
        public function postCreate(){
            $userCreateForm = $this->route->form;
            $this->userModel->insertTable($userCreateForm);
            $this->route->redirectAdmin('list-user');
        }

        public function create(){
            
            // if(isset($_POST['btn-add-user'])) {
            //     $userCreateForm = $this->route->form;
            //     if (is_object($userCreateForm)) {
            //         $userCreateForm = (array) $userCreateForm;
            //     }
            //     unset($userCreateForm['btn-add-user']);
            //     $this->userModel->insertTable($userCreateForm);
            //     $this->route->redirectAdmin('list-user');
            // }
            $this->viewApp->requestView('Users.create');
        }
        
    }
?>
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
    private function validateCategoryData($data){
        $errors = [];
        if (empty($data['category_name'])) {
            $errors['category_name'] = "Bạn cần nhập tên danh mục";
        }
        return $errors;
    }
    private function create(){
        $this->viewApp->requestView('category.create');
    }
    private function postCreate(){
        $categoryCreateForm = $this->route->form;
        $errors = $this->validateCategoryData($categoryCreateForm);
        if (empty($errors)) {
            $this->categoryModel->insertTable($categoryCreateForm);
            $this->route->redirectAdmin('category');
        } else {
            $data = 
            [
                'errors' => $errors,
                'categoryCreateForm' => $categoryCreateForm
            ];
            $this->viewApp->requestView('category.create', $data );
        }
    }
    private function edit(){
        $id = $this->route->getId();
        $categoryUpdate = $this->categoryModel->findIdTable($id);
        $this->viewApp->requestView('category.edit',['category' => $categoryUpdate]);
    }
    private function postEdit(){
        $id = $this->route->getId();
        $categoryEditForm = $this->route->form;   
        $errors = $this->validateCategoryData($categoryEditForm);
        if (empty($errors)){         
            $this->categoryModel->updateIdTable($categoryEditForm,$id);
            $this->route->redirectAdmin('category');
        } else {
            $categoryUpdate = $this->categoryModel->findIdTable($id);
            $data =
            [   
                'category' => $categoryUpdate,
                'errors' => $errors,
                'categoryEditForm' => $categoryEditForm
            ];
            $this->viewApp->requestView('category.edit', $data );
        }
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
<?php 

class CategoryController extends BaseController
{
    public function loadModels() {}

    public function index() {
        $categoryModel = new Category();//khởi tạo 1 object tên Category
        $categories = $categoryModel->allTable();
        //var_dump($categories);die;
        $data['categories'] = $categories;
        
        $this->viewApp->requestView('category.index', $data);
    }

    public function add() {
        $categoryModel = new Category();
        $data = [];
        if(isset($_POST['btn-add'])) {
            $category_name = $_POST['category_name'];
            $status=$_POST['status'];
            $error=[];
            if(empty($_POST['category_name'])){
                $error['category_name'] = "Bạn cần nhập tên danh mục";
                $data['error'] = $error;
            }

            if(empty($error)){
                $data['category_name'] = $category_name;
                $data['status'] = $status;
                $categoryModel->insertTable($data);//insertTable truyền vào phải là một array trong đó key là tên cột
                $this->route->redirectAdmin('category');// this gọi đến chính bản thân class đó: CategoryController được kế thừa từ BaseController
            }
        }
        $this->viewApp->requestView('category.add', $data);//hiển thị template category view và đổ ra bên ngoài biến $data
    }

    public function category_delete(){
        $categoryModel = new Category();
        $id=$_GET['id'];
        $categoryModel->removeIdTable($id);
        $this->route->redirectAdmin('category');
    }

    public function edit(){
        $categoryModel = new Category();
        $id=$_GET['id'];
        $data = [];
        $categoryById=$categoryModel->findIdTable($id);
        
        if(isset($_POST['btn-edit'])){
            $category_name = $_POST['category_name'];
            $status = $_POST['status'];
            $error=[];
            if(empty($_POST['category_name'])){
                $error['category_name'] = "Bạn cần nhập tên danh mục";
                $data['error'] = $error;
            }
            if(empty($error)){
                $dataUpdate['category_name'] = $category_name;
                $dataUpdate['status'] = $status;
                // var_dump($id);die;
                $categoryModel->updateIdTable($dataUpdate,$id);
                $this->route->redirectAdmin('category');
            }
        }
        $data['categoryById'] = $categoryById;
        $this->viewApp->requestView('category.edit', $data);//template category view
    }
    
}
<?php 

class CategoryController extends BaseController
{
    public function loadModels() {
        // $categoryModel = new Category();
    }

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
            
            $image=$_FILES['image']['tmp_name'];
            $name_file= uniqid() .  $_FILES['image']['name'];
            $vi_tri= ROOT_FOLDER . "/uploads/categories/". $name_file;
            if(move_uploaded_file($image, $vi_tri)){
                echo "Upload thành công";
            }else{
                echo "Upload không thành công";
            }
        
            $error=[];
            if(empty($_POST['category_name'])){
                $error['category_name'] = "Bạn cần nhập tên danh mục";
                $data['error'] = $error;
            }
            // pp($data);
            if(empty($error)){
                $data['category_name'] = $category_name;
                $data['status'] = $status;
                $data['image'] = $name_file;
                $categoryModel->insertTable($data);
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
            $dataUpdate=[];
            if(empty($_POST['category_name'])){
                $error['category_name'] = "Bạn cần nhập tên danh mục";
                $data['error'] = $error;
            }

            $dataUpdate['image'] = $categoryById['image'];
        
            if (!empty($_FILES['image']['name'])) {
                $image=$_FILES['image']['tmp_name'];
                $name_file= uniqid() .  $_FILES['image']['name'];
                $vi_tri= ROOT_FOLDER . "/uploads/categories/". $name_file;
                if(move_uploaded_file($image, $vi_tri)){
                    echo "Upload thành công";
                }else{
                    echo "Upload không thành công";
                }

                $dataUpdate['image'] = $name_file;
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
    

    public function ban(){
        $categoryModel = new Category();

        $id = $this->route->getId();
        // $categoryModel->updateStatusIdTableAndRelated($id, 'category', ['product' => 'category_id'], 0);
        $categoryModel->updateStatusIdTableAndRelated($id,'category',['product' => 'category_id'],0);
        $this->route->redirectAdmin('category');
    }
}
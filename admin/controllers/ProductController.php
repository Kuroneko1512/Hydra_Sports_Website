<?php 

class ProductController extends BaseController

{

    public function loadModels() {
        // $this->product=new Product();
    }

    public function index() {
        $categoryModel = new Category();
        $data['categories'] = $categoryModel->allTable();

        $productModel= new Product();
        $products= $productModel->allTable();
        $data['products']=$products;
        $this->viewApp->requestView('product.index', $data);
    }
    public function add() {
        $categoryModel = new Category();
        $colorModel = new Color();
        $sizeModel = new Size();
        $data = [];
        $data['categories'] = $categoryModel->allTable();
        $data['colors'] = $colorModel->allTable();
        $data['sizes'] = $sizeModel->allTable();

        $productModel= new Product();
        $productVariantModel= new ProductVariant();

        if(isset($_POST['btn_add'])) {
            //var_dump($_POST);die;
            $product_name = $_POST['product_name'];
            $category_id = $_POST['category_id'];
            $description=$_POST['description'];
            $error=[];
            if(empty($_POST['product_name'])){
                $error['product_name'] = "Bạn cần nhập tên sản phẩm";
                $data['error'] = $error;
            }
            if(empty($_POST['description'])){
                $error['description'] = "Bạn cần nhập mô tả sản phẩm";
                $data['error'] = $error;
            }

            if(empty($error)){
                $dataProduct = [];  // khởi tạo 1 array trống mới
                $dataProduct['product_name'] = $product_name;
                $dataProduct['category_id'] = $category_id;
                $dataProduct['description'] = $description;
                $resultID = $productModel->insertTable($dataProduct);//insertTable truyền vào phải là một array trong đó key là tên cột

                $variants = $_POST['variant']; //?
                foreach ($variants as $variant) {
                    if (empty($variant['color']) || empty($variant['size']) || empty($variant['stock']) || empty($variant['price'])) {
                        continue;
                    }

                    $dataVariant = [];  // khởi tạo 1 array trống mới
                    $dataVariant['product_id'] = $resultID;
                    $dataVariant['color_id'] = $variant['color'];
                    $dataVariant['size_id'] = $variant['size'];
                    $dataVariant['stock'] = $variant['stock'];
                    $dataVariant['price'] = $variant['price'];
                    $productVariantModel->insertTable($dataVariant);
                }

                $this->route->redirectAdmin('product');// this gọi đến chính bản thân class đó: CategoryController được kế thừa từ BaseController
            }
        }

        $this->viewApp->requestView('product.add', $data);
    }

    public function edit() {
        $categoryModel = new Category();
        $colorModel = new Color();
        $sizeModel = new Size();
        $id=$_GET['id'];
        $data = [];
        
        $data['categories'] = $categoryModel->allTable();
        $data['colors'] = $colorModel->allTable();
        $colorById=$colorModel->findIdTable($id);
        $data['sizes'] = $sizeModel->allTable();
        $sizeById=$sizeModel->findIdTable($id);

        $productModel= new Product();
        $productById=$productModel->findIdTable($id);
        $productVariantModel= new ProductVariant();
        $productVariantById=$productVariantModel->all_VR_Table($id);
        // var_dump($productVariantById);
        // // die();


        if(isset($_POST['btn_edit'])) {
            // var_dump($_POST);die;
            $product_name = $_POST['product_name'];
            $category_id = $_POST['category_id'];
            $description=$_POST['description'];
            $error=[];
            if(empty($_POST['product_name'])){
                $error['product_name'] = "Bạn cần nhập tên sản phẩm";
                $data['error'] = $error;
            }
            if(empty($_POST['description'])){
                $error['description'] = "Bạn cần nhập mô tả sản phẩm";
                $data['error'] = $error;
            }

            if(empty($error)){
                $dataProduct = [];  // khởi tạo 1 array trống mới
                $dataProduct['product_name'] = $product_name;
                $dataProduct['category_id'] = $category_id;
                $dataProduct['description'] = $description;
                $resultID = $productModel->updateIdTable($dataProduct,$id);//insertTable truyền vào phải là một array trong đó key là tên cột

                $variants = $_POST['variant']; 
                //?
                // print_r( $variants);
             
                foreach ($variants as $variant) {
                    // if (empty($variant['color']) || empty($variant['size']) || empty($variant['stock']) || empty($variant['price'])) {
                    //     continue;
                    // }
                    // var_dump($variant);
                    $dataVariants = array(
                        'product_id' => $id,
                        'color_id' => $variant["color"],
                        'size_id' => $variant["size"],
                        'stock' => $variant["stock"],
                        'price' => $variant["price"],

                    );  // khởi tạo 1 array trống mới
                    $dataVariant['product_id'] = $resultID;
                    $vr_id= $variant["id"];
                //   var_dump($dataVariants);
                //   die();
                    // $dataVariant['color_id'] = $variant['color'];
                    // $dataVariant['size_id'] = $variant['size'];
                    // $dataVariant['stock'] = $variant['stock'];
                    // $dataVariant['price'] = $variant['price'];
                   $a = $productVariantModel->updateIdTable($dataVariants,$vr_id);
                 
                }

                $this->route->redirectAdmin('product');// this gọi đến chính bản thân class đó: CategoryController được kế thừa từ BaseController
            }
        }
        $data['productById'] = $productById;
        $data['colorById'] = $colorById;
        $data['sizeById'] = $sizeById;
        $data['productVariantById']=$productVariantById;
        $this->viewApp->requestView('product.edit', $data);
    }
}
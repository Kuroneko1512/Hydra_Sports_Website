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
        $productImageModel= new ProductImage();

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
                $dataProduct = [];  
                $dataProduct['product_name'] = $product_name;
                $dataProduct['category_id'] = $category_id;
                $dataProduct['description'] = $description;
                $resultID = $productModel->insertTable($dataProduct);

                $variants = $_POST['variant']; 
                //  pp($_POST);
                foreach ($variants as $key=>$variant) {
                    if (empty($variant['color']) || empty($variant['size']) || empty($variant['stock']) || empty($variant['price'])) {
                        continue;
                    }

                    $dataVariant = [];  
                    $dataVariant['product_id'] = $resultID;
                    $dataVariant['color_id'] = $variant['color'];
                    $dataVariant['size_id'] = $variant['size'];
                    $dataVariant['stock'] = $variant['stock'];
                    $dataVariant['price'] = $variant['price'];

                    $variantID= $productVariantModel->insertTable($dataVariant);

                    $image=$_FILES['image' . $key]['tmp_name'];
                    $name_file=$_FILES['image' . $key]['name'];
                    $vi_tri= ROOT_FOLDER . "/uploads/products/". uniqid() . $name_file;
                    if(move_uploaded_file($image, $vi_tri)){
                        echo "Upload thành công";
                    }else{
                        echo "Upload không thành công";
                    }
                    $dataImage=[];
                    $dataImage['product_variant_id'] = $variantID;
                    $dataImage['image_url'] = $name_file;
                    $dataImage['is_primary']= 1;
                    // pp($dataImage);

                    $productImageModel->insertTable($dataImage);
                }

                $this->route->redirectAdmin('product');
            }
        }

        $this->viewApp->requestView('product.add', $data);
    }

    public function edit() {
        $categoryModel = new Category();
        $colorModel = new Color();
        $sizeModel = new Size();
        $id=$_GET['id'];
        // $id = $this->route->getId();
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
        $productImageModel = new ProductImage();
        $productImage = $productImageModel->all_Image_Table($id);

        foreach($productVariantById as $key => $value){
            foreach($productImage as $valueI){
                if($valueI['product_variant_id'] == $value['id']){
                    $productVariantById[$key]['image'] = $valueI['image_url'];
                }
            }
        }

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
                $productModel->updateIdTable($dataProduct,$id);

                $variants = $_POST['variant']; 
                //?
                // print_r( $variants);
             
                foreach ($variants as $variant) {
                    if (empty($variant['color']) || empty($variant['size']) || empty($variant['stock']) || empty($variant['price'])) {
                        continue;
                    }

                    $dataVariant['color_id'] = $variant['color'];
                    $dataVariant['size_id'] = $variant['size'];
                    $dataVariant['stock'] = $variant['stock'];
                    $dataVariant['price'] = $variant['price'];
                    $dataVariant['product_id'] = $id;

                    $variantID= $variant["id"]; //?
                    // pp($variants);

               
                    $productVariantModel->updateIdTable($dataVariant,$variantID);

                    if (!empty($_FILES['image' . $key]['name'])) {
                        $image=$_FILES['image' . $key]['tmp_name'];
                        $name_file=$_FILES['image' . $key]['name'];
                        $vi_tri= ROOT_FOLDER . "/uploads/products/".$name_file;

                        if(move_uploaded_file($image, $vi_tri)){
                            echo "Upload thành công";
                        }else{
                            echo "Upload không thành công";
                        }

                        $productImageModel->deleteByProductVariantID($variantID);

                        $dataImage = []; 
                        $dataImage['product_variant_id'] = $variantID;
                        $dataImage['image_url'] = $name_file;
                        $dataImage['is_primary'] = 1;
                        $productImageModel->insertTable($dataImage);
                    }
                }

                $this->route->redirectAdmin('product');
            }
        }
        $data['productById'] = $productById;
        $data['colorById'] = $colorById;
        $data['sizeById'] = $sizeById;
        $data['productVariantById']=$productVariantById;
        $this->viewApp->requestView('product.edit', $data);
    }
}
<?php 

class HomeController extends BaseController
{
    public $homeModel;
    public function loadModels() {
        $this->homeModel = new Home();
        
    }

    public function index() {
        $this->viewApp->requestView('index');
    }

    public function login() {
        $this->viewApp->requestView('login');
    }

    public function cart(){
        $this->viewApp->requestView('cart.cart');
    }

    public function checkout(){
        $this->viewApp->requestView('cart.checkout');
    }

    public function detailProduct(){
        $product_id =(int) $this->route->getId();

        // var_dump($product_id);
        // die();
        // $product_id = $_GET['id'];
        $color = $this->homeModel->allColor();
        $size = $this->homeModel->allSize();
        $variant = $this->homeModel->allVariant($product_id);
        $review = $this->homeModel->allReview($product_id);
        // if (is_array($variant)) {
        //     $product_variant_id = $variant['id'];
        // }
        // $product_variant_id = $variant['id'];    
        // $image = $this->homeModel->allImageVariant($product_variant_id);
        // $category = $this->homeModel->findIdCategory($product_id);

        $dataArray = [
            'product_id' => $product_id,
            'color' => $color,
            'size' => $size,
            'variant' => $variant,
            'review' => $review,
            // 'product_variant_id' => $product_variant_id,
            // 'image' => $image,
            // 'category' => $category
        ];
        echo "<pre>";
        var_dump($dataArray);
        die();
        // $this->viewApp->requestView('product.detail', $dataArray);
        
    }

    public function addToCart(){
        $product_id = $this->route->getId();

    }

}
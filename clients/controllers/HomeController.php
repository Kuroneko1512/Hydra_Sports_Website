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
        $product_id = $this->route->getId();
        $color = $this->homeModel->allColor();
        $size = $this->homeModel->allSize();
        $variant = $this->homeModel->allVariant($product_id);
        $review = $this->homeModel->allReview($product_id);
        $product_variant_id = $variant['id'];
        $image = $this->homeModel->allImageVariant($product_variant_id);
        $category = $this->homeModel->findIdCategory($product_id);
        $dataArray = [
            'color' => $color,
            'size' => $size,
            'variant' => $variant,
            'review' => $review,
            'image' => $image,
            'category' => $category
        ];

        $this->viewApp->requestView('detail.detail', $dataArray);
    }

    public function addToCart(){
        $product_id = $this->route->getId();
        
    }

}
<?php 
    class CartController extends BaseController
    {
        public function loadModels() {}
        public function cart() {
            $this->viewApp->requestView('cart.cart');
        }

        
    }
?>
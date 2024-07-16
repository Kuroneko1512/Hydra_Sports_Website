<?php 

class ShoppingCartController extends BaseController
{
    public function loadModels() {}

    public function cart() {
        $this->viewApp->requestView('shoppingcart.cart');
    }
}
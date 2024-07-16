<?php 

class CheckoutController extends BaseController
{
    public function loadModels() {}

    public function checkout() {
        $this->viewApp->requestView('checkout.checkout');
    }
}
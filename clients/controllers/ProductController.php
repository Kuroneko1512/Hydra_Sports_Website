<?php 

class ProductController extends BaseController
{
    public function loadModels() {}

    public function detail() {
        $this->viewApp->requestView('product.detail');
    }
}
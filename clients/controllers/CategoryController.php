<?php 

class CategoryController extends BaseController
{
    public function loadModels() {}

    public function shop() {
        $this->viewApp->requestView('category.shop');
    }
}
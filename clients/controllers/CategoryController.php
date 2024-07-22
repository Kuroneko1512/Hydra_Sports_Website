<?php 

class CategoryController extends BaseController
{
    public function loadModels() {}

    public function category() {
        $this->viewApp->requestView('category.category');
    }
}
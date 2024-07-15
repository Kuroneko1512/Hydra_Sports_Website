<?php 

class CategoryController extends BaseController
{
    public function loadModels() {}

    public function index() {


        $this->viewApp->requestView('category.index');
    }
}
<?php 

class ProductController extends BaseController
{
    public function loadModels() {}

    public function index() {
        $categoryModel = new Category();
        $categories = $categoryModel->allTable();

        $productModel= new Product();
        $products= $productModel->allTable();
        $data['products']=$products;
        $this->viewApp->requestView('product.index', $data);
    }
    public function add() {

        $this->viewApp->requestView('product.add');
    }
}
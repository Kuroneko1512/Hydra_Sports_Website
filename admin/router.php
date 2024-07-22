<?php
// index phục vụ request của admin

// kiểm tra act và điều hướng tới các controller phù hợp
match ($route->getAct()) {
    '/' => (new DashboardController())->dashboard(),
    'login' => (new SessionController())->login(),
    'category' => (new CategoryController())->index(),
    'category_add' => (new CategoryController())->add(),
    // 'category_delete' => (new CategoryController())->category_delete(),
    'category_edit' => (new CategoryController())->edit(),
    

    
    'product' =>(new ProductController())->index(),
    'product_add' =>(new ProductController())->add(),
    'product_edit' =>(new ProductController())->edit(),





};
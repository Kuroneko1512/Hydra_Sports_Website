<?php
// index phục vụ request của admin

// kiểm tra act và điều hướng tới các controller phù hợp
match ($route->getAct()) {
    '/' => (new DashboardController())->dashboard(),
    'login' => (new SessionController())->login(),
    'category' => (new CategoryController())->index(),


    // User Table
    'list-user' => (new UserController())->list(),
    'ban-user' => (new UserController())->ban(),
    'unban-user' => (new UserController())->unban(),
    'edit-user' => (new UserController())->edit(),
    'post-edit-user' => (new UserController())->postEdit(),
    'create-user' => (new UserController())->create(),
    'post-create-user' => (new UserController())->postCreate(),

    // Review
    'list-review' => (new ReviewController())->list(),

    // Order
    'list-order' => (new OrderController())->list(),

    'category_add' => (new CategoryController())->add(),
    // 'category_delete' => (new CategoryController())->category_delete(),
    'category_edit' => (new CategoryController())->edit(),
    

    
    'product' =>(new ProductController())->index(),
    'product_add' =>(new ProductController())->add(),
    'product_edit' =>(new ProductController())->edit(),






};
<?php
// index phục vụ request của admin

// kiểm tra act và điều hướng tới các controller phù hợp
match ($route->getAct()) {
    '/' => (new DashboardController())->dashboard(),
    'login' => (new SessionController())->login(),

    // User Table
    'list-user' => (new UserController())->list(),
    'ban-user' => (new UserController())->ban(),
    'unban-user' => (new UserController())->unban(),
    'edit-user' => (new UserController())->edit(),
    'post-edit-user' => (new UserController())->postEdit(),
    'create-user' => (new UserController())->create(),
    'post-create-user' => (new UserController())->postCreate(),
    'validate-user-data' => (new UserController())->validateUserData(),
    'validate-edit-user-data' => (new UserController())->validateEditUserData(),

    // Category
    'list-category' => (new CategoryController())->list(),
    'active-category' => (new CategoryController())->active(),
    'inactive-category' => (new CategoryController())->inactive(),
    'create-category' => (new CategoryController())->create(),
    'post-create-category' => (new CategoryController())->postCreate(),
    'edit-category' => (new CategoryController())->edit(),
    'post-edit-category' => (new CategoryController())->postEdit(),
    'validate-category-data' => (new CategoryController())->validateCategoryData(),
    'validate-edit-category-data' => (new CategoryController())->validateEditCategoryData(),

    // Review
    'list-review' => (new ReviewController())->list(),

    // Order
    'list-order' => (new OrderController())->list(),

    

    
    'product' =>(new ProductController())->index(),
    'product_add' =>(new ProductController())->add(),
    'product_edit' =>(new ProductController())->edit(),






};
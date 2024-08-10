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

    // Product
    'list-product' => (new ProductController())->list(),
    'get-product-variant' => (new ProductController())->getProductVariant(),
    'create-product' => (new ProductController())->create(),
    'post-create-product' => (new ProductController())->store(),
    'edit-product'=> (new ProductController())->edit(),
    'post-edit-product' => (new ProductController()) -> update(),
    // Product Variant

    //Variant
    'color' => (new ProductController()) -> color(),
    'add-color' => (new ProductController()) -> addColor(),
    'edit-color' => (new ProductController()) -> editColor(),
    'validate-color-data' => (new ProductController()) -> validateColorData(),

    'size' => (new ProductController()) -> size(),
    'add-size' => (new ProductController()) -> addSize(),
    'edit-size' => (new ProductController()) -> editSize(),
    'validate-size-data' => (new ProductController()) -> validateSizeData(),
    // Review
    // 'list-review' => (new ReviewController())->list(),
    'review_list' => (new ReviewController())->index(),
    'review_add' => (new ReviewController())->add(),

    // Order
    'list-order' => (new OrderController())->list(),
    'edit-order' => (new OrderController())->edit(),
    
    






};
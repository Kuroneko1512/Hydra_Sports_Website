<?php
// index phục vụ request của admin

// kiểm tra act và điều hướng tới các controller phù hợp
match ($route->getAct()) {
    '/' => (new DashboardController())->dashboard(),
    'login' => (new SessionController())->login(),
    'category' => (new CategoryController())->index(),
<<<<<<< HEAD

    // User Table
    'list-user' => (new UserController())->list(),
    'ban-user' => (new UserController())->ban(),
    'unban-user' => (new UserController())->unban(),
    'edit-user' => (new UserController())->edit(),
    'create-user' => (new UserController())->create(),
=======
    'category_add' => (new CategoryController())->add(),
    'category_delete' => (new CategoryController())->category_delete(),
    'category_edit' => (new CategoryController())->edit(),
    

    
    'product' =>(new ProductController())->index(),
    'product_add' =>(new ProductController())->add(),



>>>>>>> 915cba5301e05e15d7a90beee67cd94dbcb10bdb

};
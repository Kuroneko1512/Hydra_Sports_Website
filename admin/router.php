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
    'create-user' => (new UserController())->create(),

};
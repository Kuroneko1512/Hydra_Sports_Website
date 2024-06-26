<?php
// index phục vụ request của người dùng

// nạp core vào
require_once './commons/core.php';

// khởi tạo các thành phần của ứng dụng
$coreApp = new CoreApp();

// khởi tạo global đối tượng view
$viewApp = new BaseView();

$route = new Route();

if ($route->isAdminPage) {
    // khởi tạo các thành phần của admin
    $coreApp->initApp('admin');
} else {
    // khởi tạo các thành phần của clients
    $coreApp->initApp('clients');
}
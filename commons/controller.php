<?php
// Các thành phần mặc định của 1 controller phải có. Tất cả các controller đều phải kế thừa lớp này

// abstract class: class chưa hoàn thiện. sẽ không new được.
abstract class BaseController {
    public $route;
    public $viewApp;
    public function __construct() {
        global $route;
        global $viewApp;
        $this->route = $route;
        $this->viewApp = $viewApp;
        $this->loadModels();
    }

    // abstract function: Khi có 1 class khác kế thừa class này. Thì trong class đấy sẽ phải khai báo phương thức này
    abstract public function loadModels();
}

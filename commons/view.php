<?php
class BaseView {
    public $title = '';
    //
    public $categories = [];
    public $numberInCart = 0;
    public function requestComponents($name, $data = []) {
        global $route;
        global $viewApp;
        
        // 
        $data['categories'] = $this->categories; 
        $data['numberInCart'] = $this->numberInCart;
        extract($data);
        $name = join(DIRECTORY_SEPARATOR, explode(".", $name));
        include(join(DIRECTORY_SEPARATOR, array('.', $route->isAdminPage ? 'admin' : 'clients', 'views', "components", "{$name}.php")));
    }

    
    public function requestView($name, $data = []) {
        global $route;
        global $viewApp;
        $data['title'] = $this->title;

        extract($data);
        $name = join(DIRECTORY_SEPARATOR, explode(".", $name));
        include(join(DIRECTORY_SEPARATOR, array('.', $route->isAdminPage ? 'admin' : 'clients','views', "layout", "header.php")));
        include(join(DIRECTORY_SEPARATOR, array('.', $route->isAdminPage ? 'admin' : 'clients','views', "{$name}.php")));
        include(join(DIRECTORY_SEPARATOR, array('.', $route->isAdminPage ? 'admin' : 'clients','views', "layout", "footer.php")));
    }

    public function requestGuestView($name, $data = []) { // Hàm thực hiện không lấy header và footer => Hiển thị giao diện Login và Sign up
        global $route;
        global $viewApp;
        $data['title'] = $this->title;

        extract($data);
        $name = join(DIRECTORY_SEPARATOR, explode(".", $name));
        include(join(DIRECTORY_SEPARATOR, array('.', $route->isAdminPage ? 'admin' : 'clients','views', "{$name}.php")));
    }
}
?>
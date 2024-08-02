<?php
class BaseView {
    public $title = '';
    public $categories = [];
    public function requestComponents($name, $data = []) {
        global $route;
        global $viewApp;

        $data['categories'] = $this->categories;
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
}
?>
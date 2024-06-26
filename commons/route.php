<?php

class Route {
    public $url;
    public $method;
    public $query;
    public $form;
    public $isAdminPage;

    public function __construct() {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query = (object)$_GET;
        $this->form = (object)$_POST;

        $this->isAdminPage = $this->isAdmin();
    }

    public function hasQuery($name): bool {
        return property_exists($this->query, $name);
    }

    public function hasFormField($name): bool {
        return property_exists($this->form, $name);
    }

    public function redirectAdmin($action = '', $query = []) {
        header("location: " . $this->getLocateAdmin($action, $query));
    }

    public function redirectClient($action = '', $query = []) {
        header("location: " . $this->getLocateClient($action, $query));
    }
    
    public function getLocateAdmin($action = '', $query = []) {
        if ($action === '') return BASE_URL . '?mode=admin';
        $url = BASE_URL . "?mode=admin&act={$action}";

        if (!empty($query)) {
            $queryString = http_build_query($query);
            $url .= '&' . $queryString;
        }

        return $url;
    }
    
    public function getLocateClient($action = '', $query = []) {
        if ($action === '') return BASE_URL;
        $url = BASE_URL . "?act={$action}";

        if (!empty($query)) {
            $queryString = http_build_query($query);
            $url .= '&' . $queryString;
        }

        return $url;
    }

    public function getAct() {
        return $this->hasQuery('act') ? $this->query->act : '/';
    }

    public function getId() {
        return $this->query->id;
    }

    public function isAdmin() {
        return $this->hasQuery('mode') && $this->query->mode === 'admin';
    }
}
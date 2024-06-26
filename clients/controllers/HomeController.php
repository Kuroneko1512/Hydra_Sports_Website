<?php 

class HomeController extends BaseController
{
    public function loadModels() {}

    public function index() {
        $this->viewApp->requestView('index');
    }
}
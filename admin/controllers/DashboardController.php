<?php 

class DashboardController extends BaseController
{
    public function loadModels() {}

    public function dashboard() {
        $this->viewApp->requestView('dashboard');
    }
}
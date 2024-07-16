<?php 

class ContactController extends BaseController
{
    public function loadModels() {}

    public function contact() {
        $this->viewApp->requestView('contact.contact');
    }
}
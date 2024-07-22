<?php
    class OrderController extends BaseController{
        public $orderModel;
        public function loadModels(){
            $this->orderModel = new Order();
        }
        public function list(){
            $orders = $this->orderModel->allTable();
            $this->viewApp->requestView('Order.list', ['orders' => $orders]);
        }
    }
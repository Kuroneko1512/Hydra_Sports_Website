<?php
    class OrderController extends BaseController{
        public $orderModel;
        public function loadModels(){
            $this->orderModel = new Order();
            $this->orderStatusModel = new OrderStatus();
        }
        public function list(){
            $orders = $this->orderModel->allTable();
            $orderStatus = $this->orderStatusModel->allTable();

            foreach ($orders as $k => $v) {

                foreach ($orderStatus as $s) {
                    if ($s['id'] == $v['order_status_id']) {
                        $orders[$k]['order_status'] = $s['status_name'];
                        break;
                    }
                }
            }
            $this->viewApp->requestView('Order.list', ['orders' => $orders]);
        }
    }
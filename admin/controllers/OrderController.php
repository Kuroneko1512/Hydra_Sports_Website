<?php
    class OrderController extends BaseController{
        public $orderModel;
        public function loadModels(){
            $this->orderModel = new Order();
            $this->orderDetailModel = new OrderDetail();
            $this->orderStatusModel = new OrderStatus();
            $this->productVariantModel = new ProductVariant();
            $this->productImageModel = new ProductVariantImage();
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

        public function edit() {
            $id=$_GET['id'];
            $data = [];

            $orderDetails= [];
            $totalPrice = 0;

            $orderDetails = $this->orderDetailModel->all_item($id);
            $orderStatus = $this->orderStatusModel->allTable();

            foreach ($orderDetails as $key => $value) {
                $orderDetails[$key]['product_name'] = $this->productVariantModel->getProductName($value['product_variant_id']);
                $orderDetails[$key]['product_image'] = $this->productImageModel->getImageByVariantID($value['product_variant_id']);

                $totalPrice += (int)$value['price'] * (int)$value['quantity'];
            }
    
            if(isset($_POST['btn_edit'])) {
                $dataOrder = [];  
                $dataOrder['order_status_id'] = $_POST['order_status_id'];
                $this->orderModel->updateIdTable($dataOrder, $id);
            }

            $order = $this->orderModel->findIdTable($id);
            
            
            $data['order'] = $order;
            $data['orderDetails'] = $orderDetails;
            $data['orderStatus'] = $orderStatus;
            $data['totalPrice'] = $totalPrice;
            $this->viewApp->requestView('order.edit', $data);
        }
    }
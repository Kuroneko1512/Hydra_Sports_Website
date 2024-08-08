<?php 
    class CartController extends BaseController
    {
        public function loadModels() {}
        public function cart() {
            $orderModel= new Order();
            $orderDetailModel= new OrderDetail();
            $productVariantModel= new ProductVariant();
            $productImageModel= new ProductImage();

            $orderID = null;
            if (isset($_SESSION['order_id'])) {
                $orderID = $_SESSION['order_id'];

                $order = $orderModel->findIdTable($orderID);
                if (empty($order)) {
                    unset($_SESSION['order_id']);
                    $orderID = null;
                }
            }

            if (isset($_POST['variant_id'])) {
                
                $variant = $productVariantModel->findIdTable($_POST['variant_id']);

                if ($orderID == null) {
                    $dataOrder = [];  
                    // $dataOrder['order_status'] = 0;
                    $dataOrder['payment_status'] = 0;
                    $dataOrder['order_status_id'] = 1;
                    $orderID = $orderModel->insertTable($dataOrder);
                    $_SESSION['order_id'] = $orderID;
                }

                $dataOrderDetail = [];  
                $dataOrderDetail['order_id'] = $orderID;
                $dataOrderDetail['product_variant_id'] = $_POST['variant_id'];
                $dataOrderDetail['quantity'] = $_POST['quantity'];
                $dataOrderDetail['price'] = (int)$variant['price'];
                $orderDetailModel->insertTable($dataOrderDetail);
            }
            $orderDetails= [];
            $totalPrice = 0;
            if(isset($order['id'])){
                $orderDetails = $orderDetailModel->all_item($order['id']);
                foreach ($orderDetails as $key => $value) {
                    $orderDetails[$key]['product_name'] = $productVariantModel->getProductName($value['product_variant_id']);
                    $orderDetails[$key]['product_image'] = $productImageModel->getImageByVariantID($value['product_variant_id']);
    
                    $totalPrice += (int)$value['price'] * (int)$value['quantity'];
                }
    
            }

           
            $data['orderDetails'] = $orderDetails;
            $data['totalPrice'] = $totalPrice;

            $this->viewApp->requestView('cart.cart', $data);
        }

        
    }
?>
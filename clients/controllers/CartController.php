<?php 
    class CartController extends BaseController
    {
        public function loadModels() {}
        public function cart() {

            if (empty($_SESSION['user'])) {
                $this->route->redirectClient('login');
            }

            $orderModel= new Order();
            $orderDetailModel= new OrderDetail();
            $productVariantModel= new ProductVariant();
            $productImageModel= new ProductImage();

            $orderID = null;
            $order = $orderModel->getOrderInCart($_SESSION['user']['id']);

            if (isset($order['id'])) {
                $orderID = $order['id'];
            }
            
            // Xử lý phần Add To Cart
            if (isset($_POST['variant_id'])) {
                $variant = $productVariantModel->findIdTable($_POST['variant_id']);

                if ($orderID == null) {
                    $dataOrder = [];  
                    $dataOrder['payment_status'] = 0;
                    $dataOrder['order_status_id'] = Order::$ORDER_STATUS_IN_CART;
                    if (isset($_SESSION['user'])) {
                        $dataOrder['user_id'] = $_SESSION['user']['id'];
                    }
                    $orderID = $orderModel->insertTable($dataOrder);// Hàm này trả ra ID
                    $_SESSION['order_id'] = $orderID; // order ID đang tồn tại trong database
                }

                $dataOrderDetail = [];  
                $dataOrderDetail['order_id'] = $orderID;
                $dataOrderDetail['product_variant_id'] = $_POST['variant_id'];
                $dataOrderDetail['quantity'] = $_POST['quantity'];
                $dataOrderDetail['price'] = (int)$variant['price'];
                $orderDetailModel->insertTable($dataOrderDetail);

                $this->route->redirectClient('cart');
            }

            $orderDetails= [];
            $totalPrice = 0;
            if(isset($orderID)){
                $orderDetails = $orderDetailModel->all_item($orderID);
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
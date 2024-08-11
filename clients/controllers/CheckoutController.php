<?php 

class CheckoutController extends BaseController
{
    public function loadModels() {}

    public function checkout() {
        // Nếu không có User sẽ không chạy sang được màn hình checkout 
        if (empty($_SESSION['user'])) {
            $this->route->redirectClient('login');
        }

        $orderModel= new Order();
        $orderDetailModel= new OrderDetail();
        $productVariantModel= new ProductVariant();

        $order = $orderModel->getOrderInCart($_SESSION['user']['id']);
        if (empty($order)) {
            $this->route->redirectClient();
        }

        $errors = [];

        if (isset($_POST['email'])) { // validate

            if (empty($_POST['firstName'])) {
                $errors['firstName'] = 'First name required.';
            }

            if (empty($_POST['lastName'])) {
                $errors['lastName'] = 'Last name required.';
            }

            if (empty($_POST['customer_phone'])) {
                $errors['customer_phone'] = 'Mobile No required.';
            } else {
                if (!preg_match( '/^0(\d{9})$/', $_POST['customer_phone'])) {
                    $errors['customer_phone'] = 'Mobile No is invalid.';
                }
            }

            if (empty($_POST['shipping_address'])) {
                $errors['shipping_address'] = 'Address required.';
            }

            if (empty($_POST['firstName'])) {
                $errors['firstName'] = 'First name required.';
            }

            if (count($errors) == 0) {
                $dataOrder = [];  
                $dataOrder['user_id'] = $_SESSION['user']['id'];
                $dataOrder['customer_name'] = $_POST['firstName'] . ' ' . $_POST['lastName'];
                $dataOrder['customer_email'] = $_POST['email'];
                $dataOrder['customer_phone'] = $_POST['customer_phone'];
                $dataOrder['shipping_address'] = $_POST['shipping_address'];
                $dataOrder['payment_status'] = $_POST['payment'];
                $dataOrder['order_date'] = date('Y-m-d H:i:s');
                $dataOrder['order_status_id'] = Order::$ORDER_STATUS_ORDERED;
                $orderID = $orderModel->updateIdTable($dataOrder, $order['id']);

                $_SESSION['order_id'] = $order['id'];
                $this->route->redirectClient('success');
            }
        }

        $orderDetails = $orderDetailModel->all_item($order['id']);

        $totalPrice = 0;

        foreach ($orderDetails as $key => $value) {
            $orderDetails[$key]['product_name'] = $productVariantModel->getProductName($value['product_variant_id']);

            $totalPrice += (int)$value['price'] * (int)$value['quantity'];
        }

        $data['orderDetails'] = $orderDetails;
        $data['totalPrice'] = $totalPrice;
        $data['errors'] = $errors;

        $this->viewApp->requestView('checkout.checkout', $data);
    }

    public function success() { // Thực hiện xóa session khi chuyển trạng thái từ Incart -> Ordered

        $data['order_id'] = $_SESSION['order_id'];
        unset($_SESSION['order_id']);
        $this->viewApp->requestView('checkout.success', $data);
    }
}
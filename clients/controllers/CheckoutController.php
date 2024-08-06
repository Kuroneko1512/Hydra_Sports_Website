<?php 

class CheckoutController extends BaseController
{
    public function loadModels() {}

    public function checkout() {

        $orderModel= new Order();
            $orderDetailModel= new OrderDetail();
            $productVariantModel= new ProductVariant();

            $orderID = null;
            if (isset($_SESSION['order_id'])) {
                $orderID = $_SESSION['order_id'];
            }

            if (isset($_POST['variant_id'])) {
                
                
            }

            $orders = $orderModel->allTable();
            $order = $orders[0];

            $orderDetails = $orderDetailModel->all_item($orderID);

            $totalPrice = 0;

            foreach ($orderDetails as $key => $value) {
                $orderDetails[$key]['product_name'] = $productVariantModel->getProductName($value['product_variant_id']);

                $totalPrice += (int)$value['price'] * (int)$value['quantity'];
            }

            $data['orderDetails'] = $orderDetails;
            $data['totalPrice'] = $totalPrice;

        $this->viewApp->requestView('checkout.checkout', $data);
    }
}
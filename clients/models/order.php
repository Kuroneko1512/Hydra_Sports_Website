<?php 
    class Order extends BaseModel{
        public $tableName = 'order';
        public $id = 'id';
        
        public static $ORDER_STATUS_IN_CART = 1;// cách định nghĩa một thuộc tính static của class order
        public static $ORDER_STATUS_ORDERED = 2;
        public static $ORDER_STATUS_DELIVERY = 3;
        public static $ORDER_STATUS_SUCCESS = 4;
        public static $ORDER_STATUS_CANCEL = 5;

        public function getOrderInCart($userId) { // Lấy ra Id của order Incart theo userID
            try {
                global $coreApp;
                $sql = "SELECT * FROM `{$this->tableName}` WHERE user_id={$userId} AND order_status_id={$this::$ORDER_STATUS_IN_CART}";//cách để lấy biến state
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetch();
            } catch (Exception $e) {
                $coreApp->debug($e);
            }
        }

        public function getNumberInCart($userId) { // lấy ra số lượng item trong Incart theo userID
            try {
                global $coreApp;
                $sql = "SELECT count(order_detail.id) as num_of_item FROM `order` 
                INNER JOIN order_detail ON order_detail.order_id = `order`.id 
                WHERE `order`.user_id={$userId} AND `order`.order_status_id={$this::$ORDER_STATUS_IN_CART}";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();

                return $result['num_of_item'];
            } catch (Exception $e) {
                $coreApp->debug($e);
            }
        }

    }
?>
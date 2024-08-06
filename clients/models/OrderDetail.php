<?php 
    class OrderDetail extends BaseModel{
        public $tableName = 'order_detail';
        public $id = 'id';


        public function all_item($id) {
            try {
                global $coreApp;
                $sql = "SELECT * FROM {$this->tableName} where order_id = $id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (Exception $e) {
                $coreApp->debug($e);
            }
        }

    }
?>
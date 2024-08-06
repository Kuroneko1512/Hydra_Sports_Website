<?php 
    class Order extends BaseModel{
        public $tableName = 'order';

        public function hasVariant($variantId) {
            $query = "SELECT COUNT(*) FROM order_detail WHERE product_variant_id = :variant_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':variant_id', $variantId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }
        
    }
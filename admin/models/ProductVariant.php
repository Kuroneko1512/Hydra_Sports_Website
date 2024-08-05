<?php 

class ProductVariant extends BaseModel
{
    public $tableName = 'product_variant';
    public $id = 'id';
    public function all_VR_Table($id) {
        try {
            global $coreApp;
            $sql = "SELECT * FROM {$this->tableName} where product_id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }

    public function getProductName($variant_id) {
        try {
            global $coreApp;
            $sql = "SELECT p.product_name FROM {$this->tableName} pv
            INNER JOIN product p ON p.id = pv.product_id
            where pv.id = $variant_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            
            return $result['product_name'];
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }
}
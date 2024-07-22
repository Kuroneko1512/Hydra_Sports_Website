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
}
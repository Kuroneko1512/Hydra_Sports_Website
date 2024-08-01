<?php 
class ProductVariantImage extends BaseModel 
{
    public $tableName = 'product_image';
    public function getImageByProductVariantId($id) {
        try {
            global $coreApp;
            $sql = "SELECT * FROM {$this->tableName} where product_variant_id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }
}
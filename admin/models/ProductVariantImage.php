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

    public function all_Image_Table($id) {
        try {
            global $coreApp;
            $sql = "SELECT pi.product_variant_id, pi.image_url FROM {$this->tableName} pi
                    INNER JOIN product_variant pv ON pv.id = pi.product_variant_id
                    where pv.product_id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }

    public function getImageByVariantID($id) {
        try {
            global $coreApp;
            $sql = "SELECT pi.image_url FROM {$this->tableName} pi
                    INNER JOIN product_variant pv ON pv.id = pi.product_variant_id
                    where pi.product_variant_id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            
            return $result['image_url'];
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }
}
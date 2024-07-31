<?php 

class ProductImage extends BaseModel
{
    public $tableName = 'product_image';
    public $id = 'id';

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

    public function deleteByProductVariantID($id) {
        $sql = "DELETE FROM `{$this->tableName}` WHERE (`product_variant_id` = $id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }


}
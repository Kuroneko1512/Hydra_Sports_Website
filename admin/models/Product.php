<?php 

class Product extends BaseModel
{
    public $tableName = 'product';
    public $id = 'id';

    public function getProductNameAndCategoryId(){
        try {
            global $coreApp;
            $sql = "SELECT `product_name`, `category_id`,`id` FROM {$this->tableName}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }
}
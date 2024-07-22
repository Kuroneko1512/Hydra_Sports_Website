<?php
    class Home extends BaseModel {
    public $tableName = 'product';
    public $category = 'category';
    public $id = 'id';    
    public $color = 'color';
    public $size = 'size';
    public $review = 'review';
    public $product_image = 'product_image';
    public $product_variant = 'product_variant';

    public function allVariant($product_id){
        try{
            global $coreApp;
            $sql = "SELECT * FROM `{$this->product_variant}` WHERE `product_id` = $product_id ";
            // var_dump($sql);
            // die();

            $stmt = $this->conn->prepare($sql);
            // $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(Exception $e){
            $coreApp->debug($e);
            return false;
        }
    }

    public function allColor(){
        try {
            global $coreApp;
            $sql = "SELECT * FROM `{$this->color}` ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function allSize(){
        try {
            global $coreApp;
            $sql = "SELECT * FROM `{$this->size}` ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function allReview($product_id){
        try {
            global $coreApp;
            $sql = "SELECT * FROM `{$this->review}` WHERE product_id = :product_id ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;            
        }
    }

    public function allImageVariant($product_variant_id){
        try {
            global $coreApp;
            $sql = "SELECT * FROM `{$this->product_image}` WHERE product_variant_id = :product_variant_id ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_variant_id', $product_variant_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function findIdCategory($product_id){
        try {
            global $coreApp;
            $sql = "SELECT * FROM `{$this->tableName}`
                    INNER JOIN `{$this->category}` 
                    ON {$this->tableName}.category_id = {$this->category}.id 
                    WHERE id = :product_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }
}
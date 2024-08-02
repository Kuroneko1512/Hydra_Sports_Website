<?php 

class Product extends BaseModel
{
    public $tableName = 'product';
    public $id = 'id';

    public function getProducts($cat, $limit, $offset = 0) {
        try {
            global $coreApp;
            // $sql = "SELECT * FROM {$this->tableName} ORDER BY {$this->id} DESC";
            $sql = "SELECT * FROM `{$this->tableName}` ";

            if (!empty($cat)) {
                $sql .= " WHERE category_id= {$cat} ";
            }
            $sql .= " ORDER BY id DESC  LIMIT {$limit} OFFSET {$offset}";

            // $sql = "SELECT * FROM `{$this->tableName}` ORDER BY id  DESC  LIMIT {$limit} OFFSET {$offset}"; 

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }

    public function getProductRecent($limit, $offset = 0) {
        try {
            global $coreApp;
            // $sql = "SELECT * FROM {$this->tableName} ORDER BY {$this->id} DESC";
            $sql = "SELECT * FROM `{$this->tableName}` ORDER BY created_date  ASC  LIMIT {$limit} OFFSET {$offset}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }

}

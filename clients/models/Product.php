<?php 

class Product extends BaseModel
{
    public $tableName = 'product';
    public $id = 'id';
     // Lấy ra tất cả sản phẩm theo category, giới hạn,  offset bỏ đi bao nhiêu phần tử 
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
    
    // Hiển thị số sản phẩm gần đây nhất
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

    // Đếm tổng số sản phẩm
    public function countProducts($cat) { 
        try {
            global $coreApp;
            $sql = "SELECT COUNT(id) AS NumberOfProducts FROM `{$this->tableName}` ";

            if (!empty($cat)) {
                $sql .= " WHERE category_id= {$cat} ";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();

            return $result['NumberOfProducts'];
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }

}

<?php 

class Category extends BaseModel
{
    public $tableName = 'category';
    public $id = 'id';

    public function getCategories($limit, $offset = 0) {
        try {
            global $coreApp;
            // $sql = "SELECT * FROM {$this->tableName} ORDER BY {$this->id} DESC";
            $sql = "SELECT * FROM `{$this->tableName}` ORDER BY id DESC  LIMIT {$limit} OFFSET {$offset}";//offset dùng cho phân trang
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }
}
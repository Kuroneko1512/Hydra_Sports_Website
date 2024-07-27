<?php 

class Category extends BaseModel
{
    public $tableName = 'category';
    
    public function getCategoryName(){
        try {
            global $coreApp;
            $sql = "SELECT `category_name` FROM {$this->tableName}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $result;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }
    public function getCategoryNameById($id){
        try {
            global $coreApp;
            $sql = "SELECT `category_name` FROM {$this->tableName} WHERE `id` = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }
}
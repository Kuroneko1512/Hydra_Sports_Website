<?php 
class Color extends BaseModel
{
    public $tableName = 'color';
    
    public function getColorName(){
        try {
            global $coreApp;
            $sql = "SELECT `color_name` FROM {$this->tableName} ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $result;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function getColorNameById($id) {
        try {
            global $coreApp;
            $sql = "SELECT `color_name` FROM {$this->tableName} WHERE `id` = :id";
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
    public function isColorUsedInProductVariant($colorId)
    {
        try {
            global $coreApp;
            $sql = "SELECT COUNT(*) FROM product_variant WHERE color_id = :color_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':color_id', $colorId, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function isColorUsedInOrder($colorId)
    {
        try {
            global $coreApp;
            $sql = "SELECT COUNT(*) FROM order_detail od
                    JOIN product_variant pv ON od.product_variant_id = pv.id
                    WHERE pv.color_id = :color_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':color_id', $colorId, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }
}
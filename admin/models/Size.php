<?php 
class Size extends BaseModel
{
    public $tableName = 'size';
    public function getSizeName(){
        try {
            global $coreApp;
            $sql = "SELECT `size_name` FROM {$this->tableName} ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $result;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function getSizeNameById($id) {
        try {
            global $coreApp;
            $sql = "SELECT `size_name` FROM {$this->tableName} WHERE `id` = :id";
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
    public function isSizeUsedInProductVariant($sizeId)
    {
        try {
            global $coreApp;
            $sql = "SELECT COUNT(*) FROM product_variant WHERE size_id = :size_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':size_id', $sizeId, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function isSizeUsedInOrder($sizeId)
    {
        try {
            global $coreApp;
            $sql = "SELECT COUNT(*) FROM order_detail od
                    JOIN product_variant pv ON od.product_variant_id = pv.id
                    WHERE pv.color_id = :color_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':color_id', $sizeId, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }
}
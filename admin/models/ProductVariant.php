<?php 

class ProductVariant extends BaseModel
{
    public $tableName = 'product_variant';
    public function getProductVariantByProductId($id) {
        try {
            global $coreApp;
            $sql = "SELECT * FROM {$this->tableName} where product_id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }
    public function getDataProductVariantByProductId($id) {
        try {
            global $coreApp;
            $sql = "SELECT pv.id, pv.product_id, pv.color_id, pv.size_id, pv.price, pv.stock, 
                            c.color_name, s.size_name
                    FROM {$this->tableName} pv
                    JOIN color c ON pv.color_id = c.id
                    JOIN size s ON pv.size_id = s.id
                    WHERE pv.product_id = :product_id";

            // Chuẩn bị câu lệnh SQL
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Trả về dữ liệu dưới dạng mảng liên kết
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Xử lý lỗi
            $coreApp->debug($e);
            return false;
        }
    }
}

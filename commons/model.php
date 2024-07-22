<?php 
// Các thành phần mặc định của 1 model phải có. Tất cả các model đều phải kế thừa lớp này
class BaseModel {
    public $tableName;
    public $id;
    public $conn;

    public function __construct() {
        global $coreApp;
        $this->conn = $coreApp->connectDB();
    }

    public function allTable() {
        try {
            global $coreApp;
            // $sql = "SELECT * FROM {$this->tableName} ORDER BY {$this->id} DESC";
            $sql = "SELECT * FROM `{$this->tableName}` ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }

    public function getAllDataFromTables($tables) {
        try {
            global $coreApp;
            $unionQueries = [];
            foreach ($tables as $table) {
                $unionQueries[] = "SELECT * FROM {$table}";
            }

            $sql = implode(' UNION ', $unionQueries);
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function findIdTable($id) {
        try {
            global $coreApp;
            $sql = "SELECT * FROM `{$this->tableName}` WHERE id = :id"; //:id là tham số - param, id là tên cột
    
            $stmt = $this->conn->prepare($sql);
        
            $stmt->execute([':id' => $id]);

            return $stmt->fetch();
        } catch(Exception $e) {
            $coreApp->debug($e);
        }
    }

    public function removeIdTable($id) {
        try {
            global $coreApp;
            // $sql = "DELETE FROM {$this->tableName} WHERE (`{$this->id}` = :id)";
            $sql = "DELETE FROM `{$this->tableName}` WHERE (`id` = :id)";
    
            $stmt = $this->conn->prepare($sql);
        
            return $stmt->execute([
                ':id' => $id
            ]);
        } catch(Exception $e) {
            $coreApp->debug($e);
        }
    }

    public function softRemoveIdTable($ids) {
        try {
            global $coreApp;
            
            // Kiểm tra xem trường trang_thai có tồn tại không
            $checkColumnSql = "SHOW COLUMNS FROM `{$this->tableName}` LIKE 'status'";
            $stmt = $this->conn->prepare($checkColumnSql);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                throw new Exception("Trường sttus không tồn tại trong bảng {$this->tableName}");
            }

            // Chuyển đổi $ids thành mảng nếu nó không phải là mảng
            if (!is_array($ids)) {
                $ids = [$ids];
            }

            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            /*
                Đoạn code này thực hiện các bước sau:
                array_fill(0, count($ids), '?') tạo ra một mảng mới với số phần tử bằng số lượng ID trong $ids, mỗi phần tử là dấu chấm hỏi '?'.

                implode(',', ...) nối các phần tử của mảng này lại với nhau, sử dụng dấu phẩy làm ký tự phân cách.

                Ví dụ, nếu $ids có 3 phần tử, $placeholders sẽ là "?,?,?".
                Điều này cho phép tạo ra một câu lệnh SQL động, có thể xử lý một số lượng ID bất kỳ:
            */
            $sql = "UPDATE {$this->tableName} SET trang_thai = 0 WHERE id IN ($placeholders)";

            $stmt = $this->conn->prepare($sql);
        
            return $stmt->execute($ids);
        } catch(Exception $e) {
            $coreApp->debug($e);
            return false;
        }
    }

    public function updateStatusIdTableAndRelated($mainId, $mainTable, $relatedTables, $newStatus) {
        try {
            global $coreApp;
            $this->conn->beginTransaction();

            $sql = "CALL update_status_with_related(?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute([
                $mainTable,
                $mainId,
                json_encode($relatedTables),
                $newStatus
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            $coreApp->debug($e);
            return false;
        }
    }

    public function insertTable($data) {
        try {
            //var_dump($data);die;
            global $coreApp;
            $data = $this->convertToArray($data);
            // Lấy các tên cột từ mảng $data
            $columns = array_keys($data);
            // Tạo chuỗi các tên cột
            $columnsString = implode(', ', $columns);
            // Tạo chuỗi các placeholder
            $placeholders = ':' . implode(', :', $columns);
            
            // Tạo câu lệnh SQL
            $sql = "INSERT INTO `$this->tableName` ($columnsString) VALUES ($placeholders)";
            
            $stmt = $this->conn->prepare($sql);
            
            // Chuyển đổi mảng $data thành mảng có dạng ['column' => value]
            $parameters = [];
            foreach ($data as $key => $value) {
                $parameters[":$key"] = $value;
            }

            $stmt->execute($parameters);
            return $this->conn->lastInsertId();// trả ra ID của data variant
        } catch(Exception $e) {
            // var_dump($e);die;
            $coreApp->debug($e);
        }
    }

    public function updateIdTable($data, $id) {
        try {
            // var_dump($id);
            // die();
            global $coreApp;
            $data = $this->convertToArray($data);
            // Lấy các tên cột từ mảng $data
            $columns = array_keys($data);
           

            // Tạo chuỗi các cặp 'column = :column'
            $setString = implode(', ', array_map(function($col) {
                return "$col = :$col";
            }, $columns));
           
            
            // Tạo câu lệnh SQL

            // $sql = "UPDATE $this->tableName SET $setString WHERE {$this->id} = $id";
            // var_dump($sql);
            // die();
           // $sql = "UPDATE $this->tableName SET $setString WHERE {$this->id} = :id";
            $sql = "UPDATE `$this->tableName` SET $setString WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            
            // Chuyển đổi mảng $data thành mảng có dạng ['column' => value]
            $parameters = [];
            foreach ($data as $key => $value) {
                $parameters[":$key"] = $value;
            }
            // Thêm id vào mảng parameters
            $parameters[':id'] = $id;
            

            return $stmt->execute($parameters);
        } catch(Exception $e) {
            $coreApp->debug($e);
        }
    }

    private function convertToArray($data) {
        if (is_object($data)) {
            return get_object_vars($data);
        } elseif (is_array($data)) {
            return $data;
        } else {
            return null;
        }
    }
}
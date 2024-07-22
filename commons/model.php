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
            $sql = "SELECT * FROM {$this->tableName} ORDER BY {$this->id} DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $coreApp->debug($e);
        }
    }

    public function findIdTable($id) {
        try {
            global $coreApp;
            $sql = "SELECT * FROM {$this->tableName} WHERE id = :id"; //:id là tham số - param, id là tên cột
    
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
            $sql = "DELETE FROM {$this->tableName} WHERE (`{$this->id}` = :id)";
    
            $stmt = $this->conn->prepare($sql);
        
            return $stmt->execute([
                ':id' => $id
            ]);
        } catch(Exception $e) {
            $coreApp->debug($e);
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
            $sql = "INSERT INTO $this->tableName ($columnsString) VALUES ($placeholders)";
            
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
            $sql = "UPDATE $this->tableName SET $setString WHERE {$this->id} = $id";
            // var_dump($sql);
            // die();
            
            $stmt = $this->conn->prepare($sql);
            
            // Chuyển đổi mảng $data thành mảng có dạng ['column' => value]
            $parameters = [];
            foreach ($data as $key => $value) {
                $parameters[":$key"] = $value;
            }
            // Thêm id vào mảng parameters
           
            

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
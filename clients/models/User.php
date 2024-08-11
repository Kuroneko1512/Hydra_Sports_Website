<?php
    class User extends BaseModel {
        public $tableName = 'users';

        public function getUserName(){
            try {
                global $coreApp;
                $sql = "SELECT `username` FROM {$this->tableName} ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
                return $result;
            } catch (Exception $e) {
                $coreApp->debug($e);
                return false;
            }
        }

        public function getEmails() {
            try {
                global $coreApp;
                $sql = "SELECT `email` FROM {$this->tableName}";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
                return $result;
            } catch (Exception $e) {
                $coreApp->debug($e);
                return false;
            }
        }

        public function getPhones() {
            try {
                global $coreApp;
                $sql = "SELECT `phone` FROM {$this->tableName}";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
                return $result;
            } catch (Exception $e) {
                $coreApp->debug($e);
                return false;
            }
        }

        public function getUsernameById($id) {
            try {
                global $coreApp;
                $sql = "SELECT `username` FROM {$this->tableName} WHERE `id` = :id";
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

        public function getEmailById($id) {
            try {
                global $coreApp;
                $sql = "SELECT `email` FROM {$this->tableName} WHERE `id` = :id";
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

        public function getPhoneById($id) {
            try {
                global $coreApp;
                $sql = "SELECT `phone` FROM {$this->tableName} WHERE `id` = :id";
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

        public function getUserByUsername($username) {
            try {
                global $coreApp;
                $sql = "SELECT * FROM {$this->tableName} WHERE `username` = '{$username}'";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            } catch (Exception $e) {
                $coreApp->debug($e);
                return false;
            }
        }

        public function getUserByEmail($email) {
            try {
                global $coreApp;
                $sql = "SELECT * FROM {$this->tableName} WHERE `email` = '{$email}'";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            } catch (Exception $e) {
                $coreApp->debug($e);
                return false;
            }
        }

    }
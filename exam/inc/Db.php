<?php
class DB {
    private $conn;
    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db = "exam";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        } catch(PDOException $e) {
        }
    }

    public function create($table, $data){
        try {

            // Build the SQL statement
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindParam(':' . $key, $data[$key], PDO::PARAM_STR);
            }
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
    public function delete($table, $id){
        try {

            $sql = "DELETE FROM $table WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return "succesfuly deleted";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
    public function deleteWhere($table, $id, $column){
        try {
            $sql = "DELETE FROM $table WHERE $column = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return "succesfuly deleted";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
    public function getAll($table){
        try {
            $sql = "SELECT * FROM $table";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return $result;
            } else {
                return "No records found";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function getAllExtend($table, $tableFrom, $column, $searchColumn){
        try {
            $sql = "SELECT * FROM $table";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                foreach ($result as $unit) {
                    $data = $this->find($tableFrom, [$searchColumn => $unit[$column]]);
                    $unit[$tableFrom] = $data["all_data"];
                }
                unset($unit); // Unset the reference to avoid potential issues
                return $result;
            } else {
                return "No records found";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function update($table, $data, $id){
        try {
            $setClause = [];
            foreach ($data as $column => $value) {
                $setClause[] = "$column = :$column";
            }
            $setClause = implode(", ", $setClause);
            $sql = "UPDATE $table SET $setClause WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            foreach ($data as $column => $value) {
                $stmt->bindParam(":" . $column, $data[$column], PDO::PARAM_STR);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
    public function find($table, $conditions) {
        try {
            $sql = "SELECT * FROM $table WHERE ";
            $whereConditions = [];
            foreach ($conditions as $column => $value) {
                $whereConditions[] = "$column = :$column";
            }
            $sql .= implode(" AND ", $whereConditions);
            $stmt = $this->conn->prepare($sql);
            foreach ($conditions as $column => $value) {
                $stmt->bindParam(":$column", $value);
            }
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return [
                    "status" => 200,
                    "all_data"=>$data,
                    "data" => $data[0],
                ];
            } else {
                return [
                    "status" => 300,
                    "data" => [],
                ];
            }
        } catch(PDOException $e) {
           return "Error: " . $e->getMessage();
        }
    }
//    public function findExtend($table, $conditions, $tableFrom, $column, $searchColumn) {
//        try {
//            $sql = "SELECT * FROM $table WHERE ";
//            $whereConditions = [];
//            foreach ($conditions as $column => $value) {
//                $whereConditions[] = "$column = :$column";
//            }
//            $sql .= implode(" AND ", $whereConditions);
//            $stmt = $this->conn->prepare($sql);
//            foreach ($conditions as $column => $value) {
//                $stmt->bindParam(":$column", $value);
//            }
//            $stmt->execute();
//            if ($stmt->rowCount() > 0) {
//                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//                foreach ($result as $unit) {
//                    $data = $this->find($tableFrom, [$searchColumn => $unit[$column]]);
//                    $unit[$tableFrom] = $data["all_data"];
//                }
//                unset($unit); // Unset the reference to avoid potential issues
//                return [
//                    "status" => 200,
//                    "all_data"=>$result,
//                    "data" => $result[0],
//                ];
//            } else {
//                return [
//                    "status" => 300,
//                    "data" => [],
//                ];
//            }
//        } catch(PDOException $e) {
//            return "Error: " . $e->getMessage();
//        }
//    }

}
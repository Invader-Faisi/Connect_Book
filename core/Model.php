<?php

namespace core;

class Model {
    protected $db;

    public function __construct() {
        try {
            $this->db = new \PDO('mysql:host=localhost;dbname=connectbook', 'root', '');
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    // Select all records from any table
    public function selectAll($table) {
        $stmt = $this->db->prepare("SELECT * FROM $table");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectFromMultipleTables($tables, $joinConditions, $joinTypes, $columns = '*', $whereCondition = '') {
        if (count($tables) < 2 || count($tables) - 1 != count($joinConditions) || count($tables) - 1 != count($joinTypes)) {
            return ["success" => "error", "message" => "The number of join conditions and join types must be one less than the number of tables."];
        }

        // Start building the query
        $query = "SELECT $columns FROM " . array_shift($tables);

        // Add join statements with specified join types
        foreach ($tables as $index => $table) {
            $joinType = strtoupper($joinTypes[$index]);
            $allowedJoinTypes = ['JOIN', 'INNER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'FULL JOIN'];
            if (!in_array($joinType, $allowedJoinTypes)) {
                return ["success" => "error", "message" => "Invalid join type: $joinType. Allowed join types are: " . implode(', ', $allowedJoinTypes)];
            }
            $query .= " $joinType $table ON " . $joinConditions[$index];
        }

        // Add where condition if provided
        if ($whereCondition) {
            $query .= " WHERE $whereCondition";
        }

    // Prepare and execute the query
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo json_encode(['success' => 'error', 'message' => $e->getMessage()]);
        }
    }




    // Select records with a WHERE clause
    public function selectWhere($table, $conditions = []) {
        $query = "SELECT * FROM $table WHERE ";
        $clauses = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $clauses[] = "$column = :$column";
            $params[":$column"] = $value;
        }
        $query .= implode(' AND ', $clauses);

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Delete records with a WHERE clause
    public function deleteWhere($table, $conditions) {
        // Ensure conditions is an array
        if (!is_array($conditions)) {
            $conditions = ['id' => $conditions];
        }
        $query = "DELETE FROM $table WHERE ";
        $clauses = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $clauses[] = "$column = :$column";
            $params[":$column"] = $value;
        }
        $query .= implode(' AND ', $clauses);

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }



    public function insertObject($table, $object) {
        // Get object properties
        $objectVars = get_object_vars($object);

        if($table != 'users'){
            $exclude = ['userType'];
            foreach ($exclude as $property) {
                if (array_key_exists($property, $objectVars)) {
                    unset($objectVars[$property]);
                }
            }
        }

        $columns = array_keys($objectVars);
        $values = array_values($objectVars);
        $columnString = implode(', ', $columns);
        $valueString = implode(', ', array_fill(0, count($values), '?'));

        $sql = "INSERT INTO $table ($columnString) VALUES ($valueString)";
        $stmt = $this->db->prepare($sql);

        try {
            $result = $stmt->execute($values);
            if ($result) {
                return $result;
            } else {
                $errorInfo = $stmt->errorInfo();
                return $errorInfo[2];
            }
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                echo json_encode(['success' => false, 'message' => 'Violation: ' . $e->getMessage()]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
            exit;
        }
        return $result;
    }

    public function updateObject($table, $object, $id) {
        $objectVars = get_object_vars($object);

        if ($table != 'users') {
            $exclude = ['userType', 'id'];
        } else {
            $exclude = ['id'];
        }

        foreach ($exclude as $property) {
            if (array_key_exists($property, $objectVars)) {
                unset($objectVars[$property]);
            }
        }

        $columns = array_keys($objectVars);
        $values = array_values($objectVars);
        $setString = implode(', ', array_map(function ($column) {
            return "$column = ?";
        }, $columns));

        $sql = "UPDATE $table SET $setString WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        try {
            $values[] = $id;
            $result = $stmt->execute($values);
            if ($result) {
                return $result;
            } else {
                $errorInfo = $stmt->errorInfo();
                return $errorInfo[2];
            }
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                echo json_encode(['success' => false, 'message' => 'Violation - Email Already exists']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
            exit;
        }
        return $result;
    }



    public function getUserId($table,$email)
    {
        $stmt = $this->db->prepare("SELECT id FROM $table WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn();
    }


    public function selectObjectWithId($table, $id) {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function executeWithQuery($query, $params = []) {
        try {
            $stmt = $this->db->prepare($query);

            $stmt->execute($params);

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            exit;
        } catch (\PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        return null;
    }

}

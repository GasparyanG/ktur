<?php
namespace DataBase\Implementations;

use DataBase\Interfaces\CreaterInterface as CreaterInterface;

class Creater implements CreaterInterface
{
    use Common;

    public function __construct($conn)
    {
        $this->conn = $conn;

        $this->methodNames = [
            "T" => "createTable",
            "R" => "insertRow",
        ];
    }

    public function create($statement, $flag)
    {
        $methodName = $this->getMethodName($this->methodNames, $flag);
        
        if ($methodName) {
            $queryResult = $this->$methodName($statement);
            if ($queryResult){
            }

            return $queryResult;
        }

        // php by default returns 'null' if nothing is returned
    }

    public function createTable($statement)
    {
        $queryResult = $this->conn->exec($statement);

        if (!$queryResult) {
            return false;
        }

        else {
            
            return true;
        }
    }

    public function insertRow($statement)
    {
        $queryResult = $this->conn->exec($statement);

        if (!$queryResult) {
            return false;
        }

        else {
            return $this->getLastInsertId();
        }
    }

    private function getLastInsertId()
    {
        $lastId = $this->conn->lastInsertId();

        return $lastId;
    }
}
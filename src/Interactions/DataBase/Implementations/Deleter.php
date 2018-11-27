<?php
namespace DataBase\Implementations;;

use DataBase\Interfaces\DeleterInterface as DeleterInterface;

class Deleter implements DeleterInterface
{
    use Common;
    public function __construct($conn)
    {
        $this->conn = $conn;

        $this->methodNames = [
            "R" => "deleteRow"
        ];
    }

    public function delete($statement, $flag)
    {
        $methodName = $this->getMethodName($this->methodNames, $flag);

        if ($methodName) {
            $queryResult = $this->$methodName($statement);

            return $queryResult;
        }
    }

    public function deleteRow($statement) 
    {
        $queryResult = $this->conn->exec($statement);

        if ($queryResult) {
            return true;
        }

        return false;
    }
}
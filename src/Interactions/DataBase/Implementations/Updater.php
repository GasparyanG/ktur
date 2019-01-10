<?php
namespace DataBase\Implementations;

use DataBase\Interfaces\UpdaterInterface as UpdaterInterface;

class Updater implements UpdaterInterface
{
    use Common;
    public function __construct($conn)
    {
        $this->conn = $conn;

        $this->methodNames = [
            "R" => "updateRow",
        ];
    }

    public function update($statement, $flag)
    {
        $methodName = $this->getMethodName($this->methodNames, $flag);

        if ($methodName) {
            $queryResult = $this->$methodName($statement);
            
            return $queryResult;
        }
    }

    public function updateRow($statement)
    {
        $queryResult = $this->conn->exec($statement);

        if ($queryResult) {
            return true;
        }

        return false;
    }
}
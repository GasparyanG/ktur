<?php
namespace DataBase\Implementations;

use DataBase\Interfaces\ReaderInterface as ReaderInterface;
use PDO;

class Reader implements ReaderInterface
{
    use Common;

    public function __construct($conn)
    {
        $this->conn = $conn;

        $this->methodNames = [
            "O" => "readOne",
            "A" => "readAll",
        ];
    }

    public function read($statement, $flag)
    {
        $methodName = $this->getMethodName($this->methodNames, $flag);
        if ($methodName) {
            $queryResult = $this->$methodName($statement);

            return $queryResult;
        }
    }

    public function readOne($statement)
    {
        $queryResult = $this->conn->query($statement);

        if ($queryResult) {
            $queryResult->setFetchMode(PDO::FETCH_ASSOC);
            return $queryResult->fetch();
        }

        return false;
    }

    public function readAll($statement)
    {
        $queryResult = $this->conn->query($statement);

        if ($queryResult) {
            $queryResult->setFetchMode(PDO::FETCH_ASSOC);
            return $queryResult->fetchAll();
        }

        return false;
    }
}
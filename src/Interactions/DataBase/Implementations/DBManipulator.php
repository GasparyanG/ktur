<?php
namespace DataBase\Implementations;

use DataBase\Interfaces\DBManipulatorInterface as DBManipulatorInterface;
use DataBase\Config\Connection as Connection;

class DBManipulator implements DBManipulatorInterface
{
    protected $Creater;
    protected $Reader;
    protected $Updater;
    protected $Deleter;

    protected $partOfNamespace; 

    public function __construct() 
    {
        $this->partOfNamespace = "DataBase\Implementations";
        
        $connector = new Connection();
        $this->conn = $connector->getConnection();

        $this->Creater = $this->partOfNamespace . "\Creater";
        $this->Reader = $this->partOfNamespace . "\Reader";
        $this->Updater = $this->partOfNamespace . "\Updater";
        $this->Deleter = $this->partOfNamespace . "\Deleter";
        $this->TableManipulator = $this->partOfNamespace . "\TableManipulator";
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function create($statement, $flag)
    {
        $creater = new $this->Creater($this->conn);

        $queryResult = $creater->create($statement, $flag);

        return $queryResult;
    }

    public function read($statement, $flag)
    {
        $reader = new $this->Reader($this->conn);
        
        $queryResult = $reader->read($statement, $flag);
        return $queryResult;
    }

    public function update($statement, $flag)
    {
        $updater = new $this->Updater($this->conn);

        $queryResult = $updater->update($statement, $flag);
        return $queryResult;
    }

    public function delete($statement, $flag)
    {
        $deleter = new $this->Deleter($this->conn);

        $queryResult = $deleter->delete($statement, $flag);
        return $queryResult;
    }

    public function createTable(string $keyForStatement)
    {
        $tableManipulator = new $this->TableManipulator($this->conn);
        $tableName = $tableManipulator->create($keyForStatement);
        
        return $tableName;
    }
}
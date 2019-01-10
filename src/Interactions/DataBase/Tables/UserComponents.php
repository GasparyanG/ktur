<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;

class UserComponents implements TableInterface
{
    public function __construct()
    {
        $this->tableName = 'user_components';
    }

    public function getTableDef()
    {
        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            username        VARCHAR(70) NOT NULL UNIQUE,
            user_image      VARCHAR(100) NOT NULL
        )";

        return $statement;
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}
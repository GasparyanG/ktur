<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;

class Users implements TableInterface
{
    public function __construct()
    {
        $this->tableName = 'users';
    }

    public function getTableDef()
    {
        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            user_id         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            first_name      VARCHAR(70) NOT NULL,
            last_name       VARCHAR(70) NOT NULL,
            username        VARCHAR(70) NOT NULL UNIQUE,
            password        VARCHAR(255) NOT NULL,
            salt            VARCHAR(255) NOT NULL,
            sign_up_date    DATE NOT NULL
        )";

        return $statement;
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}
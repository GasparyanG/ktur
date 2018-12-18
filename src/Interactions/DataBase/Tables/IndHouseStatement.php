<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;

class IndHouseStatement implements TableInterface
{
    public function __construct()
    {
        $this->tableName = "ind_house_statements";
    }

    public function getTableDef()
    {
        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            ind_house_id        INT AUTO_INCREMENT PRIMARY KEY,
            username            VARCHAR(255) NOT NULL,
            building_area       INT NOT NULL,
            yard_area           INT NOT NULL,
            location            VARCHAR(255) NOT NULL,
            option              VARCHAR(255) NOT NULL,
            description         NOT NULL,
            price               INT NOT NULL,
            amount_of_floors    INT NOT NULL,
            statement_date      DATE NOT NULL,
            title               VARCHAR(255) NOT NULL
        )";
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}
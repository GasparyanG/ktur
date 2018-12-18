<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class IndependentHousePhotos implements TableInterface
{
    public function __consturct()
    {
        $this->configFetcher = new ConfigFetcher();

        $this->tableName = "Independent_house_photos";
    }

    public function getTableDef()
    {
        $indHouseTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);

        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            file_name       VARCHAR(255) NOT NULL,
            statement_id    INT NOT NULL,
            FOREIGN KEY (statement_id)
                REFERENCES $indHouseTableName (statement_id)
                ON DELETE CASCADE
        )";
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}
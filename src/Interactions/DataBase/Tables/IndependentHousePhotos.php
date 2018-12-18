<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class IndependentHousePhotos implements TableInterface
{
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();

        $this->tableName = "independent_house_photos";
    }

    public function getTableDef()
    {
        $indHouseTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);

        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            file_name       VARCHAR(255) NOT NULL,
            ind_house_id    INT NOT NULL,
            FOREIGN KEY (ind_house_id)
                REFERENCES $indHouseTableName (ind_house_id)
                ON DELETE CASCADE
        )";

        return $statement;
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}
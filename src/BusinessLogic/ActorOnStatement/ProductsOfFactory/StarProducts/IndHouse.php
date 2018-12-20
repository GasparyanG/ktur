<?php
namespace BusinessLogic\ActorOnStatement\ProductsOfFactory\StarProducts;

use DataBase\Tables\IndHouseStar as IndHouseStar;

class IndHouse
{
    public function __construct($configFetcher, $dbmanipulator)
    {
        // injected
        $this->configFetcher = $configFetcher;
        $this->dbmanipulator = $dbmanipulator;
        
        // statically inited
        $this->indHouseStar = new IndHouseStar();
    }

    public function isUsed(string $tableName): bool
    {
        $configuredNameOfTable = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
        return $tableName === $configuredNameOfTable;
    }

    public function execute(string $uniqueIdentifier, string $username)
    {
        // table creation
        $indHouseStarTableCreationStatement = $this->indHouseStar->getTableDef();
        $this->dbmanipulator->create($indHouseStarTableCreationStatement, "T");

        // row insertion
        $indHouseStarRowInsertionStatement = $this->indHouseStar->prepareInsertionStatement($username, $uniqueIdentifier);
        $this->dbmanipulator->create($indHouseStarRowInsertionStatement, "R");
    }
}
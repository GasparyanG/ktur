<?php
namespace BusinessLogic\ActorOnStatement\ProductsOfFactory\DeletionProducts;

use DataBase\Tables\IndHouseStatement;

class IndHouse
{
    public function __construct($configFetcher, $dbmanipulator)
    {
        $this->configFetcher = $configFetcher;
        $this->dbmanipulator = $dbmanipulator;

        $this->indHouseStatement = new IndHouseStatement();
    }

    public function isUsed(string $tableName): bool
    {
        $configuredNameOfTable = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
        return $tableName === $configuredNameOfTable;
    }

    public function execute($uniqueIdentifier): void
    {
        $deletionStatement = $this->indHouseStatement->getDeletionStatement($uniqueIdentifier);
        $this->dbmanipulator->delete($deletionStatement, "R");
    }
}
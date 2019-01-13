<?php
namespace BusinessLogic\ActorOnStatement\ProductsOfFactory\BasketProducts;

use DataBase\Tables\IndHouseBasket as IndHouseBasket;

class IndHouse
{
    public function __construct($configFetcher, $dbmanipulator)
    {
        $this->configFetcher = $configFetcher;
        $this->dbmanipulator = $dbmanipulator;

        $this->indHouseBasket = new IndHouseBasket();
    }

    public function isUsed(string $tableName): bool
    {
        $configuredNameOfTable = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
        return $tableName === $configuredNameOfTable;
    }

    public function execute(string $uniqueIdentifier, string $username): void
    {
        if ($this->alreadyInBasket($uniqueIdentifier, $username)) {
            return;
        }

        // table creation
        $tableCreationStatement = $this->indHouseBasket->getTableDef();
        $this->dbmanipulator->create($tableCreationStatement, "T");

        // row Insertion
        $rowInsertionStatement = $this->indHouseBasket->prepareInsertionStatement($uniqueIdentifier, $username);
        $this->dbmanipulator->create($rowInsertionStatement, "R");
    }

    private function alreadyInBasket(string $uniqueIdentifier, $username)
    {
        $statement = $this->indHouseBasket->checkUserBasketState($uniqueIdentifier, $username);
        $userStaredStatement = $this->dbmanipulator->read($statement, "O");

        if ($userStaredStatement) {
            return true;
        }

        return false;
    }
}
<?php
namespace BusinessLogic\ActorOnStatement\ProductsOfFactory\StarProducts;

use DataBase\Tables\IndHouseStar as IndHouseStar;
use BusinessLogic\ActorOnStatement\Factories\StatementUserFetcherFactory as StatementUserFetcherFactory;

class IndHouse
{
    public function __construct($configFetcher, $dbmanipulator)
    {
        // dynamic object
        $this->usernameFetcher = null;

        // injected
        $this->configFetcher = $configFetcher;
        $this->dbmanipulator = $dbmanipulator;
        
        // statically inited
        $this->statementUserFetcherFactory = new StatementUserFetcherFactory();
        $this->indHouseStar = new IndHouseStar();
    }

    public function isUsed(string $tableName): bool
    {
        $this->usernameFetcher = $this->statementUserFetcherFactory->create($tableName);

        $configuredNameOfTable = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
        return $tableName === $configuredNameOfTable;
    }

    public function execute(string $uniqueIdentifier, string $username)
    {
        $alreadyStared = $this->alreadyStared($uniqueIdentifier, $username);
        if ($alreadyStared) {
            return;
        }

        // statement owner
        $statementOwner = $this->usernameFetcher->getStatementOwnerUsername($uniqueIdentifier);

        // table creation
        $indHouseStarTableCreationStatement = $this->indHouseStar->getTableDef();
        $this->dbmanipulator->create($indHouseStarTableCreationStatement, "T");

        // row insertion
        $indHouseStarRowInsertionStatement = $this->indHouseStar->prepareInsertionStatement($statementOwner, $username, $uniqueIdentifier);
        $this->dbmanipulator->create($indHouseStarRowInsertionStatement, "R");

        // to display action immediately
        return "stared";
    }

    private function alreadyStared(string $uniqueIdentifier, string $username)
    {
        $statement = $this->indHouseStar->checkUserStarState($uniqueIdentifier, $username);
        $userStaredStatement = $this->dbmanipulator->read($statement, "O");

        if ($userStaredStatement) {
            return true;
        }

        return false;
    }
}
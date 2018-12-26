<?php
namespace BusinessLogic\ActorOnStatement\ProductsOfFactory\StatementUserFetchers;

use DataBase\Tables\IndHouseStatement as IndHouseStatement;

class IndHouse
{
    public function __construct($configFetcher, $dbmanipulator)
    {
        $this->indHouseStatement = new IndHouseStatement();

        $this->configFetcher = $configFetcher;
        $this->dbmanipulator = $dbmanipulator;
        $this->indHouseStatementTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
    }

    public function isUsed($tableName)
    {
        return $tableName === $this->indHouseStatementTableName;
    }

    public function getStatementOwnerUsername($uniqueIdentifier)
    {
        $statementToGetUsername = $this->indHouseStatement->getStatementsUserName($uniqueIdentifier);
        $userNameInArray = $this->dbmanipulator->read($statementToGetUsername, "O");

        return $userNameInArray['username'];
    }
}
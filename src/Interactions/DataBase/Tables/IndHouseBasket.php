<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class IndHouseBasket implements TableInterface
{
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();
        
        $this->tableName = "ind_house_basket";
        $this->foreignKey = "ind_house_id";

        $this->statementMethodsBasedOnFilter = [
            "regular" => "getRegularStatement",
        ];
    }

    public function getTableDef(): string
    {
        $indHouseTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);

        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            username        VARCHAR(255) NOT NULL,
            ind_house_id    INT NOT NULL,
            statement_to_basket_date DATE NOT NULL,
            FOREIGN KEY (ind_house_id)
                REFERENCES $indHouseTableName (ind_house_id)
                ON DELETE CASCADE
        )";

        return $statement;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    public function prepareInsertionStatement($uniqueIdentifier, string $username): string
    {
        $statementInsertionDate = date("Y-m-d", time());

        $statement = "INSERT INTO $this->tableName(username, ind_house_id, statement_to_basket_date)
        VALUES(\"$username\", \"$uniqueIdentifier\", \"$statementInsertionDate\")";

        return $statement;
    }

    public function getStatement(int $offSetForCurrentStatementType, string $username, string $filter, int $amountOfRowsToBeReturned): string
    {
        $filterBasedMethodName = $this->getFilterBasedMethodName($filter);
        return $this->$filterBasedMethodName($offSetForCurrentStatementType, $username, $amountOfRowsToBeReturned);
    }

    private function getFilterBasedMethodName(string $filter): string
    {
        $filterNameInLowerCase = strtolower($filter);

        if (!isset($this->statementMethodsBasedOnFilter[$filter])) {
            throw new \InvalidArgumentException("$filter is not defined!");
        }

        return $this->statementMethodsBasedOnFilter[$filter];
    }

    private function getRegularStatement($offSetForCurrentStatementType, $username, $amountOfRowsToBeReturned): string
    {
        $statement = "SELECT ind_house_id 
        FROM $this->tableName 
        WHERE username LIKE \"$username\"
        LIMIT $offSetForCurrentStatementType, $amountOfRowsToBeReturned";

        return $statement;
    }
}
<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;

class IndHouseStatement implements TableInterface
{
    public function __construct()
    {
        $this->tableName = "ind_house_statements";
        $this->tablePrimaryKey = "ind_house_id";

        $this->statementMethodsBasedOnFilter = [
            "regular" => "getRegularStatement",
        ];
    }

    public function getTableDef()
    {
        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            ind_house_id        INT AUTO_INCREMENT PRIMARY KEY,
            username            VARCHAR(255) NOT NULL,
            building_area       INT NOT NULL,
            yard_area           INT NOT NULL,
            location            VARCHAR(255) NOT NULL,
            option_over              VARCHAR(255) NOT NULL,
            statement_description       TEXT NOT NULL,
            price               INT NOT NULL,
            amount_of_floors    INT NOT NULL,
            statement_date      DATE NOT NULL,
            title               VARCHAR(255) NOT NULL,
            statement_time      INT NOT NULL
        )";

        return $statement;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getPrimaryKey()
    {
        return $this->tablePrimaryKey;
    }

    public function getStatementDataFetchingStatement($foreignKey)
    {
        $statement = "SELECT * FROM $this->tableName WHERE ind_house_id = \"$foreignKey\"";

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

    private function getRegularStatement(int $offSetForCurrentStatementType, string $username, int $amountOfRowsToBeReturned): string 
    {
        $statement = "SELECT ind_house_id, option_over, title, price 
        FROM $this->tableName 
        WHERE username LIKE \"$username\" 
        LIMIT $offSetForCurrentStatementType, $amountOfRowsToBeReturned";

        return $statement;
    }
}
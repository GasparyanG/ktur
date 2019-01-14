<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;
use DataBase\Tables\IndHouseStar;
use DataBase\Implementations\DBManipulator;
use ClientSideGuru\QueryStringInteraction\GettingQueryStringValues;

class IndHouseStatement implements TableInterface
{
    public function __construct()
    {
        $this->indHouseStar = new IndHouseStar();
        $this->dbmanipulator = new DBManipulator();

        $this->tableName = "ind_house_statements";
        $this->tablePrimaryKey = "ind_house_id";

        $this->statementMethodsBasedOnFilter = [
            "regular" => "getRegularStatement",
            "resent-added" => "getResentAddedStatement",
            "most-stared" => "getMoreStaredStatement",
            "advanced-search" => "getAdvancedSearchStatement",
            "string-based-search" => "getStringBasedStatement",
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

    public function getStatement(int $offSetForCurrentStatementType, string $username, string $filter, int $amountOfRowsToBeReturned, array $arrayOfFilters = null): string
    {
        $filterBasedMethodName = $this->getFilterBasedMethodName($filter);
        return $this->$filterBasedMethodName($offSetForCurrentStatementType, $username, $amountOfRowsToBeReturned, $arrayOfFilters);
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
        $statement = "SELECT ind_house_id, option_over, title, price, username
        FROM $this->tableName 
        WHERE username LIKE \"$username\" 
        LIMIT $offSetForCurrentStatementType, $amountOfRowsToBeReturned";

        return $statement;
    }

    private function getResentAddedStatement(int $offSetForCurrentStatementType, string $username, int $amountOfRowsToBeReturned): string
    {
        $statement = "SELECT ind_house_id, option_over, title, price, username
        FROM $this->tableName
        WHERE username LIKE \"$username\"
        ORDER BY statement_time DESC
        LIMIT $offSetForCurrentStatementType, $amountOfRowsToBeReturned";

        return $statement;
    }

    public function getMoreStaredStatement(int $offSetForCurrentStatementType, string $username, int $amountOfRowsToBeReturned): string
    {
        $moreStaredStatementsStatement = $this->indHouseStar->mostStaredStatementPreparing($username);

        $indHouseIdsInString = $this->getindHouseIdsInString($moreStaredStatementsStatement);

        $statement = "SELECT ind_house_id, option_over, title, price, username
        FROM $this->tableName
        WHERE username LIKE \"$username\" AND
        ind_house_id IN " . "(" . $moreStaredStatementsStatement . ") " .
        "ORDER BY FIELD(ind_house_id, " . $indHouseIdsInString . ")
        LIMIT $offSetForCurrentStatementType, $amountOfRowsToBeReturned";

        return $statement;    
    }

    public function selectRow(int $indHouseId): string
    {
        $statement = "SELECT ind_house_id, option_over, title, price, username
        FROM $this->tableName 
        WHERE ind_house_id = $indHouseId";

        return $statement;
    }

    public function getStatementsUserName(int $uniqueIdentifier): string
    {
        $statement = "SELECT username FROM $this->tableName WHERE ind_house_id = $uniqueIdentifier";

        return $statement;
    }

    public function getStatementStarRequiredData($uniqueIdentifier)
    {
        $statement = "SELECT ind_house_id, title FROM $this->tableName WHERE ind_house_id = $uniqueIdentifier";

        return $statement;
    }

    private function getindHouseIdsInString(string $moreStaredStatementsStatement): string
    {
        $moreStaredStatements = $this->dbmanipulator->read($moreStaredStatementsStatement, "A");

        $indHouseIdsInString = "";
        $cycle = 0;
        foreach($moreStaredStatements as $nestedArray) {
            if (count($moreStaredStatements) - 1 === $cycle) {
                $indHouseIdsInString .= $nestedArray["ind_house_id"];
            }

            else {
                $indHouseIdsInString .= $nestedArray["ind_house_id"] . ",";
            }

            $cycle++;
        }

        return $indHouseIdsInString;
    }

    public function getAdvancedSearchStatement(int $offSetForCurrentStatementType, string $username, int $amountOfRowsToBeReturned, array $arrayOfFilters): string
    {
        $filtersValueGetter = new GettingQueryStringValues($arrayOfFilters);
        $location = $filtersValueGetter->getLocation();
        $optionOver = $filtersValueGetter->getRentSell();
        $minPrice = $filtersValueGetter->getMinPrice();
        $maxPrice = $filtersValueGetter->getMaxPrice();

        $statement = "SELECT ind_house_id, option_over, title, price, username
        FROM $this->tableName
        WHERE location LIKE \"$location\" AND option_over LIKE \"$optionOver\" AND price >= $minPrice AND price <= $maxPrice";

        return $statement;
    }

    public function getStringBasedStatement(int $offSetForCurrentStatementType, string $username, int $amountOfRowsToBeReturned, array $arrayOfFilters): string
    {
        $stringToSearchWith = $arrayOfFilters["statement-being-searched"];

        $statement = "SELECT ind_house_id, option_over, title, price, username
        FROM $this->tableName
        WHERE location LIKE \"%$stringToSearchWith%\" OR title LIKE \"%$stringToSearchWith%\"";

        return $statement;
    }

    public function getDeletionStatement($uniqueIdentifier): string
    {
        $statement = "DELETE FROM $this->tableName
        WHERE ind_house_id = \"$uniqueIdentifier\"";
        
        return $statement;
    }

    public function getSimilarRequredStatement($uniqueIdentifier): string
    {
        $statement = "SELECT ind_house_id, option_over, price, location
        FROM $this->tableName
        WHERE ind_house_id = \"$uniqueIdentifier\"";

        return $statement;
    }
}
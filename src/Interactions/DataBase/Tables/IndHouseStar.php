<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class IndHouseStar implements TableInterface
{
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();
        $this->tableName = "ind_house_stars";
        $this->foreignKey = "ind_house_id";
    }

    public function getTableDef(): string
    {
        $indHouseTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);

        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            statement_owner VARCHAR(255) NOT NULL,
            username VARCHAR(255) NOT NULL,
            ind_house_id INT NOT NULL,
            star_date DATE NOT NULL,
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

    public function prepareInsertionStatement($statementOwner, $username, $indHouseId): string
    {
        $starDate = date("Y-m-d", time());

        $statement = "INSERT INTO $this->tableName(statement_owner, username, ind_house_id, star_date)
        VALUES(\"$statementOwner\", \"$username\", \"$indHouseId\", \"$starDate\")";

        return $statement;
    }

    public function getStaredStatementUniqueIdentiferFetchingStatement(int $offSetForCurrentStatementType, int $amountOfStatements, string $username): string
    {
        $statement = "SELECT ind_house_id
        FROM $this->tableName
        WHERE username = \"$username\" 
        GROUP BY ind_house_id
        ORDER BY COUNT(ind_house_id) DESC
        LIMIT $offSetForCurrentStatementType, $amountOfStatements";

        return $statement;
    }

    public function getUniqueIdentifierKey()
    {
        return $this->foreignKey;
    }

    public function countStarStatementPreparing($uniqueIdentifier): string
    {
        $statement = "SELECT COUNT(ind_house_id) as ind_house_id 
        FROM $this->tableName 
        WHERE ind_house_id = $uniqueIdentifier";
        
        return $statement;
    }
}
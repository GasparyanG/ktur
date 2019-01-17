<?php
namespace DataBase\Tables;

use DataBase\Interfaces\TableInterface as TableInterface;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class IndHouseComments implements TableInterface
{
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();

        $this->tableName = "ind_house_comments";
        $this->foreignKey = "ind_house_id";
    }

    public function getTableDef(): string
    {
        $indHouseTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);

        $statement = "CREATE TABLE IF NOT EXISTS $this->tableName(
            username        VARCHAR(255) NOT NULL,
            ind_house_id    INT NOT NULL,
            comment         TEXT NOT NULL,
            comment_time    INT NOT NULL,
            FOREIGN KEY (ind_house_id)
                REFERENCES $indHouseTableName (ind_house_id)
                ON DELETE CASCADE
        )";

        return $statement;
    }

    public function getCommentAdditionStatement($uniqueIdentifier, string $username, string $comment): string
    {
        $timeOfAddtion = time();

        $statement = "INSERT INTO $this->tableName(username, ind_house_id, comment, comment_time)
        VALUES (\"$username\", \"$uniqueIdentifier\", \"$comment\", $timeOfAddtion)";

        return $statement;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getCommentsOfStatement($uniqueIdentifier): string
    {
        $statement = "SELECT username, ind_house_id, comment, comment_time
        FROM $this->tableName
        WHERE ind_house_id = \"$uniqueIdentifier\"
        ORDER BY comment_time DESC";

        return $statement;
    }

    public function getAmountOfCommentsStatement($uniqueIdentifier): string
    {
        $statement = "SELECT count(comment) as amount_of_comments 
        FROM $this->tableName
        WHERE ind_house_id = \"$uniqueIdentifier\"";

        return $statement;
    }

    public function userCommentStatement($uniqueIdentifier, $username): string
    {
        $statement = "SELECT comment_time 
        FROM $this->tableName 
        WHERE username = \"$username\" AND ind_house_id = \"$uniqueIdentifier\"
        LIMIT 1";

        return $statement;
    }
}
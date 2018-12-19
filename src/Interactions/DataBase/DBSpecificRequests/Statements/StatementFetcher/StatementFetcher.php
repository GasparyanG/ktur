<?php
namespace DataBase\DBSpecificRequests\Statements\StatementFetcher;

use DataBase\Implementations\DBManipulator as DBManipulator;

class StatementFetcher
{
    public function __construct()
    {
        $this->dbmanipulator = new DBManipulator();

        $this->tablesMainNamespace = "DataBase\Tables\\";

        $this->tablesDefinition = [
            "ind_house_statements" => "IndHouseStatement",
        ];
    }

    public function getStatementData($foreignKey, string $tableName): array
    {
        $tableName = strtolower($tableName);

        if (!isset($this->tablesDefinition[$tableName])) {
            throw new \InvalidArgumentException("$tableName is not defind to add one checkout StatementFetcher.php file");
        }

        $fullyQualifiedNamespace = $this->tablesMainNamespace . $this->tablesDefinition[$tableName];
        $tableDefinition = new $fullyQualifiedNamespace();

        $statement = $tableDefinition->getStatementDataFetchingStatement($foreignKey);
        return $this->dbmanipulator->read($statement, "A");
    }
}
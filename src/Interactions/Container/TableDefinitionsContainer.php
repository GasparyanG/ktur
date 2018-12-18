<?php
namespace Interactions\Container;

class TableDefinitionsContainer
{
    public function __construct()
    {
        $this->tablesDirectory = "DataBase\Tables\\";

        $this->tables = [
            "ind_house_statements" => "IndHouseStatement",
            "Independent_house_photos" => "IndependentHousePhotos",
        ];
    }

    public function getTable(string $tableName)
    {
        $tableFullyQualifiedNamespace = $this->getFullyQualifiedNamespace($tableName);
        $table = new $tableFullyQualifiedNamespace();

        return $table;
    }

    private function getFullyQualifiedNamespace(string $tableName): string
    {
        if (!isset($this->tables[$tableName])) {
            throw new \InvalidArgumentException("$tableName is not defined");
        }

        $fullyQualifiedNamespace = $this->tablesDirectory . $this->tables[$tableName];

        return $fullyQualifiedNamespace;
    }
}
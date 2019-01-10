<?php
namespace DataBase\DBSpecificRequests\Statements\ImageFetcher;

use DataBase\Implementations\DBManipulator as DBManipulator;

class ImageFetcher
{
    public function __construct()
    {
        $this->dbmanipulator = new DBManipulator();
        $this->tablesMainNamespace = "DataBase\Tables\\";

        $this->tableNameObjectMapping = [
            "independent_house_photos" => "IndependentHousePhotos",
        ];
    }

    public function getImageFileNames($foreignKey, string $tableName): array
    {
        $tableName = strtolower($tableName);

        if (!isset($this->tableNameObjectMapping[$tableName])) {
            throw new \InvalidArgumentException("$tableName is not supported; visit this object and add one");
        }

        $fullyQualifiedNamespace = $this->tablesMainNamespace . $this->tableNameObjectMapping[$tableName];
        $tableDefinition = new $fullyQualifiedNamespace();

        $statement = $tableDefinition->getFileNamesFetchingStatement($foreignKey);
        $assocArrayOfImageFileNames = $this->dbmanipulator->read($statement, "A");

        return $assocArrayOfImageFileNames;
    }
}
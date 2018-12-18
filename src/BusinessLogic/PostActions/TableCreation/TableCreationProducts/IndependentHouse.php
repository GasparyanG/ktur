<?php
namespace BusinessLogic\PostActions\TableCreation\TableCreationProducts;

use Interactions\Container\TableDefinitionsContainer as TableDefinitionsContainer;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use DataBase\Implementations\DBManipulator as DBManipulator;
use BusinessLogic\FileSystemManipulation\SpecificImplementors\ClientSideImageGuru as ClientSideImageGuru;

class IndependentHouse
{
    public function __construct()
    {
        $this->dbmanipulator = new DBManipulator();
        $this->tableDefCont = new TableDefinitionsContainer();
        $this->configFetcher = new ConfigFetcher();
        $this->clientSideImageGuru = new ClientSideImageGuru();
    }

    public function isUsed(string $statementType): bool
    {
        return $statementType === "independent-house";
    }

    public function execute(array $statementFormData, array $routeInfo)
    {
        // TABLE CREATION
        // Independent house statement
        $indHouseStatement = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
        $indHouseTable = $tableDefCont->getTable($indHouseStatement);
        $indHouseTableStatement = $indHouseTable->getTableDef();
        $this->dbmanipulator->create($indHouseTableStatement, "T");
        // Independent house photos
        $indHousePhotos = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "Independent_house_photos"]);
        $indHousePhotosTable = $tableDefCont->getTable($indHousePhotos);
        $indHousePhotosTableStatement = $indHousePhotosTable->getTableDef();
        $this->dbmanipulator->create($indHousePhotosTableStatement, "T");

        // ROW INSERTION
        $indHouseRowInsertionStatement = $this->getIndHouseRowInsertionStatement($statementFormData, 
            $indHouseTable->getTableName(), $routeInfo);
        // dbmanipulator returns last inserted id if new row is inserted!
        $lastInsertedId = $this->dbmanipulator->create($indHouseRowInsertionStatement, "R");
        
        // insert photos to corresponding table!
        $saveTo = $this->clientSideImageGuru->getSaveToArray($statementFormData);
        foreach($saveTo as $fileName) {
            $photoTableStatement = $this->getPhotoTableStatement($fileName, $lastInsertedId, $indHousePhotos->getTableName());
            $this->dbmanipulator->create($photoTableStatement, "R");
        }
    }

    private function getIndHouseRowInsertionStatement(array $statementFormData, string $tableName, array $routeInfo): string
    {
        /*
           'buildingArea' : $scope.buildingArea,
           'floorAmount' : $scope.floorAmount,
           'price' : $scope.price,
           'yardArea' : $scope.yardArea,
           'statementTextArea' : $scope.statementTextArea,
           'rentSell' : $scope.rentSell ? $scope.rentSell : 0,
           'location' : $scope.location ? $scope.location : 0,
           'image-upload' : filesState 
        */

        $username = $routeInfo["user-name"];
        $buildingArea = $statementFormData["buildingArea"];
        $floorAmount = $statementFormData["floorAmount"];
        $price = $statementFormData["price"];
        $yardArea = $statementFormData["yardArea"];
        $option = $statementFormData["rentSell"];
        $description = $statementFormData["statementTextArea"];
        $location = $statementFormData["location"];
        $statementDate = $this->getDateInSqlFormat();
        $title = $statementFormData["title"];

        // ind_house_id will be generated automatically
        $statement = "INSERT INTO TABLE $tableName(username, building_area, yard_area, 
        location, option, description, price, amount_of_floors, statement_date, title)
        VALUES
        (\"$username\", \"$buildingArea\", 
        \"$yardArea\", \"$location\", 
        \"$option\", \"$description\", 
        \"$price\", \"$floorAmount\",
        \"$statementDate\", \"$title\")";
    }

    private function getDateInSqlFormat()
    {
        return date("Y-m-d", time());
    }

    private function getPhotoTableStatement(string $fileName, int $lastInsertedId, string $tableName)
    {
        $statement = "INSERT INTO TABLE $tableName(statement_id, file_name)
                    VALUES
                    (\"$lastInsertedId\", \"$fileName\")";

        return $statement;
    }
}
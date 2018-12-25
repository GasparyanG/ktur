<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\Common;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use RESTfull\SpecificImplementations\ActionsOverStatement\HATEOASReady as HATEOASReady;
use DataBase\Implementations\DBManipulator as DBManipulator;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\AbstractFactory\AbstractFactory as AbstractFactory;

class RequiredDataStructureConstructor
{
    public function __construct()
    {
        $this->abstractFactory = new AbstractFactory();
        $this->supporter = null;

        $this->configFetcher = new ConfigFetcher();
        $this->hready = new HATEOASReady();
        $this->dbmanipulator = new DBManipulator();
        $this->jsonPrepareness = new JsonPrepareness();
    }

    public function constructDataStructure(array $dataFromTableQuery, string $statementType): array
    {
        $this->supporter = $this->abstractFactory->create($statementType);
        
        $arrayToBeReturned = [];
        $refer = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "refer"]);
        $action = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "action"]);
        $data = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "data"]);
        
        $individualArray = [];
        foreach($dataFromTableQuery as $nestedArray) {
            $uniqueIdentifier = $nestedArray[$this->supporter->getStatementInfoHoldingObject()->getPrimaryKey()];
            $individualArray[$refer] = $this->getReferences($uniqueIdentifier);
            $individualArray[$action] = $this->hready->getPreparedArray($this->supporter->getStatementInfoHoldingObject()->getTableName(), $uniqueIdentifier);
            $individualArray[$data] = $nestedArray;
            $arrayToBeReturned[] = $individualArray;
        }

        return $arrayToBeReturned;
    }

    private function getReferences($uniqueIdentifier): array
    {
        $arrayOfRestfullReferences = [];

        $arrayOfRestfullReferences[] = $this->getImageReference($uniqueIdentifier);
        $arrayOfRestfullReferences[] = $this->getReferenceToSelf($uniqueIdentifier);

        return $arrayOfRestfullReferences;
    }

    private function getImageReference($uniqueIdentifier): array
    {
        $photoFileNameFetchingStatement = $this->supporter->getPhotosStatement($uniqueIdentifier);
        $assocArrayOfImageFileNames = $this->dbmanipulator->read($photoFileNameFetchingStatement, "O");

        $fileName = $assocArrayOfImageFileNames["file_name"];

        $photosDir = $this->configFetcher->fetchConf("URI_CONFIG", ["photos", "statement_photos", "directory"]);
        $pathToResource = $photosDir . $fileName;

        $preparedToBeConverted = $this->jsonPrepareness->makeHrefRestfull($pathToResource, "image");

        return $preparedToBeConverted;
    }

    private function getReferenceToSelf($uniqueIdentifier): array
    {
        $pathToResource = $this->supporter->getPathToResource($uniqueIdentifier);
        $preparedToBeConverted = $this->jsonPrepareness->makeHrefRestfull($pathToResource, "self");

        return $preparedToBeConverted;
    }
}
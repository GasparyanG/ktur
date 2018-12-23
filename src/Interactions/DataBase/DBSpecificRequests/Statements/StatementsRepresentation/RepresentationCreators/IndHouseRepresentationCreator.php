<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\RepresentationCreators;

use DataBase\Tables\IndHouseStatement as IndHouseStatement;
use DataBase\Interactions\DBManipulator as DBManipulator;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use RESTfull\SpecificImplementations\ActionsOverStatement\HATEOASReady as HATEOASReady;
use DataBase\Tables\IndependentHousePhotos as IndependentHousePhotos;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;

class IndHouseRepresentationCreator
{
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();
        $this->dbmanipulator = new DBManipulator();
        $this->indHouseStatement = new IndHouseStatement();
        $this->hready = new HATEOASReady();
        $this->indHousePhotos = new IndependentHousePhotos();
        $this->jsonPrepareness = new JsonPrepareness();

        // this is needed to limit amount of rows
        $this->amountOfRowsToBeReturnedFromTables = 10;
    }

    /**
     * prepare data (nested assoc array) and return to caller
     * 
     * @param int $offSetForCurrentStatementType is needed to get data from db starting from this variable's value. This will be sent from client side.
     * @param string $username get user relative data from db tables
     * @param string|null $filter more options to get desired data from database
     * 
     * @return array 
     */
    public function prepareData(int $offSetForCurrentStatementType, string $username, string $filter): array
    {
        $arrayToBeReturned = [];
        $refer = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "refer"]);
        $action = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "action"]);
        $data = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "data"]);

        // based on this statement other data will be fetched!
        $startingPointStatement = $this->indHouseStatement->getStatement($offSetForCurrentStatementType, $username, $filter, $this->amountOfRowsToBeReturnedFromTables);

        $dataFromIndHouseStatementQuery = $this->dbmanipulator->read($startingPointStatement, "A");

        foreach($dataFromIndHouseStatementQuery as $nestedArray) {
            $primaryKey = $nestedArray[$this->indHouseStatement->getPrimaryKey()];
            $arrayToBeReturned[$refer] = $this->getReferences($primaryKey);
            $arrayToBeReturned[$action] = $this->hready->getPreparedArray($this->indHouseStatement->getTableName(), $primaryKey);
            $arrayToBeReturned[$data] = $nestedArray;
        }

        return $arrayToBeReturned;
    }

    // this need to be separated from this object !
    private function getReferences($primaryKey): array
    {
        $arrayOfRestfullReferences = [];

        $arrayOfRestfullReferences[] = $this->getImageReference($primaryKey);
        $arrayOfRestfullReferences[] = $this->getReferenceToSelf($primaryKey);
    }

    private function getImageReference($primaryKey): array
    {
        $photoFileNameFetchingStatement = $this->indHousePhotos->getFileNamesFetchingStatement($primaryKey);
        $assocArrayOfImageFileNames = $this->dbmanipulator->read($photoFileNameFetchingStatement, "O");

        $fileName = $assocArrayOfImageFileNames["file_name"];

        $photosDir = $this->configFetcher->fetchConf("URI_CONFIG", ["photos", "statement_photos", "directory"]);
        $pathToResource = $photosDir . $fileName;

        $preparedToBeConverted = $this->jsonPrepareness->makeHrefRestfull($pathToResource, "image");

        return $preparedToBeConverted;
    }

    private function getReferenceToSelf($primaryKey): array
    {
        $pathToResource = $this->configFetcher->fetchConf("URI_CONFIG", ["uri_pathes", "ind-house-statement"]) . "/" . $primaryKey;
        $preparedToBeConverted = $this->jsonPrepareness->makeHrefRestfull($pathToResource, "self");

        return $preparedToBeConverted;
    }
}
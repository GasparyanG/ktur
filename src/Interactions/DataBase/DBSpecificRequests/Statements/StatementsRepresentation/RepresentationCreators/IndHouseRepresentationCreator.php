<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\RepresentationCreators;

use DataBase\Tables\IndHouseStatement as IndHouseStatement;
use DataBase\Implementations\DBManipulator as DBManipulator;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use RESTfull\SpecificImplementations\ActionsOverStatement\HATEOASReady as HATEOASReady;
use DataBase\Tables\IndependentHousePhotos as IndependentHousePhotos;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;

use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\Common\RequiredDataStructureConstructor as RequiredDataStructureConstructor;

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

        $this->requiredDataStructureConstructor = new RequiredDataStructureConstructor;

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
    public function prepareData(int $offSetForCurrentStatementType, string $username, string $filter, array $arrayOfFilters = null): array
    {
        // based on this statement other data will be fetched!
        $startingPointStatement = $this->indHouseStatement->getStatement($offSetForCurrentStatementType, $username, $filter, $this->amountOfRowsToBeReturnedFromTables, $arrayOfFilters);

        $dataFromIndHouseStatementQuery = $this->dbmanipulator->read($startingPointStatement, "A");

        return $this->requiredDataStructureConstructor->constructDataStructure($dataFromIndHouseStatementQuery, "ind_house");
    }
}    
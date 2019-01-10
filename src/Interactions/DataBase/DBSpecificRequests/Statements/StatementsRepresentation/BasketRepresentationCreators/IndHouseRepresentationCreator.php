<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\BasketRepresentationCreators;

use DataBase\Tables\IndHouseBasket as IndHouseBasket;
use DataBase\Implementations\DBManipulator as DBManipulator;
use DataBase\Tables\IndHouseStatement as IndHouseStatement;

use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\Common\RequiredDataStructureConstructor as RequiredDataStructureConstructor;

class IndHouseRepresentationCreator
{
    public function __construct()
    {
        $this->indHouseStatement = new IndHouseStatement();
        $this->indHouseBasket = new IndHouseBasket();
        $this->dbmanipulator = new DBManipulator();

        $this->requiredDataStructureConstructor = new RequiredDataStructureConstructor;

        $this->amountOfRowsToBeReturned = 10;
    }

    public function prepareData(int $offSetForCurrentStatementType, string $username, string $filter): array
    {
        $statementBasedOnFilter = $this->indHouseBasket->getStatement($offSetForCurrentStatementType, $username, $filter, $this->amountOfRowsToBeReturned);
        // array of data from basket, which nested arrays will store statement's id
        $arrayOfBasketData = $this->dbmanipulator->read($statementBasedOnFilter, "A");
        $arrayFullOfStatementsData = $this->getStatementsData($arrayOfBasketData);

        return $this->requiredDataStructureConstructor->constructDataStructure($arrayFullOfStatementsData, "ind_house");
        // this array have to be valid for client side renderer!
    }

    private function getStatementsData(array $arrayOfBasketData): array
    {
        $arrayFullOfStatementsData = [];
        foreach($arrayOfBasketData as $nestedArrays) {
            $indHouseId = $nestedArrays[$this->indHouseBasket->getForeignKey()];
            $statementForRowSelection = $this->indHouseStatement->selectRow($indHouseId);

            $arrayFullOfStatementsData[] = $this->dbmanipulator->read($statementForRowSelection, "O");
        }

        return $arrayFullOfStatementsData;
    }
}
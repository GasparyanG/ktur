<?php
namespace BusinessLogic\ActorOnStatement;

use BusinessLogic\ActorOnStatement\Factories\StarFactory as StarFactory;
use BusinessLogic\ActorOnStatement\Factories\BasketFactory as BasketFactory;
use ClientSideGuru\Statement\ConstraintFetcher as ConstraintFetcher;
use BusinessLogic\ActorOnStatement\Factories\SeeStarsFactory as SeeStarsFactory;
use DataBase\Implementations\DBManipulator as DBManipulator;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use Augmention\Convertion\JsonConverter as JsonConverter;
use BusinessLogic\ActorOnStatement\Factories\DeletionFactory;

class ActorOnStatement
{
    public function __construct()
    {
        $this->starFactory = new StarFactory();
        $this->basketFactory = new BasketFactory();
        $this->SeeStarsFactory = new SeeStarsFactory();
        $this->constraintFetcher = new ConstraintFetcher();
        $this->dbmanipulator = new DBManipulator();
        $this->jsonPrepareness = new JsonPrepareness();
        $this->jsonConverter = new JsonConverter();
        $this->deletionFactory = new DeletionFactory();

        $this->amountToBeReturned = 10;
    }

    public function star($req, $res, $routeInfo)
    {
        $this->cutAction($req, $res);

        $username = $req->getCookieParams()['username'];
        $tableName = $routeInfo["table-name"];
        $uniqueIdentifier = $routeInfo["unique-identifier"];

        $this->starFactory->addStar($tableName, $uniqueIdentifier, $username);
    }

    public function basket($req, $res, $routeInfo)
    {
        $this->cutAction($req, $res);

        $username = $req->getCookieParams()['username'];
        $tableName = $routeInfo["table-name"];
        $uniqueIdentifier = $routeInfo['unique-identifier'];

        $this->basketFactory->addStatementToBasket($tableName, $uniqueIdentifier, $username);
    }

    public function seeStars($req, $res, $routeInfo)
    {
        $offSet = $this->constraintFetcher->getArrayOfOffsets();
        
        $tableName = $routeInfo['table-name'];
        $uniqueIdentifier = $routeInfo['unique-identifier'];

        $tableDefinition = $this->SeeStarsFactory->create($tableName);
        $statement = $tableDefinition->getUsersBasedOnUniqueIdentifier($uniqueIdentifier, $offSet, $this->amountToBeReturned);

        $usernamesArray = $this->dbmanipulator->read($statement, "A");
        
        $arrayToBeConverted = [];
        foreach($usernamesArray as $nestedArray) {
            $staredUsername = $nestedArray['username'];
            $pathToUser = "/" . $staredUsername;

            $arrayToBeConverted["metadata"][] = $this->jsonPrepareness->makeHrefRestfull($pathToUser, "self", $staredUsername);
        }

        echo $this->jsonConverter->convertArrayToJson($arrayToBeConverted);
    }

    private function cutAction($req, $res)
    {
        /*if (isset($req->getCookieParams()['username'])) {
            if ($req->getCookieParams()['username'] === null) {
                echo "redirect";
                exit;
            }
        }*/

        if(!isset($req->getCookieParams()['username'])) {
            echo "redirect";
            exit;
        }
    }

    public function delete($req, $res, $routeInfo)
    {
        $tableName = $routeInfo['table-name'];
        $uniqueIdentifier = $routeInfo['unique-identifier'];

        $this->deletionFactory->deleteStatement($tableName, $uniqueIdentifier);
    }
}
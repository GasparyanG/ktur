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
use BusinessLogic\PostActions\Comment\Factory\StatementCommentHandlerFactory;
use DataBase\Tables\UserComponents;
use RESTfull\HATEOSA\HateSupporter;

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
        $this->statementCommentHandlerFactory = new StatementCommentHandlerFactory();
        $this->userComponents = new UserComponents();
        $this->hsup = new HateSupporter();

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

    public function commentOnStatement($req, $res, $routeInfo)
    {
        $this->cutAction($req, $res);

        $tableName = $routeInfo["table-name"];
        $uniqueIdenitifier = $routeInfo["unique-identifier"];
        $username = $req->getCookieParams()['username'];

        $comment = $this->jsonConverter->jsonDecodeWithFileGetContents();
        if (count($comment) === 0) {
            // no comment at all
            $comment = "";
        }
        
        else {
            // this key is set in comment-controller.js
            $comment = $comment["comment"];
        }

        $desiredStatementImplementer = $this->statementCommentHandlerFactory->create($tableName);

        // true or false
        $resultFromCommentAddition = $desiredStatementImplementer->addComment($uniqueIdenitifier, $username, $comment);
        
        if ($resultFromCommentAddition === true) {
            $arrayToBeConverted = [];
            $arrayToBeConverted["state"] = "true";
            $arrayToBeConverted["username"] = $username;
            $arrayToBeConverted["comment"] = $comment;
            // userhref
            $userPath = "/" . $username;
            $arrayToBeConverted["user_data"] = $this->jsonPrepareness->makeHrefRestfull($userPath, "self", $username);
            // user image url prepareness
            // user_image_path
            $preperedStatement = $this->userComponents->getUserPhotoPreparingStatement($username);
            $photoInArray = $this->dbmanipulator->read($preperedStatement, "O");
            $photo = $photoInArray["user_image"];
            $pathToDefaultUserPhotoDir = $this->hsup->combinePathSegments(["photos", "user", "default"], $photo);
            $arrayToBeConverted["user_image_path"] = $this->jsonPrepareness->makeHrefRestfull($pathToDefaultUserPhotoDir, "photo");

            echo $this->jsonConverter->convertArrayToJson($arrayToBeConverted);
        }

        elseif (is_array($resultFromCommentAddition)) {
            echo $this->jsonConverter->convertArrayToJson($resultFromCommentAddition);
        }
    }
}
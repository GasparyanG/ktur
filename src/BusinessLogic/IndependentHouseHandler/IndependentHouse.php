<?php
namespace BusinessLogic\IndependentHouseHandler;

use DataBase\DBSpecificRequests\Statements\ImageFetcher\ImageFetcher as ImageFetcher;
use DataBase\DBSpecificRequests\Statements\StatementFetcher\StatementFetcher as StatementFetcher;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use Augmention\Convertion\JsonConverter as JsonConverter;
use RESTfull\SpecificImplementations\ActionsOverStatement\HATEOASReady as HReady;
use DataBase\Tables\IndHouseStatement;
use DataBase\Implementations\DBManipulator;
use DataBase\Tables\IndHouseComments;
use DataBase\Tables\UserComponents;

class IndependentHouse
{
    public function __construct()
    {
        $this->clientSideData = [
            "title" => "Statement",
        ];

        $this->hready = new HReady();
        $this->jsonPrepareness = new JsonPrepareness();
        $this->imageFetcher = new ImageFetcher();
        $this->configFetcher = new ConfigFetcher();
        $this->jsonConverter = new JsonConverter();
        $this->statementFetcher = new StatementFetcher();
        $this->indHouseStatement = new IndHouseStatement();
        $this->dbmanipulator = new DBManipulator();
        $this->indHouseComments = new IndHouseComments();
        $this->userComponents = new UserComponents();
    }

    public function getStatement($req, $res, $routeInfo)
    {
        $indHouseId = $routeInfo['ind-house-id'];
        $IndHouseStatementTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ['DB1', 'tables', 'ind_house_statements']);
        // because one row is required its obvious that it will be in placed in 0 index (thats why 0 is used at the end of below line)
        $dataFromIndHouseTable = $this->statementFetcher->getStatementData($indHouseId, $IndHouseStatementTableName)[0];

        // comments
        $commentFetchingStatement = $this->indHouseComments->getCommentsOfStatement($indHouseId);
        $comments = $this->dbmanipulator->read($commentFetchingStatement, "A");
        $usersCommentsData = $this->addUsersImages($comments);

        $res->render("/statements/ind-house/main-layout.html", ["title" => $dataFromIndHouseTable['title'], "resources" => $dataFromIndHouseTable, "usersCommentsData" => $usersCommentsData]);
    }

    public function sendRequiredResourcesToClient($req, $res, $routeInfo)
    {
        $restfullArray = [];

        $indHouseId = $routeInfo["ind-house-id"];
        $indHousePhotoTable = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "Independent_house_photos"]);

        $imageFileNames = $this->imageFetcher->getImageFileNames($indHouseId, $indHousePhotoTable);
        $imageDirectory = $this->configFetcher->fetchConf("URI_CONFIG", ["photos", "statement_photos", "directory"]);
        
        foreach($imageFileNames as $nestedArray) {
            foreach($nestedArray as $key => $value) {
                if ($key === "file_name") {
                    $fullPath = $imageDirectory . $value;
                    $restfullArray[] = $this->jsonPrepareness->makeHrefRestfull($fullPath, "statement_image");
                }
            }
        }

        // requred data fetching
        $requiredDataFetchingStatement = $this->indHouseStatement->getSimilarRequredStatement($indHouseId);
        $requiredData = $this->dbmanipulator->read($requiredDataFetchingStatement, "O");

        $restfullArray["requred_data"] = $requiredData;

        // actions over statemnt need to be populated with required href to perform desired functionality:
        // i.e. add star, comment to required table, add item to required basket!
        $indHouseStatementsTable = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
        $actionsOverStatementPreparedForH = $this->hready->getPreparedArray($indHouseStatementsTable ,$indHouseId);

        foreach($actionsOverStatementPreparedForH as $nestArr) {
            $restfullArray[] = $nestArr;
        }

        // other resources also needed to be included into restfullArray!

        echo $this->jsonConverter->convertArrayToJson($restfullArray);
    }

    private function addUsersImages($commentsArray): array
    {
        $arrayToReturn = [];

        if (!$commentsArray) {
            return $arrayToReturn;
        }

        else {
            foreach($commentsArray as $commentArray) {
                $username = $commentArray["username"];
                // fetching iamge of user
                $userPhotoPreapredStatement = $this->userComponents->getUserPhotoPreparingStatement($username);
                $photo = $this->dbmanipulator->read($userPhotoPreapredStatement, "O");
                $commentArray["user_image"] = $photo["user_image"];
                $arrayToReturn[] = $commentArray;
            }

            return $arrayToReturn;
        }
    }
}
<?php
namespace BusinessLogic\IndependentHouseHandler;

use DataBase\DBSpecificRequests\Statements\ImageFetcher\ImageFetcher as ImageFetcher;
use DataBase\DBSpecificRequests\Statements\StatementFetcher\StatementFetcher as StatementFetcher;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use Augmention\Convertion\JsonConverter as JsonConverter;
use RESTfull\SpecificImplementations\ActionsOverStatement\HATEOASReady as HReady;

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
    }

    public function getStatement($req, $res, $routeInfo)
    {
        $indHouseId = $routeInfo['ind-house-id'];
        $IndHouseStatementTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ['DB1', 'tables', 'ind_house_statements']);
        // because one row is required its obvious that it will be in placed in 0 index (thats why 0 is used at the end of below line)
        $dataFromIndHouseTable = $this->statementFetcher->getStatementData($indHouseId, $IndHouseStatementTableName)[0];
        //echo "<pre>";
        //var_dump($dataFromIndHouseTable);

        $res->render("/statements/ind-house/main-layout.html", ["title" => $dataFromIndHouseTable['title'], "resources" => $dataFromIndHouseTable]);
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

        // actions over statemnt need to be populated with required href to perform desired functionality:
        // i.e. add star, comment to required table, add item to required basket!
        $indHouseStatementsTable = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
        $actionsOverStatementPreparedForH = $this->hready->getPreparedArray($indHouseStatementsTable ,$indHouseId);

        foreach($actionsOverStatementPreparedForH as $nestArr) {
            $restfullArray[] = $nestArr;
        }

        // other resources also needed to be included into restfullArry!

        echo $this->jsonConverter->convertArrayToJson($restfullArray);
    }
}
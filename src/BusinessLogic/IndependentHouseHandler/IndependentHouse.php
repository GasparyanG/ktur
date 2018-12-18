<?php
namespace BusinessLogic\IndependentHouseHandler;

use DataBase\DBSpecificRequests\Statements\ImageFetcher\ImageFetcher as ImageFetcher;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use Augmention\Convertion\JsonConverter as JsonConverter;

class IndependentHouse
{
    public function __construct()
    {
        $this->clientSideData = [
            "title" => "Statement",
        ];

        $this->jsonPrepareness = new JsonPrepareness();
        $this->imageFetcher = new ImageFetcher();
        $this->configFetcher = new ConfigFetcher();
        $this->jsonConverter = new JsonConverter();
    }

    public function getStatement($req, $res, $routeInfo)
    {
        $res->render("/statements/ind-house/main-layout.html", ["title" => $this->clientSideData["title"]]);
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

        // other resources also needed to be included into restfullArry!

        echo $this->jsonConverter->convertArrayToJson($restfullArray);
    }
}
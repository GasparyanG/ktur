<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\AbstractFactory\Products;

use DataBase\Tables\IndHouseStatement as IndHouseStatement;
use DataBase\Tables\IndependentHousePhotos as IndependentHousePhotos;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class IndHouseComponents
{
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();
        $this->indHousePhotos = new IndependentHousePhotos();
        $this->indHouseStatement = new IndHouseStatement();
    }

    public function isUsed($statementType)
    {
        return $statementType === "ind_house";
    }

    public function getPathToResource($uniqueIdentifier)
    {
        $pathToResource = $this->configFetcher->fetchConf("URI_CONFIG", ["uri_pathes", "ind-house-statement"]) . "/" . $uniqueIdentifier;
        return $pathToResource;
    }

    public function getPhotosStatement($uniqueIdentifier)
    {
        $photoFileNameFetchingStatement = $this->indHousePhotos->getFileNamesFetchingStatement($uniqueIdentifier);
        return $photoFileNameFetchingStatement;
    }

    public function getStatementInfoHoldingObject()
    {
        return $this->indHouseStatement;
    }
}
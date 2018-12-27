<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\StarsRepresentation;

use DataBase\Tables\IndependentHousePhotos as IndependentHousePhotos;
use DataBase\Tables\IndHouseStar as IndHouseStar;
use DataBase\Tables\IndHouseStatement as IndHouseStatement;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\StarsRepresentation\StarsRepresentationInterface as StarsRepresentationInterface;

class IndHouseStarsRepresentation implements StarsRepresentationInterface
{
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();
    }

    public function getSelfPointingUriSegment():string
    {

        return $this->configFetcher->fetchConf("URI_CONFIG", ["uri_pathes", "ind-house-statement"]);
    }

    public function starsTableDefinition()
    {
        return new IndHouseStar();
    }

    public function statementMetadataTableDefinition()
    {
        return new IndHouseStatement();
    }

    public function statementPhotosTableDefinition()
    {
        return new IndependentHousePhotos();
    }
}
<?php
namespace BusinessLogic\StatementPortions;

use Augmention\Convertion\JsonConverter;
use Interactions\Container\Container;

class Supplier
{
    public function __construct()
    {
        $this->jsonConverter = new JsonConverter();
        $this->container = new Container();
    }

    public function fetchStatementAdditionInfo()
    {
        $assocArrayToPopulateTemplates = [];

        // location need to be included!
        /*  
            sever:
            1) create table which holdes all locations needed
            2) insert locations into table (above mentioned)
            3) get that data form db
            4) add into $assocArrayToPopulateTemplates array with "location" key
            
            clinet:
            1) use $scope.location to get all data relative to location
            2) use ng-repeat to iterate over json's taken value and create select's options
            
         */

        // options to choose from (for rent for sell)
        $assocArrayToPopulateTemplates = $this->container->fetchData("houseoptions", $assocArrayToPopulateTemplates);
        $assocArrayToPopulateTemplates = $this->container->fetchData("locations", $assocArrayToPopulateTemplates);

        $templatePopulatorInJson = $this->jsonConverter->convertArrayToJson($assocArrayToPopulateTemplates);

        return $templatePopulatorInJson;
    }
}
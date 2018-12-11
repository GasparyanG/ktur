<?php
namespace BusinessLogic\PostActions;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use Augmention\Convertion\JsonConverter as JsonConverter;
use Validation\Validator as Validator;

class PostActions
{
    public function __construct()
    {
        $this->clientSideData = [
            'statement-addition' => 'Statement Addition',
        ];

        $this->configFetcher = new ConfigFetcher();
        $this->jsonConverter = new JsonConverter();
    }

    public function getStatementAddition($req, $res, $routeInfo)
    {
        $res->render("/user/post-actions/statement/add-statement.html", ["title" => $this->clientSideData['statement-addition']]);
    }

    public function fetchStatementAdditionInfo($req, $res, $routeInfo)
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
        $optionsOverHouse = $this->configFetcher->fetchConf('OPTIONS_CONFIG', ['house']);

        $assocArrayToPopulateTemplates['options_over_house'] = $optionsOverHouse;

        $templatePopulatorInJson = $this->jsonConverter->convertArrayToJson($assocArrayToPopulateTemplates);

        echo $templatePopulatorInJson;
    }

    public function postAction($req, $res, $routeInfo)
    {
        // objects to rely on
        $validator = new Validator();

        $parsedBodyInJsonFormat = $req->getParsedBody();
        
        //asoc array converted from json
        $parsedBody = $this->jsonConverter->parsedBodyKeyConvertToAssocArray($parsedBodyInJsonFormat);

        foreach($parsedBody as $statementType => $formBody) {
            // one way to fetch key and value from assoc array
        }

        // at the end validator object will contain desired info abour error messages        
    }
}
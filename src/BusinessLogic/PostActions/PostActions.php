<?php
namespace BusinessLogic\PostActions;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use Augmention\Convertion\JsonConverter as JsonConverter;
use Validation\Validator as Validator;
use BusinessLogic\PostActions\ValidationProductFactory\Factory as Factory;
use Interactions\Container\Container as Container;
use BusinessLogic\PostActions\TableCreation\Factory as TableCreationFactory;

class PostActions
{
    public function __construct()
    {
        $this->clientSideData = [
            'statement-addition' => 'Statement Addition',
        ];

        $this->configFetcher = new ConfigFetcher();
        $this->jsonConverter = new JsonConverter();
        $this->factory = new Factory();
        $this->container = new Container();
        $this->tableCreationFactory = new TableCreationFactory();
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
        $assocArrayToPopulateTemplates = $this->container->fetchData("houseoptions", $assocArrayToPopulateTemplates);
        $assocArrayToPopulateTemplates = $this->container->fetchData("locations", $assocArrayToPopulateTemplates);

        $templatePopulatorInJson = $this->jsonConverter->convertArrayToJson($assocArrayToPopulateTemplates);

        echo $templatePopulatorInJson;
    }

    public function postAction($req, $res, $routeInfo)
    {
        // objects to rely on
        $validator = new Validator();

        $parsedBodyInJsonFormat = $req->getParsedBody();

        $jsonFromCleintConvertedToArray = $this->jsonConverter->jsonDecodeWithFileGetContents();

        foreach($jsonFromCleintConvertedToArray as $statementType => $formBody) {
            // one way to fetch key and value from assoc array
        }

        foreach($formBody as $fieldName => $fieldValue) {
            // $validator will store all error messages:
            // $validator->getErrorMessages();
            $this->factory->validate($fieldName, $fieldValue, $validator);
        }

        $errorMessages = $validator->getErrorMessages();

        if ($errorMessages) {
            echo $this->jsonConverter->convertArrayToJson($errorMessages);
            exit;
        }

        // create table and make corresponding insertions!
        $this->tableCreationFactory->makeRecord($statementType, $formBody, $routeInfo);
    }
}